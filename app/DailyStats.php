<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;
use DB;
use Carbon;

class DailyStats extends Model
{
    public static function stats(){
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
                ->join('agents', 'agents.id', '=', 'users.agent_id')
                ->join('supervisor', 'supervisor.user_id', '=', 'agents.supervisor_id')
                ->selectRaw('SUM(add_sales.sale_value) as sales_value')
                ->where([['status', 'Approved'], ['date', Carbon\Carbon::now()->toDateString()], ['agents.supervisor_id', Auth::user()->id]])
                ->get();
            
        }elseif (Auth::user()->role_id == 3){
            $today = DB::table('add_sales')
                ->join('products', 'add_sales.product_id', '=', 'products.id')
                ->join('users', 'add_sales.agent', '=', 'users.agent_id')
                ->join('agents', 'agents.id', '=', 'users.agent_id')
                ->selectRaw('SUM(add_sales.sale_value) as sales_value')
                ->where([['status', 'Approved'], ['date', Carbon\Carbon::now()->toDateString()], ['add_sales.agent', Auth::user()->agent_id]])
                ->get();
        }


        if(!empty($today)){
            foreach($today as $t){
                $tday = $t->sales_value;
            }
        }else{
            $tday = 0;
        }

        return $tday;
    }
}
