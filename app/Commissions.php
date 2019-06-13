<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Commissions extends Model
{

    public static function funded(){
    	$funded = Settings::where('type', "funded agents")->get();
    	return $funded;
    }


    public static function self_funded(){
    	$comm = Settings::where('type', "self funded agents")->get();

    	return $comm;
    }
}
