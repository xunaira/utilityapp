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
		//insert in user 
		//$user->role_id = 1;

		if($company->save()){
			$user = new User;
			$user->name = $request->get('name');
			$user->email = $request->get('email');
			$user->password = Hash::make($request->get('password'));

			$com = Company::where('email', $request->get('email'))->select('id')->first();

			$user->company_id = $com->id;
			

			if($user->save()){
				return back()->with('success', "Company Added Successfully");
			}else{
				return back()->with('success', "Company Could not be added at this time");
			}
		}




	}

	public function edit($id){
		$company = DB::table('company')
					->join('users', 'users.company_id', '=', 'company.id')
					->select('users.role_id', 'company.*')
					->where('company.id', $id)
					->get();
		$roles = Role::all();

		return view('company.edit', ['company' => $company, 'roles' => $roles]);
	}

	public function destroy($id)
    {
        $company = Company::find($id);
        
        if(!is_null($company)) {

            $company->delete();
            return back()->with('success','Company Deleted successfully.');
        } else {
            return back()->with('error','Company Not Deleted');
        }

    }
    
}
