<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Settings;
use Carbon\Carbon;
use App\Wallet;
use App\Balance;
use Auth;
use App\User;
use App\Admin;
use App\Supervisor;

class SettingsController extends Controller
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
	public function index(){
		$comm = Settings::where('type', 'self funded agents')->get();
		$funded = Settings::where('type', 'funded agents')->get();
		return view('settings.com.index', ['comm' => $comm, 'funded' => $funded]);
	}
    public function commission(){
    	return view('settings.com.commissions');
    }

    public function store(Request $r){
    	$validatedData = $r->validate([
	        'comm_percent' => 'required',
	        'value' => 'required',
	        'type' => 'required'
        ]);
    	
    	if($validatedData){
    		$c = new Settings;
    		$c->comm = $r->get('comm_percent');
    		$c->value = $r->get('value');
    		$c->created_at = Carbon::now();
    		$c->type = $r->get('type');
    		
    		if ($c->save()) {
                return redirect("admin/settings")->with(array('message' => 'Commission has been added successfully', 
                          'alert-type' => 'success'));
            } else {
                return redirect("admin/settings")->with(array('message' => 'There was a problem adding this commission.', 
                          'alert-type' => 'error'));
            }
    	}


    }

    public function edit($id){
    	$value = Settings::find($id);
    	return view('settings.com.edit', ['value' => $value]);
    }

    public function update(Request $r){
    	$validatedData = $r->validate([
	        'comm_percent' => 'required',
	        'value' => 'required',
	        'type' => 'required'
        ]);
    	
    	if($validatedData){
    		$c = Settings::find($r->get('id'));

    		$c->comm = $r->get('comm_percent');
    		$c->value = $r->get('value');
    		$c->created_at = Carbon::now();
    		$c->type = $r->get('type');
    		
    		if ($c->save()) {
                return back()->with('success','Commission added successfully.');
            } else {
                return back()->with('error','Commission Not updated');
            }
    	}
    }

    public function destroy($id){
    	$comm = Settings::find($id);
        
        if(!is_null($comm)) {

            $comm->delete();
            return back()->with('success','Sale Deleted successfully.');
        } else {
            return back()->with('error','Sale Not Deleted');
        }
    }

    public function system(){
        return view('settings.bal.balance');
    }

    public function view_balance(){
        $balance = Balance::where('company_id', Auth::user()->company_id)->get();
        $bal = Balance::where('date', Carbon::now()->toDateString())->count();
        
        return view('settings.bal.bank', ['balance' => $balance, 'bal' => $bal]);
    }

    public function edit_balance($id){
        $bal = Balance::find($id);
        return view('settings.bal.edit', ['bal' => $bal]);
    }

    public function update_balance(Request $request){
        $id = $request->get('id');
        $bal = Balance::find($id);
        $bal->cash_bank = $request->get('cash_bank');
        $bal->cash_hand = $request->get('cash');
        $bal->date = $request->get('date');

        if($bal->save()){
            return back()->with('success','System wide balance updated successfully');
        }else{
            return back()->with('error','Balance could not be updated');
        }

    }

    public function add_balance(Request $request){
        $cash_in_hand = $request->get('cash');
        $cash_bank = $request->get('cash_bank');
        $date = $request->get('date');

        $b = new Balance;
        $b->cash_hand = $cash_in_hand;
        $b->cash_bank = $cash_bank;
        $b->date = $date;
        $b->created_at = Carbon::now();
        $b->user_id = Auth::user()->id;
        $b->company_id = Auth::user()->company_id;
        $b->total = $cash_in_hand + $cash_bank;
        $b->rem = $cash_in_hand + $cash_bank;

        if($b->save()){
            return redirect('admin/settings/balance')->with('success','System wide balance added successfully');
        }else{
            return redirect('admin/settings/balance')->with('error','Balance could not be added');
        }        
    }

    public function delete_balance($id){
        $bal = Balance::find($id);
        
        if(!is_null($bal)) {

            $bal->delete();
            return back()->with('success','Balance Deleted successfully.');
        } else {
            return back()->with('error','Balance Not Deleted');
        }

    }

    public function profile(){
        $id = Auth::user()->id;
        if(Auth::user()->role_id == 1 || Auth::user()->role_id == 2){
            $user = User::where('users.id', $id)
                    ->join('admin', 'users.id', '=', 'admin.user_id')
                    ->first();


        }elseif(Auth::user()->role_id == 3){
            $user = User::where('id', $id)
                    ->join('agents', 'agents.id', '=', 'users.agent_id')
                    ->select('users.name', 'users.username', 'agents.*')
                    ->first();

        }
        
        return view('settings.profile', ['user' => $user]);
    }

    public function update_profile(Request $request){
        if(Auth::user()->role_id == 1){
            $user = User::where('id', Auth::user()->id)->first();


        }elseif(Auth::user()->role_id == 2){
            $data = User::where('users.id', Auth::user()->id)->join('supervisor', 'supervisor.user_id', '=', 'users.id')->first();
        }
        elseif(Auth::user()->role_id == 3){
            $user = User::where('agent_id', $request->get('id'))->first();
            $data = agents_migration::find($request->get('id'));        
        }

        //dd($data);
        
        $user->name = $request->get('name');
        $user->username = $request->get('username');

        if($user->save()){
            if(Auth::user()->role_id == 1){
                $data = Admin::where('user_id', Auth::user()->id)->first();
            }elseif(Auth::user()->role_id == 2){
                $data = Supervisor::where('user_id', Auth::user()->id)->first();
            }

            $data->address1 = $request->get('address1');
            $data->address2 = $request->get('address2');
            $data->city = $request->get('city');
            $data->state = $request->get('state');
            $data->country = $request->get('country');
            $data->phone_no = $request->get('phone_no');
            
            if(Auth::user()->role_id == 3){
                $data->operational_area = $request->get('operational_area');
            }

            if($request->hasFile('pic')){
                $img = $request->file('pic');
                $thumb = 'pic-' . $request->get('name'). " " . time() . '.' . $img->getClientOriginalExtension();
                $path = $img->storeAs('public/img/pic', $thumb);
                $data->pic = $path;
            }

            if($data->save()){
                return redirect("admin/settings/profile")->with(
                        array('message' => 'Profile updated successfully.', 
                              'alert-type' => 'success'));

            }else{
                 return redirect("admin/settings/profile")->with(array('message' => 'There was a problem updating this [profile]', 
                          'alert-type' => 'error'));
            }

        }
    }
}
