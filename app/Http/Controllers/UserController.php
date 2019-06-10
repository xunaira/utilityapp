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
use App\Transactions;
use App\Exports\AgentExport;
use App\Exports\AgentDetailExport;
use App\Exports\BankExport;
use Excel;
use App\Balance;
use App\Reports;
use App\Target;


class UserController extends Controller
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
        if(Auth::user()->role_id == 1){
            $agents = DB::table('agents')
            ->join('supervisor', 'supervisor.user_id', '=', 'agents.supervisor_id')
            ->join('users', 'agents.id', '=', 'users.agent_id')
            ->join('company', 'company.id', '=', 'users.company_id')
            ->select('users.*','agents.*', 'supervisor.name as sup')
            ->where('users.company_id', Auth::user()->company_id)
            ->get();
        }else{
            $agents = DB::table('agents')
            ->join('supervisor', 'supervisor.user_id', '=', 'agents.supervisor_id')
            ->join('users', 'agents.id', '=', 'users.agent_id')
            ->join('company', 'company.id', '=', 'users.company_id')
            ->select('users.*','agents.*', 'supervisor.name as sup')
            ->where([['supervisor_id', Auth::user()->id], ['users.company_id', Auth::user()->company_id]])
            ->get();
        }
        
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

        if($request->hasFile('kyc')){
            $img = $request->file('kyc');
            $thumb = 'kyc-' . $request->get('name'). " " . time() . '.' . $img->getClientOriginalExtension();
            $path = $img->storeAs('public/img/kyc', $thumb);
            $data->kyc = $path;
        }
       
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
                $user->company_id = Auth::user()->company_id;
                

            if ($user->save()) {
                return redirect("admin/agents")->with(
                    array('message' => 'Agent added successfully.', 
                          'alert-type' => 'success'));
            } else {
                return redirect("admin/agents")->with(array('message' => 'There was a problem adding this agent', 
                      'alert-type' => 'error'));
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
        if(Auth::user()->role_id == 1){
            $agents = DB::table('agents')
            ->join('supervisor', 'supervisor.user_id', '=', 'agents.supervisor_id')
            ->join('users', 'agents.id', '=', 'users.agent_id')
            ->select('users.*','agents.*', 'supervisor.name as sup')
            ->where([['users.company_id', Auth::user()->company_id], ['agents.id', $id]])
            ->get();
            $sup = DB::table('supervisor')->select('id', 'name')->get();
        }else{
            $agents = DB::table('agents')
            ->join('supervisor', 'supervisor.user_id', '=', 'agents.supervisor_id')
            ->join('users', 'agents.id', '=', 'users.agent_id')
            ->select('users.*','agents.*', 'supervisor.name as sup')
            ->where([['supervisor_id', Auth::user()->id], ['agents.id', $id], ['users.company_id', Auth::user()->company_id]])
            ->get();
            $sup = DB::table('supervisor')->select('id', 'name')->get();
        }

        return view('users.edit', ['agents' => $agents, 'sup' => $sup]);
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
        $user = User::where('agent_id', $request->get('id'))->first();
        $data = agents_migration::find($request->get('id'));
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

        if($request->hasFile('kyc')){
            $img = $request->file('kyc');
            $thumb = 'kyc-' . $request->get('name'). " " . time() . '.' . $img->getClientOriginalExtension();
            $path = $img->storeAs('public/img/kyc', $thumb);
            $data->kyc = $path;
        }
       
       if($data->save()){
            $id = agents_migration::where('email', $request->get('email'))->select('id')->get();
            foreach($id as $i){
                $user->agent_id = $i->id;
            }
            $user->name = $request->get('name');
             $user->username = $request->get('username');
            $user->role_id = 3;
            $user->company_id = Auth::user()->company_id;               

            if ($data->save()) {
                return redirect("admin/agents")->with(
                    array('message' => 'Agent updated successfully.', 
                          'alert-type' => 'success'));
            } else {
                return redirect("admin/agents")->with(array('message' => 'There was a problem updating this agent', 
                      'alert-type' => 'error'));
            }
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
            
            return redirect("admin/agents")->with(
                    array('message' => 'Agent deleted successfully.', 
                          'alert-type' => 'success'));
            } else {
                return redirect("admin/agents")->with(array('message' => 'There was a problem deleting this agent', 
                      'alert-type' => 'error'));
            }

    }

    public function add_balance(){
        if(Auth::user()->role_id == 1){
            $agents = DB::table('users')
                ->join('agents', 'users.agent_id', '=', 'agents.id')
                ->select('users.name', 'agents.id')
                ->where('users.company_id', Auth::user()->company_id)
                ->get();
        }elseif(Auth::user()->role_id == 2){
            $agents = DB::table('users')
                ->join('agents', 'users.agent_id', '=', 'agents.id')
                ->select('users.name', 'agents.id')
                ->where([['users.company_id', Auth::user()->company_id], ['agents.supervisor_id', Auth::user()->id]])
                ->get();
        }
        return view('users.add-balance', ['agents' => $agents]);
    }

    public function balance(Request $r){
        $wallet = new Wallet();
        $hand = $r->get('cash_hand');
        $bank = $r->get('cash_bank');
        $total = $hand + $bank;
        $date = $r->get('date');

        if(Auth::user()->role_id == 1 || Auth::user()->role_id == 2){
            $user_id = $r->get('agent');
        }
        else if(Auth::user()->role_id == 3){
            $user_id = Auth::user()->agent_id;
        }

        if(Auth::user()->role_id == 1 || Auth::user()->role_id == 2){
            $balance = Balance::where([['company_id', Auth::user()->company_id], ['date', Carbon::now()->toDateString()]])->select('total')->first();

            if(empty($balance)){
                return back()->with('error', "Please add system balance before adding money in wallet");
            }else{
                $reports = Reports::where([['company_id', Auth::user()->company_id], ['date', Carbon::now()->toDateString()]])->orderBy('created_at', 'DESC')->select('remaining_balance as rem')->first(); 
                if(empty($reports)){
                    if($total < $balance->total){
                        $wallet->cash_in_hand = $hand;
                        $wallet->cash_bank = $bank;
                        $wallet->total_funds = $total;
                        $wallet->user_id = $user_id;
                        $wallet->date = $date;
                        
                        if ($wallet->save()) {
                            //deduct from system balance
                            $rem = $balance->total - $total;

                            //get the wallet id that is saved 
                            $wallet_id = Wallet::where('user_id', $user_id)->select('id')->first();
                            $report = new Reports();
                            $report->wallet_id = $wallet_id->id;
                            $report->total_balance = $balance->total;
                            $report->remaining_balance = $rem;
                            $report->date = Carbon::now()->toDateString();
                            $report->created_at = Carbon::now();
                            $report->updated_at = Carbon::now();
                            $report->company_id = Auth::user()->company_id;
                            
                            if($report->save()){
                                return redirect("admin/agents")->with(array('message' => 'Wallet Balance Added successfully.', 
                                      'alert-type' => 'success'));
                            }else{
                                return redirect("admin/agents")->with(array('message' => 'There was a problem adding wallet balance for this agent', 
                                      'alert-type' => 'error'));
                            }

                            return redirect("admin/agents")->with(array('message' => 'Balance Added successfully.', 
                                      'alert-type' => 'success'));
                            
                        } else {
                                return redirect("admin/agents")->with(array('message' => 'The entered amount is greater than the system balance', 
                                      'alert-type' => 'error'));
                        }
                    }else{
                        return redirect("admin/agents")->with(array('message' => 'You dont have sufficient funds in the system to carry out this transaction', 
                                      'alert-type' => 'error'));
                    }
                }else{            
                    if($total < $reports->rem){
                        $wallet->cash_in_hand = $hand;
                        $wallet->cash_bank = $bank;
                        $wallet->total_funds = $total;
                        $wallet->user_id = $user_id;
                        $wallet->date = $date;
                        
                        if ($wallet->save()) {
                            //deduct from system $reports->rembalance
                            $rem = $reports->rem - $total;

                            //get the wallet id that is saved 
                            $wallet_id = Wallet::where('user_id', $user_id)->select('id')->first();
                            $report = new Reports();
                            $report->wallet_id = $wallet_id->id;
                            $report->total_balance = $balance->total;
                            $report->remaining_balance = $rem;
                            $report->date = Carbon::now()->toDateString();
                            $report->created_at = Carbon::now();
                            $report->updated_at = Carbon::now();
                            $report->company_id = Auth::user()->company_id;
                            
                            if($report->save()){
                                return redirect("admin/agents")->with(array('message' => 'Wallet Balance Added successfully.', 
                                      'alert-type' => 'success'));
                            }else{
                                return redirect("admin/agents")->with(array('message' => 'There was a problem adding wallet balance for this agent', 
                                      'alert-type' => 'error'));
                            }

                            return redirect("admin/agents")->with(array('message' => 'Balance Added successfully.', 
                                      'alert-type' => 'success'));
                            
                        } else {
                                return redirect("admin/agents")->with(array('message' => 'The entered amount is greater than the system balance', 
                                      'alert-type' => 'error'));
                        }
                    }else{
                        return redirect("admin/agents")->with(array('message' => 'You dont have sufficient funds in the system to carry out this transaction', 
                                      'alert-type' => 'error'));
                    }
                }
            }

        }elseif(Auth::user()->role_id == 3){
            $wallet->cash_in_hand = $hand;
            $wallet->cash_bank = $bank;
            $wallet->total_funds = $total;
            $wallet->date = $date;
            $wallet->user_id = $user_id;

            if($wallet->save()){
                return redirect("admin/dashboard")->with(array('message' => 'Wallet Balance Added successfully.','alert-type' => 'success'));
            }else{
                return redirect("admin/dashboard")->with(array('message' => 'There was a problem adding wallet balance for this agent', 
                                      'alert-type' => 'error'));

            }



        }else{

        }      

    }

    public function detail($id){
        if(Auth::user()->role_id == 1){
            $agents = DB::table('agents')
            ->join('supervisor', 'supervisor.user_id', '=', 'agents.supervisor_id')
            ->join('users', 'agents.id', '=', 'users.agent_id')
            ->select('users.*','agents.*', 'supervisor.name as sup')
            ->where('agents.id', $id)
            ->get();

            $balance = DB::table('transactions')
                       ->join('wallet', 'transactions.wallet_id', '=', 'wallet.id')
                       ->where('agent_id', $id)
                       ->get();
        
            
        }else{
            $agents = DB::table('agents')
            ->join('supervisor', 'supervisor.user_id', '=', 'agents.supervisor_id')
            ->join('users', 'agents.id', '=', 'users.agent_id')
            ->select('users.*','agents.*', 'supervisor.name as sup')
            ->where([['supervisor_id', Auth::user()->id], ['agents.id', $id]])
            ->get();

            $balance = DB::table('transactions')
                       ->join('wallet', 'transactions.wallet_id', '=', 'wallet.id')
                       ->where('agent_id', $id)
                       ->get();
            
            
        }
   
        $wallet = Transactions::where([['agent_id', $id], ['date', Carbon::now()->toDateString()]])->selectRaw('SUM(closing_balance) as w')->get();
        foreach($wallet as $b){
            $w = $b->w;
        }

    
        $transactions = DB::table('transactions')
                        ->join('wallet', 'transactions.wallet_id', '=', 'wallet.id')
                        ->join('add_sales', 'transactions.sales_id', '=', 'add_sales.id')
                        ->join('products', 'add_sales.product_id', '=', 'products.id')
                        ->where('agent_id', $id)
                        ->paginate(15);
        $exporturl = "admin/agents/export/" . $id;
        $detailurl = "admin/agents/agentexport/" . $id;
        $bankurl = "admin/agents/bankexport/" . $id;

        $target = Target::where('user_id', $id)->paginate(10);
        
        return view('users.detail', ['agents' => $agents, 'w' => $w, 'balance' => $balance, 'transactions' => $transactions, 'exporturl' => $exporturl, 'detailurl' => $detailurl, 'bankurl' => $bankurl, 'target' => $target]);
    }

    public function export($id){
       $transactions = DB::table('transactions')
                        ->join('wallet', 'transactions.wallet_id', '=', 'wallet.id')
                        ->join('add_sales', 'transactions.sales_id', '=', 'add_sales.id')
                        ->join('products', 'add_sales.product_id', '=', 'products.id')
                        ->select('products.product_name', 'add_sales.sale_value', 'wallet.total_funds', 'transactions.closing_balance', 'transactions.date')
                        ->where('agent_id', $id)
                        ->paginate(15);
        $name = User::where('agent_id', $id)->select('name')->first();
        $file_name = $name->name . ".xlsx";
       return Excel::download(new AgentExport($transactions), $file_name);
    }

    public function agentexport($id){
        if(Auth::user()->role_id == 1){
            $agents = DB::table('agents')
            ->join('supervisor', 'supervisor.user_id', '=', 'agents.supervisor_id')
            ->join('users', 'agents.id', '=', 'users.agent_id')
            ->select('users.name','users.email','agents.address1', 'agents.address2', 'agents.city', 'agents.state', 'agents.country', 'agents.phone_no', 'agents.operational_area', 'agents.salary', 'supervisor.name as sup')
            ->where('agents.id', $id)
            ->get();
            
        }else{
            $agents = DB::table('agents')
            ->join('supervisor', 'supervisor.user_id', '=', 'agents.supervisor_id')
            ->join('users', 'agents.id', '=', 'users.agent_id')
            ->select('users.name','users.email','agents.address1', 'agents.address2', 'agents.city', 'agents.state', 'agents.country', 'agents.phone_no', 'agents.operational_area', 'agents.salary', 'supervisor.name as sup')
            ->where([['supervisor_id', Auth::user()->id], ['agents.id', $id]])
            ->get();
        }
        $name = User::where('agent_id', $id)->select('name')->first();
        $file_name = $name->name . ".xlsx";
        
       return Excel::download(new AgentDetailExport($agents), $file_name);
    }

    public function bankexport($id){
        $balance = DB::table('transactions')
                    ->join('wallet', 'transactions.wallet_id', '=', 'wallet.id')
                    ->select('wallet.cash_in_hand', 'wallet.cash_bank', 'transactions.closing_balance', 'wallet.total_funds', 'transactions.date')
                    ->where('agent_id', $id)
                    ->get();
        $name = User::where('agent_id', $id)->select('name')->first();
        $file_name = $name->name . ".xlsx";
        return Excel::download(new BankExport($balance), $file_name);
    }

    public function target(Request $request){
        $agent_id = $request->get('agent');
        $value = $request->get('value');
        $date = $request->get('date');

        $target = new Target;
        $target->user_id = $agent_id;
        $target->target = $value;
        $target->date = $date;
        $target->created_at = Carbon::now();
        $target->updated_at = Carbon::now();

        if($target->save()){
            return back()->with(array('message' => 'Target Added successfully.', 
                                  'alert-type' => 'success'));
                        
        } else {
            return backwith(array('message' => 'There was a problem adding target for this agent right now.', 
                                  'alert-type' => 'error'));
        }
    }


}
