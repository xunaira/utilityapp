<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Billing;
use Auth;
use Carbon;
use DB;

class BillingController extends Controller
{
    public function index(){
    	$billing = Billing::paginate(15);
    	return view('billing.content', ['billing' => $billing]);
    }

    public function add(){
    	return view('billing.add');
    }

    public function create(Request $r){
    	$b = new Billing;
    	$b->name = $r->get('name');
    	$b->email = $r->get('email');
    	$b->phone = $r->get('phone');
    	$b->sr_no = $r->get('serial');
    	$b->account_name = $r->get('account_name');
    	$b->account_number = $r->get('account');
    	$b->address_line_1 = $r->get('address1');
    	$b->address_line_2 = $r->get('address2');
    	$b->city = $r->get('city');
    	$b->state = $r->get('state');
    	$b->country = $r->get('country');
    	$b->outstanding = $r->get('outstanding');
    	$b->charge = $r->get('charge');
    	$b->date = $r->get('date');
    	$b->status = $r->get('status');
    	$b->created_at = Carbon\Carbon::now();
    	$b->updated_at = Carbon\Carbon::now();
    	$b->user_id = Auth::user()->id;

    	if ($b->save()) {
            	return redirect("admin/billing")->with(
                	array('message' => 'Bill added successfully.', 
                      'alert-type' => 'success'));
        	} else {
            	return redirect("admin/company")->with(array('message' => 'There was a problem adding your bill', 
                      'alert-type' => 'error'));
        	}

    }

    public function edit($id){
    	$edit = Billing::find($id);
    	return view('billing.edit', ['edit' => $edit]);
    }

    public function update(Request $r){
    	$b = Billing::find($r->get('id'));
    	$b->name = $r->get('name');
    	$b->email = $r->get('email');
    	$b->phone = $r->get('phone');
    	$b->sr_no = $r->get('serial');
    	$b->account_name = $r->get('account_name');
    	$b->account_number = $r->get('account');
    	$b->address_line_1 = $r->get('address1');
    	$b->address_line_2 = $r->get('address2');
    	$b->city = $r->get('city');
    	$b->state = $r->get('state');
    	$b->country = $r->get('country');
    	$b->outstanding = $r->get('outstanding');
    	$b->charge = $r->get('charge');
    	$b->date = $r->get('date');
    	$b->status = $r->get('status');
    	$b->created_at = Carbon\Carbon::now();
    	$b->updated_at = Carbon\Carbon::now();
    	$b->user_id = Auth::user()->id;

    	if ($b->save()) {
            	return redirect("admin/billing")->with(
                	array('message' => 'Bill updated successfully.', 
                      'alert-type' => 'success'));
        	} else {
            	return redirect("admin/company")->with(array('message' => 'There was a problem updating your bill', 
                      'alert-type' => 'error'));
        	}



    }

    public function delete($id){
    	$billing = Billing::find($id);
        
        if(!is_null($billing)) {

            $billing->delete();
           

        return redirect("admin/billing")->with(
                	array('message' => 'Bill deleted successfully.', 
                      'alert-type' => 'success'));
        	} else {
            	return redirect("admin/billing")->with(array('message' => 'There was a problem deleting your bill', 
                      'alert-type' => 'error'));
        	}
    }
}
