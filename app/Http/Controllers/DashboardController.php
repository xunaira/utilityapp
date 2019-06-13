<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Settings;
use App\Balance;
use Carbon;
use App\Reports;
use App\Transactions;
use App\agents_migration;
use App\User;
use DB;
use App\AgentSales;
use App\DailyStats;
use App\MonthlyStats;
use App\YearlyStats;
use App\Commissions;
use Auth;


class DashboardController extends Controller
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
    public function index(Request $request){
    	$comm = Commissions::self_funded();
        $f = Commissions::funded();
        
        
        //Total Sales Today
        $tday = DailyStats::stats();
        

        //Total Sales this Monthly
        $mo = MonthlyStats::monthly_stats();
        
        $earn = YearlyStats::stats();
        
        //Total Agents 
        $agents = agents_migration::agents();

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

        //Get agent name and total sales for this month
        $sales = agents_migration::agent_sales(); 
        
        $target = agents_migration::agent_target();

        $sum = 0;

        if(Auth::user()->role_id == 3){
            $agent_target = User::where('role_id',$role->id)
            ->where([['company_id',Auth::user()->company_id], ['agent_id', Auth::user()->agent_id]])
            ->with('sales','target')->first();

            foreach($agent_target->sales as $at){
                $sum += $at->sale_value;
                
            }
        }else{
            $agent_target = 0;
        }

    

        $get_sales = AgentSales::where('agent', Auth::user()->agent_id)
                        ->join('products', 'products.id', '=', 'add_sales.product_id')
                        ->where('date', Carbon\Carbon::now()->toDateString())
                        ->select('products.product_name', 'add_sales.sale_value')
                        ->paginate(5);

        
       return view('dashboard.content', ['comm' => $comm, 'agents' => $agents, 'earnings' => $earn, 'mo' => $mo, 'tday' => $tday, 'sales' => $sales, 'ag' => $ag, 'agent_target' => $agent_target, 'sum' => $sum, 'get_sales' => $get_sales, 'fund' => $f, 'target' => $target]);

    }
}
