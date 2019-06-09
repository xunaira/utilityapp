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
        $funded = Settings::where('type', "funded agents")->get();
        
        //Total Sales Today
        if(Auth::user()->role_id == 1){
            $today = DB::table('add_sales')
                ->join('products', 'add_sales.product_id', '=', 'products.id')
                ->join('users', 'add_sales.agent', '=', 'users.agent_id')
                ->selectRaw('SUM(add_sales.sale_value) as sales_value')
                ->where([['status', 'Approved'], ['date', Carbon\Carbon::now()->toDateString()]])
                ->get();
        }elseif (Auth::user()->role_id == 2){
            $today = DB::table('add_sales')
                ->join('products', 'add_sales.product_id', '=', 'products.id')
                ->join('users', 'add_sales.agent', '=', 'users.agent_id')
                ->join('supervisor', 'supervisor.user_id', '=', 'users.id')
                ->selectRaw('SUM(add_sales.sale_value) as sales_value')
                ->where([['status', 'Approved'], ['date', Carbon\Carbon::now()->toDateString()], ['supervisor.user_id', Auth::user()->id]])
                ->get();
            
        }elseif (Auth::user()->role_id == 3){
            $today = DB::table('add_sales')
                ->join('products', 'add_sales.product_id', '=', 'products.id')
                ->join('users', 'add_sales.agent', '=', 'users.agent_id')
                ->join('agents', 'agents.id', '=', 'users.agent_id')
                ->selectRaw('SUM(add_sales.sale_value) as sales_value')
                ->where([['status', 'Approved'], ['date', Carbon\Carbon::now()->toDateString()], ['agents.id', Auth::user()->id]])
                ->get();
        }


        foreach($today as $t){
            $tday = $t->sales_value;
        }

        //Total Sales this Monthly
        $month = Carbon\Carbon::now()->month;

        if (Auth::user()->role_id == 1){

            $monthly = DB::table('add_sales')
            ->join('products', 'add_sales.product_id', '=', 'products.id')
            ->join('users', 'add_sales.agent', '=', 'users.agent_id')
            ->selectRaw('SUM(add_sales.sale_value) as sales_value')
            ->where('status', 'Approved')
            ->whereMonth('date', $month)
            ->get();

        }elseif(Auth::user()->role_id == 2){
            $monthly = DB::table('add_sales')
            ->join('products', 'add_sales.product_id', '=', 'products.id')
            ->join('users', 'add_sales.agent', '=', 'users.agent_id')
            ->join('supervisor', 'supervisor.user_id', '=', 'users.id')
            ->selectRaw('SUM(add_sales.sale_value) as sales_value')
            ->where([['status', 'Approved'], ['supervisor.user_id', Auth::user()->id]])
            ->whereMonth('date', $month)
            ->get();

        }elseif(Auth::user()->role_id == 3){
            $monthly = DB::table('add_sales')
            ->join('products', 'add_sales.product_id', '=', 'products.id')
            ->join('users', 'add_sales.agent', '=', 'users.agent_id')
            ->join('agents', 'agents.id', '=', 'users.agent_id')
            ->selectRaw('SUM(add_sales.sale_value) as sales_value')
            ->where([['status', 'Approved'], ['agents.id', Auth::user()->agent_id]])
            ->whereMonth('date', $month)
            ->get();

        }else{
            $monthly = 0;

        }

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
        if(Auth::user()->role_id == 1){
            $sales = DB::table('agents')
                ->join('add_sales', 'add_sales.agent', '=', 'agents.id')
                ->join('users', 'agents.id', '=', 'users.agent_id')
                ->select(DB::raw('SUM(add_sales.sale_value) as sales'), 'users.name')
                ->groupBy("users.name")
                ->where([['add_sales.status', 'Approved'], ['users.company_id' , Auth::user()->company_id]])
                ->get();
        
        }elseif(Auth::user()->role_id ==2) {
            $sales = DB::table('agents')
                ->join('add_sales', 'add_sales.agent', '=', 'agents.id')
                ->join('users', 'agents.id', '=', 'users.agent_id')
                ->join('supervisor', 'supervisor.id', '=', 'agents.supervisor_id')
                ->select(DB::raw('SUM(add_sales.sale_value) as sales'), 'users.name')
                ->groupBy("users.name")
                ->where([['add_sales.status', 'Approved'], ['users.company_id' , Auth::user()->company_id]])
                ->get();
        }else{
            $sales = 0;
        }

        $role = DB::table('roles')->select('id')->where('name','agent')->first();    
        $target = User::
          where('role_id',$role->id)
        ->where('company_id',Auth::user()->company_id)
        ->with('sales','target')->get();
        //dd($target);

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
        

        return view('dashboard.content', ['comm' => $comm, 'agents' => $agents, 'earnings' => $earn, 'mo' => $mo, 'tday' => $tday, 'sales' => $sales, 'ag' => $ag, 'target' => $target, 'agent_target' => $agent_target, 'sum' => $sum, 'get_sales' => $get_sales, 'funded' => $funded]);
    }

    public function getSalesByMonth(){
        $month_sales = array();
        $month_name = array();
        $year = date('Y');

        for($i=0;$i<12;$i++){
            $m = $i+1;
             $month_s = date('Y').'-'.$m.'-01';
             $month_e = date('Y').'-'.$m.'-31';
        
        if(Auth::user()->role_id == 1)
            $monthly_chart = DB::table('add_sales')
            ->whereBetween('date',[$month_s,$month_e])
            ->where('status', 'Approved')
            ->select('sale_value')
            ->join('products', 'add_sales.product_id', '=', 'products.id')
            ->join('users', 'add_sales.agent', '=', 'users.agent_id')        
            ->get();
        elseif(Auth::user()->role_id == 2){

            $monthly_chart = DB::table('add_sales')
            ->whereBetween('date',[$month_s,$month_e])
            ->where('status', 'Approved')
            ->select('sale_value')
            ->join('products', 'add_sales.product_id', '=', 'products.id')
            ->join('users', 'add_sales.agent', '=', 'users.agent_id')  
            ->join('supervisor', 'users.id', '=', 'supervisor.user_id') 
            ->where('users')     
            ->get();
        }elseif(Auth::user()->role_id == 3){
            $monthly_chart = DB::table('add_sales')
            ->whereBetween('date',[$month_s,$month_e])
            ->where('status', 'Approved')
            ->select('sale_value')
            ->join('products', 'add_sales.product_id', '=', 'products.id')
            ->join('users', 'add_sales.agent', '=', 'users.agent_id')  
            ->join('agents', 'agents.id', '=', 'users.agent_id') 
            ->where('agents.id', Auth::user()->agent_id)     
            ->get();
        }else{
            $monthly_chart == 0;
        }
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
