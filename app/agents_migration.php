<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;
use DB;
use Carbon;

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

    public static function agents(){
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

        return $agents;
    }

    public static function agent_sales(){
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

        return $sales;
    }

    public static function agent_target(){
      $role = DB::table('roles')->select('id')->where('name','agent')->first(); 
      if(Auth::user()->role_id == 1){
            $target = User::where([['role_id',$role->id], ['company_id',Auth::user()->company_id]])->with('sales','target')->get();
            
            
        }elseif(Auth::user()->role_id == 2){
            $target = agents_migration::
                  join('users', 'users.agent_id', '=', 'agents.id')
                  ->join('add_sales', 'add_sales.agent', '=', 'agents.id')
                  ->join('agent_target', 'agents.id', '=', 'agent_target.user_id')
                  ->select('users.name', 'agent_target.target', DB::raw('sum(add_sales.sale_value) as sales'))
                  ->where([['agents.supervisor_id', Auth::user()->id], ['agent_target.date', '>=', Carbon\Carbon::now()->toDateString()]])
                  ->groupBy('users.name', 'agent_target.target', 'agent_target.date')
                  ->orderBy('agent_target.date', 'DESC')
                  ->get();
        
        }  else{
            $target = 0;
        }

        return $target;
    }

}
