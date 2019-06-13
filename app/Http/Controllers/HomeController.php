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
use App\User;
use DB;
use App\AgentSales;
use App\DailyStats;
use App\MonthlyStats;
use App\YearlyStats;
use App\Commissions;


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
        dd("HomeController");
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

        $role = DB::table('roles')->select('id')->where('name','agent')->first();  
        
        $target = agents_migration::target();

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

        

       return view('dashboard.content', 'comm' => $comm, 'agents' => $agents, 'earnings' => $earn, 'mo' => $mo, 'tday' => $tday, 'sales' => $sales, 'ag' => $ag, 'agent_target' => $agent_target, 'sum' => $sum, 'get_sales' => $get_sales, 'fund' => $f]);
        //return view('dashboard.content')->with([['comm', $comm], ['agents', $agents], ['funded', $funded]]);
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

        $admin_role = DB::table('roles')->where('name','admin')->first();
        $supervisor_role = DB::table('roles')->where('name','supervisor')->first();
        $agent_role = DB::table('roles')->where('name','agent')->first();        
        if(Auth::user()->role_id==$admin_role->id){

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

/*        $monthly_chart = AgentSales::whereBetween('date',[$month_s,$month_e])
        ->where('status', 'Approved')
        ->with('product')
        ->get();        */

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



    }elseif(Auth::user()->role_id==$supervisor_role->id){

        for($i=0;$i<12;$i++){
            $m = $i+1;
             $month_s = date('Y').'-'.$m.'-01';
             $month_e = date('Y').'-'.$m.'-31';
        
        $monthly_chart = DB::table('add_sales')
        ->whereBetween('date',[$month_s,$month_e])
        ->where('status', 'Approved')
        ->select('sale_value')
        ->join('products', 'add_sales.product_id', '=', 'products.id')
        ->join('agents', 'add_sales.agent', '=', 'agents.id')
        ->where('agents.supervisor_id',Auth::user()->id)
        ->get();

/*        $monthly_chart = AgentSales::whereBetween('date',[$month_s,$month_e])
        ->where('status', 'Approved')
        ->with('product')
        ->get();        */

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




    }elseif(Auth::user()->role_id==$agent_role->id){

        for($i=0;$i<12;$i++){
            $m = $i+1;
             $month_s = date('Y').'-'.$m.'-01';
             $month_e = date('Y').'-'.$m.'-31';
        
        $monthly_chart = DB::table('add_sales')
        ->whereBetween('date',[$month_s,$month_e])
        ->where('status', 'Approved')
        ->select('sale_value')
        ->join('products', 'add_sales.product_id', '=', 'products.id')
        ->where('add_sales.agent',Auth::user()->agent_id)
        ->get();

/*        $monthly_chart = AgentSales::whereBetween('date',[$month_s,$month_e])
        ->where('status', 'Approved')
        ->with('product')
        ->get();        */

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

    }    


        
        for($i=0;$i<12;$i++){
            $m = $i+1;
            $month_name[$i] = date("F", mktime(0, 0, 0, $m, 10));        
        }         


        $data = array_merge([$month_name], [$month_sales]);
      return response()->json(['monthly' => $data]);
    }

   public function getSalesByYear(){

        $year = date('Y');
        $yearly_sales = array();
        $years = array();
        $admin_role = DB::table('roles')->where('name','admin')->first();
        $supervisor_role = DB::table('roles')->where('name','supervisor')->first();
        $agent_role = DB::table('roles')->where('name','agent')->first();        


        if(Auth::user()->role_id==$admin_role->id){

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

        }elseif(Auth::user()->role_id==$supervisor_role->id){

        for($i=2018;$i<=$year;$i++){
             $month_s = $i.'-01-01';
             $month_e = $i.'-12-31';
        
        $monthly_chart = DB::table('add_sales')
        ->whereBetween('date',[$month_s,$month_e])
        ->where('status', 'Approved')
        ->select('sale_value')
        ->join('products', 'add_sales.product_id', '=', 'products.id')
        ->join('agents', 'add_sales.agent', '=', 'agents.id')
        ->where('agents.supervisor_id',Auth::user()->id)
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

        }elseif(Auth::user()->role_id==$agent_role->id){

        for($i=2018;$i<=$year;$i++){
             $month_s = $i.'-01-01';
             $month_e = $i.'-12-31';
        
        $monthly_chart = DB::table('add_sales')
        ->whereBetween('date',[$month_s,$month_e])
        ->where('status', 'Approved')
        ->select('sale_value')
        ->join('products', 'add_sales.product_id', '=', 'products.id')
        ->where('add_sales.agent',Auth::user()->agent_id)
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

        }


                    

      $data = array_merge([$years], [$yearly_sales]);
      return response()->json(['yearly' => $data]);
    
   } 
}
