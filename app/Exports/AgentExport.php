<?php

namespace App\Exports;

use App\agents_migration;
use Maatwebsite\Excel\Concerns\FromCollection;
use Auth;
use DB;

class AgentExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
    	// if(Auth::user()->role_id == 1){
     //        $agents = DB::table('agents')
     //        ->join('supervisor', 'supervisor.user_id', '=', 'agents.supervisor_id')
     //        ->join('users', 'agents.id', '=', 'users.agent_id')
     //        ->select('users.*','agents.*', 'supervisor.name as sup')
     //        ->where('agents.id', $id)
     //        ->get();
            
     //    }else{
            $agents = DB::table('agents')
            ->join('supervisor', 'supervisor.user_id', '=', 'agents.supervisor_id')
            ->join('users', 'agents.id', '=', 'users.agent_id')
            ->select('users.*','agents.*', 'supervisor.name as sup')
            // ->where([['supervisor_id', Auth::user()->id], ['agents.id', $id]])
            ->get();
            
        // }
        return $agents;
    }
}
