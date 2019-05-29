<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Settings;
use Carbon\Carbon;
use App\Wallet;
use App\Balance;

class SettingsController extends Controller
{
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
                return back()->with('success','Commission added successfully.');
            } else {
                return back()->with('error','Commission Not updated');
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
        $balance = Balance::all();

        return view('settings.bal.bank', ['balance' => $balance]);
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

        if($b->save()){
            return back()->with('success','System wide balance added successfully');
        }else{
            return back()->with('error','Balance could not be added');
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
}
