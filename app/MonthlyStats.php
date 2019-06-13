<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;
use DB;
use Carbon;

class MonthlyStats extends Model
{
    public static function monthly_stats(){
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
            ->join('agents', 'agents.id', '=', 'users.agent_id')
            ->join('supervisor', 'supervisor.user_id', '=', 'agents.supervisor_id')
            ->selectRaw('SUM(add_sales.sale_value) as sales_value')
            ->where([['status', 'Approved'], ['agents.supervisor_id', Auth::user()->id]])
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

        $mo = "";
        if(!empty($monthly)){
            foreach($monthly as $m){
                $mo = $m->sales_value;
            }
        }else{
            $mo = 0;
        }

        return $mo;

    }
}
