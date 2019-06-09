<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;

class agents_migration extends Model
{
    protected $table = 'agents';

   function user()
    {
        return $this->belongsTo('App\User','agent_id','id');
    }

   function getUser()
    {
        return $this->belongsTo('App\User')->where('company_id',Auth::user()->company_id);
    }


   function target()
    {
        return $this->hasOne('App\Target','user_id','id');
    }

   function sales()
    {
        return $this->hasMany('App\AgentSales','agent','id')->where('status','Approved');
    }

}
