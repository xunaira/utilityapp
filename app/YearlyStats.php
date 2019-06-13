<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;
use DB;
use Carbon;

class YearlyStats extends Model
{
    public static function stats(){
    	$earn = "";
        $year = Carbon\Carbon::now()->year;
        if (Auth::user()->role_id == 1){
            //Total Earnings 
            $earnings = DB::table('add_sales')
                ->join('products', 'add_sales.product_id', '=', 'products.id')
                ->join('users', 'add_sales.agent', '=', 'users.agent_id')
                ->selectRaw('SUM(add_sales.sale_value) as sales_value')
                ->where('status', 'Approved')
                ->get();
            if(!empty($earnings)){
                foreach($earnings as $e){
                    $earn = $e->sales_value;
                }
            }
        }elseif(Auth::user()->role_id == 2){
            //Total Earnings 
            // $earnings = DB::table('add_sales')
            //     ->join('products', 'add_sales.product_id', '=', 'products.id')
            //     ->join('users', 'add_sales.agent', '=', 'users.agent_id')
            //     ->join('supervisor', 'users.id', '=', 'supervisor.id')
            //     ->selectRaw('SUM(add_sales.sale_value) as sales_value')
            //     ->where([['status', 'Approved'], ['supervisor.id', Auth::user()->id]])
            //     ->get();
            $earnings = DB::table('add_sales')
            ->join('products', 'add_sales.product_id', '=', 'products.id')
            ->join('users', 'add_sales.agent', '=', 'users.agent_id')
            ->join('agents', 'agents.id', '=', 'users.agent_id')
            ->join('supervisor', 'supervisor.user_id', '=', 'agents.supervisor_id')
            ->selectRaw('SUM(add_sales.sale_value) as sales_value')
            ->where([['status', 'Approved'], ['agents.supervisor_id', Auth::user()->id]])
            ->whereYear('date', $year)
            ->get();

            if(!empty($earnings)){
                foreach($earnings as $e){
                    $earn = $e->sales_value;
                }
            }

        }elseif(Auth::user()->role_id == 3){
            //Total Earnings 
            $earnings = DB::table('add_sales')
                ->join('products', 'add_sales.product_id', '=', 'products.id')
                ->join('users', 'add_sales.agent', '=', 'users.agent_id')
                ->join('agents', 'users.agent_id', '=', 'agents.id')
                ->selectRaw('SUM(add_sales.sale_value) as sales_value')
                ->where([['status', 'Approved'], ['agents.id', Auth::user()->agent_id]])
                ->get();
            if(!empty($earnings)){
                foreach($earnings as $e){
                    $earn = $e->sales_value;
                }
            }

        }else{
            $earn = 0;

        }
         return $earn;
    }
}
