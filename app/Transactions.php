<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;
use App\Transactions;
use Carbon;
use App\Wallet;

class Transactions extends Model
{
     protected $guarded = [];
    protected $table = 'transactions';
    public $timestamps = false;

    public static function wallet_money(){
    	$a = Wallet::where([['user_id', Auth::user()->agent_id], ['date', Carbon\Carbon::now()->toDateString()]])->select('total_funds as cb')->orderBy('date', 'DESC')->first();

    	$w = Transactions::where([['agent_id', Auth::user()->agent_id], ['date', Carbon\Carbon::now()->toDateString()]])->select('closing_balance as cb')->orderBy('date', 'DESC')->first();  

    	if(empty($w)){
    		$wallet = $a->cb;
    	}elseif (empty($a)){
    		$wallet = $w->cb;
    	}elseif(!empty($w) && !empty($a)){
            $wallet = $a->cb;
        }else{
            $wallet = 0;
        }
    	return $wallet;
    }
}
