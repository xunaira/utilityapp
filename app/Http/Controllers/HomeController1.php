<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Settings;
use App\Balance;
use Auth;
use Carbon;
use App\Reports;
use App\Transactions;
use App\agents_migration;
use DB;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $comm = Settings::where('type', "self funded agents")->get();

        //Total Sales Today
         $today = DB::table('add_sales')
            ->join('products', 'add_sales.product_id', '=', 'products.id')
            ->join('users', 'add_sales.agent', '=', 'users.agent_id')
            ->selectRaw('SUM(add_sales.sale_value) as sales_value')
            ->where([['status', 'Approved'], ['date', Carbon\Carbon::now()->toDateString()]])
            ->get();

        foreach($today as $t){
            $tday = $t->sales_value;
        }

        //Total Sales this Monthly
        $month = Carbon\Carbon::now()->month;
        
        $monthly = DB::table('add_sales')
            ->join('products', 'add_sales.product_id', '=', 'products.id')
            ->join('users', 'add_sales.agent', '=', 'users.agent_id')
            ->selectRaw('SUM(add_sales.sale_value) as sales_value')
            ->where('status', 'Approved')
            ->whereMonth('date', $month)
            ->get();

        foreach($monthly as $m){
            $mo = $m->sales_value;
        }

        //Total Earnings 
        $earnings = DB::table('add_sales')
            ->join('products', 'add_sales.product_id', '=', 'products.id')
            ->join('users', 'add_sales.agent', '=', 'users.agent_id')
            ->selectRaw('SUM(add_sales.sale_value) as sales_value')
            ->where('status', 'Approved')
            ->get();
        foreach($earnings as $e){
            $earn = $e->sales_value;
        }
        
        //Total Agents 
        if(Auth::user()->role_id == 1){
            $agents = DB::table('agents')
            ->join('supervisor', 'supervisor.user_id', '=', 'agents.supervisor_id')
            ->join('users', 'agents.id', '=', 'users.agent_id')
            ->join('company', 'company.id', '=', 'users.company_id')
            ->select('users.*','agents.*', 'supervisor.name as sup')
            ->where('users.company_id', Auth::user()->company_id)
            ->count();
        }else{
            $agents = DB::table('agents')
            ->join('supervisor', 'supervisor.user_id', '=', 'agents.supervisor_id')
            ->join('users', 'agents.id', '=', 'users.agent_id')
            ->join('company', 'company.id', '=', 'users.company_id')
            ->select('users.*','agents.*', 'supervisor.name as sup')
            ->where([['supervisor_id', Auth::user()->id], ['users.company_id', Auth::user()->company_id]])
            ->count();
        }

        //Agents and their sales 
        $sales = DB::table('agents')
            ->join('add_sales', 'add_sales.agent', '=', 'agents.id')
            ->join('users', 'agents.id', '=', 'users.agent_id')
            ->select(DB::raw('SUM(add_sales.sale_value) as sales'), 'users.name')
            ->groupBy("users.name")
            ->where([['add_sales.status', 'Approved'], ['users.company_id' , Auth::user()->company_id]])
            ->get();

        return view('dashboard.content', ['comm' => $comm, 'agents' => $agents, 'earnings' => $earn, 'mo' => $mo, 'tday' => $tday, 'sales' => $sales]);
    }

    public function getSalesByMonth(){
        $monthly_chart = DB::table('add_sales')
            ->join('products', 'add_sales.product_id', '=', 'products.id')
            ->join('users', 'add_sales.agent', '=', 'users.agent_id')
            ->select(DB::raw('MONTH(DATE) as month, SUM(add_sales.sale_value) as sales'))
            ->groupBy(DB::raw('MONTH(DATE)'))
            ->where('status', 'Approved')
            ->orderBy(DB::raw('MONTH(DATE)', 'DESC'))
            ->get();
        
        foreach($monthly_chart as $m){
            $month[] = $m->month;            
        }
        foreach($month as $mon)
                $name[] = date("F", mktime(0, 0, 0, $mon, 10));

        foreach($monthly_chart as $s){
            $sales[] = $s->sales;
        }

        $data = array_merge([$name], [$sales]);
      

      return response()->json(['monthly' => $data]);
    }
}
