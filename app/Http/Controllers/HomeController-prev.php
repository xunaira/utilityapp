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

        if(Auth::user()->role_id == 1){
            $ag = DB::table('agents')
            ->join('supervisor', 'supervisor.user_id', '=', 'agents.supervisor_id')
            ->join('users', 'agents.id', '=', 'users.agent_id')
            ->join('company', 'company.id', '=', 'users.company_id')
            ->select('users.*','agents.*', 'supervisor.name as sup')
            ->where('users.company_id', Auth::user()->company_id)
            ->get();
        }else{
            $ag = DB::table('agents')
            ->join('supervisor', 'supervisor.user_id', '=', 'agents.supervisor_id')
            ->join('users', 'agents.id', '=', 'users.agent_id')
            ->join('company', 'company.id', '=', 'users.company_id')
            ->select('users.*','agents.*', 'supervisor.name as sup')
            ->where([['supervisor_id', Auth::user()->id], ['users.company_id', Auth::user()->company_id]])
            ->get();
        }

        //Agents and their sales 
        // $sales = DB::table('agents')
        //     ->join('users', 'agents.id', '=', 'users.agent_id')
        //     ->join('company', 'company.id', '=', 'users.company_id')
        //     ->join('transactions', 'transactions.agent_id', '=', 'agents.id')
        //     ->join('add_sales', 'add_sales.agent', '=', 'agents.id')
        //     ->select('users.*','agents.*', DB::raw("SUM(add_sales.sale_value"))
        //     ->where('users.company_id', Auth::user()->company_id)
        //     ->groupBy('add_sales.sale_value')
        //     ->get();
        // dd($sales);
        //Get agent name and total sales for this month
        $sales = DB::table('agents')
            ->join('add_sales', 'add_sales.agent', '=', 'agents.id')
            ->join('users', 'agents.id', '=', 'users.agent_id')
            ->select(DB::raw('SUM(add_sales.sale_value) as sales'), 'users.name')
            ->groupBy("users.name")
            ->where([['add_sales.status', 'Approved'], ['users.company_id' , Auth::user()->company_id]])
            ->get();
        
        $target = DB::table('agents')
            ->join('add_sales', 'add_sales.agent', '=', 'agents.id')
            ->join('users', 'agents.id', '=', 'users.agent_id')
            ->join('agent_target', 'agents.id', '=', 'agent_target.user_id')
            ->select(DB::raw('SUM(add_sales.sale_value) as sales'), 'users.name', 'agent_target.target')
            ->groupBy("users.name", 'agent_target.target')
            ->where([['add_sales.status', 'Approved'], ['users.company_id' , Auth::user()->company_id]])
            ->get();
        return view('dashboard.content', ['comm' => $comm, 'agents' => $agents, 'earnings' => $earn, 'mo' => $mo, 'tday' => $tday, 'sales' => $sales, 'ag' => $ag, 'target' => $target]);
    }

    public function getSalesByMonth(){
        $month_sales = array();
        $month_name = array();
        $year = date('Y');

/*        $monthly_chart = DB::table('add_sales')
            ->join('products', 'add_sales.product_id', '=', 'products.id')
            ->join('users', 'add_sales.agent', '=', 'users.agent_id')
            ->select(DB::raw('MONTH(DATE) as month, SUM(add_sales.sale_value) as sales'))
            ->groupBy(DB::raw('MONTH(DATE)'))
            ->where('status', 'Approved')
            ->orderBy(DB::raw('MONTH(DATE)', 'DESC'))
            ->get();*/

        for($i=0;$i<12;$i++){
            $m = $i+1;
             $month_s = date('Y').'-'.$m.'-01';
             $month_e = date('Y').'-'.$m.'-31';
        
        $monthly_chart = DB::table('add_sales')
        ->whereBetween('date',[$month_s,$month_e])
        ->where('status', 'Approved')
        ->select('sale_value')
        ->join('products', 'add_sales.product_id', '=', 'products.id')
        ->join('users', 'add_sales.agent', '=', 'users.agent_id')        
        ->get();
        $sales = 0;
        if($monthly_chart->count()>0){
            foreach($monthly_chart as $m){
                $sales = $sales + $m->sale_value;
            }
            $month_sales[$i] = $sales;
        }else{
            $month_sales[$i] = 0;
        }

        }
        
        for($i=0;$i<12;$i++){
            $m = $i+1;
            $month_name[$i] = date("F", mktime(0, 0, 0, $m, 10));        
        }         

/*        foreach($monthly_chart as $m){

            $month[] = $m->month;            
        }
        foreach($month as $mon)
                $name[] = date("F", mktime(0, 0, 0, $mon, 10));

        foreach($monthly_chart as $s){
            $sales[] = $s->sales;
        }
*/

        $data = array_merge([$month_name], [$month_sales]);
      return response()->json(['monthly' => $data]);
    }

   public function getSalesByYear(){

        $year = date('Y');
        $yearly_sales = array();
        $years = array();
        for($i=2018;$i<=$year;$i++){
             $month_s = $i.'-01-01';
             $month_e = $i.'-12-31';
        
        $monthly_chart = DB::table('add_sales')
        ->whereBetween('date',[$month_s,$month_e])
        ->where('status', 'Approved')
        ->select('sale_value')
        ->join('products', 'add_sales.product_id', '=', 'products.id')
        ->join('users', 'add_sales.agent', '=', 'users.agent_id')        
        ->get();
        
        $sales = 0;
        if($monthly_chart->count()>0){
            foreach($monthly_chart as $m){
                $sales = $sales + $m->sale_value;
            }
            array_push($yearly_sales,$sales);
        }else{
            array_push($yearly_sales,0);
        }

        array_push($years,$i);
        }
                    

      $data = array_merge([$years], [$yearly_sales]);
      return response()->json(['yearly' => $data]);
    
   } 
}
