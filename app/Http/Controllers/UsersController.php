<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\User;
use Illuminate\Support\Facades\Hash;
use App\agents_migration;
use DB;
use Auth;

class UsersController extends Controller
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $agents = User::where([['role_id', 1], ['company_id', Auth::user()->company_id]])->orderBy('created_at', 'DESC')->get();
        $sup = User::where([['role_id', 2], ['company_id', Auth::user()->company_id]])->orderBy('created_at', 'DESC')->get();
        return view('roles.content', ['agents' => $agents, 'sup' => $sup]);
    }

    public function agents($id){
        $agents = DB::table('agents')
                ->join('users', 'users.agent_id', '=', 'agents.id')
                ->join('supervisor', 'supervisor.user_id' , '=' , 'agents.supervisor_id')
                ->where('supervisor.user_id', $id)
                ->select('agents.*', 'supervisor.name as sup', 'users.name')
                ->get();
        return view('roles.agents', ['agents' => $agents]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    	$roles = Role::all();
        return view('roles.add', ['roles' => $roles]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $e = $request->get('email');
        $data = new User;
        $data->name = $_POST['name'];
        $data->username = $_POST['username'];
        $data->password = Hash::make($_POST['password']);
        $data->email = $_POST['email'];
        $data->role_id = $request->get('role');
        $data->company_id = Auth::user()->company_id;

        if ($data->save()) {
            if($data->role_id == 2){
                $email = User::where('email', $e)->get();
                foreach($email as $e){
                    $sup = DB::table('supervisor')->insert(['user_id' => $e->id, 'name' => $e->name]);
                }
            }
            return redirect("admin/users")->with('success','User added successfully.');
        } else {
            return redirect("admin/users")->with('error','User Not Added');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\agents_migration  $agents_migration
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\agents_migration  $agents_migration
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $agents = User::find($id);
        $roles = DB::table('roles')->get();
       
        return view('users.edit', ['agents' => $agents, 'roles' => $roles]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\agents_migration  $agents_migration
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\agents_migration  $agents_migration
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $agent = User::find($id);
        
        if(!is_null($agent)) {

            $agent->delete();
            return back()->with('success','Agent Deleted successfully.');
        } else {
            return back()->with('error','Agent Not Deleted');
        }

    }
}
