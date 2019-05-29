<?php

namespace App\Http\Controllers;

use App\agents_migration;
use Illuminate\Http\Request;
use App\User;
use App\Wallet;
use Auth;
use Carbon\Carbon;
use DB;
use Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$agents = agents_migration::all();
        $agents = DB::table('agents')
            ->join('users', 'agents.id', '=', 'users.agent_id')
            ->select('users.*','agents.*')
            ->get();
        return view('users.content', ['agents' => $agents]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sup = User::where('role_id', 2)->get();
        return view('users.add', ['sup' => $sup]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = new agents_migration;
        $user = new User;
        
        $data->email = $request->get('email');
        $data->address1 = $request->get('address1');
        $data->address2 = $request->get('address2');
        $data->city = $request->get('city');
        $data->state = $request->get('state');
        $data->country = $request->get('country');
        $data->phone_no = $request->get('phone_no');
        $data->operational_area = $request->get('operational_area');
        $data->agent_type = $request->get('type');
        $data->supervisor_id = $request->get('sup');
        $data->commission = $request->get('commission');
        $data->salary = $request->get('salary');
       
       if($data->save()){
            $id = agents_migration::where('email', $request->get('email'))->select('id')->get();
            foreach($id as $i)
                // $data->agent_id = $role_id;
                $user->name = $request->get('name');
                $user->username = $request->get('username');
                $user->password = Hash::make($request->get('password'));
                $user->email = $request->get('email');
                $user->role_id = 3;
                $user->agent_id = $i->id;
                

            if ($user->save()) {
                return redirect("admin/agents")->with('success','Product added successfully.');
            } else {
                return redirect("admin/agents")->with('error','Product Not Added');
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\agents_migration  $agents_migration
     * @return \Illuminate\Http\Response
     */
    public function show(agents_migration $agents_migration)
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
        $agents = agents_migration::find($id);

        return view('users.edit', ['agents' => $agents]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\agents_migration  $agents_migration
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $data = agents_migration::find($request->get('id'));
        $data->name = $_POST['name'];
        $data->username = $_POST['username'];
        $data->password = $_POST['password'];
        $data->email = $_POST['email'];
        $data->address1 = $_POST['address1'];
        $data->address2 = $_POST['address2'];
        $data->city = $_POST['city'];
        $data->state = $_POST['state'];
        $data->country = $_POST['country'];
        $data->phone_no = $_POST['phone_no'];
        $data->operational_area = $_POST['operational_area'];
        $data->agent_type = $_POST['type'];

        if ($data->save()) {
            return redirect("admin/agents")->with('success','Product added successfully.');
        } else {
            return redirect("admin/agents")->with('error','Product Not Added');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\agents_migration  $agents_migration
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $agent = agents_migration::find($id);
        
        if(!is_null($agent)) {

            $agent->delete();
            return back()->with('success','Agent Deleted successfully.');
        } else {
            return back()->with('error','Agent Not Deleted');
        }

    }

    public function add_balance(){
        $agents = DB::table('users')
            ->join('agents', 'users.agent_id', '=', 'agents.id')
            ->select('users.name', 'agents.id')
            ->get();
        return view('users.add-balance', ['agents' => $agents]);
    }

    public function balance(Request $r){
        $wallet = new Wallet();
        $wallet->total_funds = $r->get('fundings');
        
        if(Auth::user()->role_id == 1 || Auth::user()->role_id == 2){
            $user_id = $r->get('agent');
        }
        else if(Auth::user()->role_id == 3){
            $user_id = Auth::user()->id;
        }


        $wallet->user_id = $user_id;

        $wallet->date = Carbon::now();

       $save = $wallet->save();

        if($save){
            return back()->with('success','Funds Added successfully.');
        }else{
            return back()->with('error','Funds not added.');
        }

    }
}
