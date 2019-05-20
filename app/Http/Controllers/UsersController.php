<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\User;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $agents = User::all();
        return view('roles.content', ['agents' => $agents]);
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
        $data = new User;
        $data->name = $_POST['name'];
        $data->username = $_POST['username'];
        $data->password = Hash::make($_POST['password']);
        $data->email = $_POST['email'];
        $data->role_id = $request->get('role');

        if ($data->save()) {
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
