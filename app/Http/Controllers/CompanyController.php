<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Company;
use App\User;
use Hash;
use Spatie\Permission\Models\Role;
use DB;

class CompanyController extends Controller
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
		$company = Company::all();

		return view('company.index', ['company' => $company]);
	}

	public function add(){
		$roles = Role::all();
		return view('company.add', ['roles' => $roles]);

	}

	public function add_company(Request $request){
		$company = new Company();
		$company->name = $request->get('name');
		$company->email = $request->get('email');
		$company->address1 = $request->get('address1');
		$company->address2 = $request->get('address2');
		$company->city = $request->get('city');
		$company->state = $request->get('state');
		$company->country = $request->get('country');
		$company->phone = $request->get('phone_no');
		
		if($company->save()){
			$user = new User;
			$user->name = $request->get('name');
			$user->email = $request->get('email');
			$user->password = Hash::make($request->get('password'));

			$com = Company::where('email', $request->get('email'))->select('id')->first();

			$user->company_id = $com->id;
			

			if ($user->save()) {
            	return redirect("admin/company")->with(
                	array('message' => 'Company added successfully.', 
                      'alert-type' => 'success'));
        	} else {
            	return redirect("admin/company")->with(array('message' => 'There was a problem adding your company', 
                      'alert-type' => 'error'));
        	}
		}
	}

	public function edit($id){
		$company = DB::table('company')
					->where('id', $id)->get();
		$roles = Role::all();

		return view('company.edit', ['company' => $company, 'roles' => $roles]);
	}

	public function update(Request $request){
		$company = Company::find($request->get('id'));
		$company->name = $request->get('name');
		$company->email = $request->get('email');
		$company->address1 = $request->get('address1');
		$company->address2 = $request->get('address2');
		$company->city = $request->get('city');
		$company->state = $request->get('state');
		$company->country = $request->get('country');
		$company->phone = $request->get('phone_no');
		
		if($company->save()){
            return redirect("admin/company")->with(
                	array('message' => 'Company updated successfully.', 
                      'alert-type' => 'success'));
        	} else {
            	return redirect("admin/company")->with(array('message' => 'There was a problem updating your company', 
                      'alert-type' => 'error'));
        	}
		}

	public function destroy($id)
    {
        $company = Company::find($id);
        
        if(!is_null($company)) {

            $company->delete();
           

        return redirect("admin/company")->with(
                	array('message' => 'Company deleted successfully.', 
                      'alert-type' => 'success'));
        	} else {
            	return redirect("admin/company")->with(array('message' => 'There was a problem deleting your company', 
                      'alert-type' => 'error'));
        	}

    }
    
}
