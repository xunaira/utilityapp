<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;
use Carbon;
use DB;
use App\Reports;

class Balance extends Model
{
   	protected $guarded = [];
    protected $table = 'balance';
    public $timestamps = false;

    public static function balance(){
    	$b = "";
    	$bal = Balance::where([['company_id', Auth::user()->company_id], ['date', Carbon\Carbon::now()->toDateString()]])->select('total')->first();

            if(empty($bal)){
            	
            	$b = 0;
                
                
            }else{
                $rem = Reports::where([['company_id', Auth::user()->company_id], ['date', Carbon\Carbon::now()->toDateString()]])->orderBy('created_at', 'DESC')->selectRaw('remaining_balance as bal')->first();
                
                if(empty($rem)){

                 	$b = $bal->total;
                 	
                }else{
                	
                	$b = $rem->bal;
                }
                // foreach($rem as $r){
                //     $b = $r->bal;
                // }
                
            }
            return $b;
    }
}
