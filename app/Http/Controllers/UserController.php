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
use Excel;


class UserController extends Controller
{
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
            ->select('users.*','agents.*', 'supervisor.name as sup')
            ->get();
        }else{
            $agents = DB::table('agents')
            ->join('supervisor', 'supervisor.user_id', '=', 'agents.supervisor_id')
            ->join('users', 'agents.id', '=', 'users.agent_id')
            ->select('users.*','agents.*', 'supervisor.name as sup')
            ->where('supervisor_id', Auth::user()->id)
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
        if(Auth::user()->role_id == 1){
            $agents = DB::table('agents')
            ->join('supervisor', 'supervisor.user_id', '=', 'agents.supervisor_id')
            ->join('users', 'agents.id', '=', 'users.agent_id')
            ->select('users.*','agents.*', 'supervisor.name as sup')
            ->where('agents.id', $id)
            ->get();
            $sup = DB::table('supervisor')->select('id', 'name')->get();
        }else{
            $agents = DB::table('agents')
            ->join('supervisor', 'supervisor.user_id', '=', 'agents.supervisor_id')
            ->join('users', 'agents.id', '=', 'users.agent_id')
            ->select('users.*','agents.*', 'supervisor.name as sup')
            ->where([['supervisor_id', Auth::user()->id], ['agents.id', $id]])
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

            if ($user->save()) {
                return redirect("admin/agents")->with('success','Agent added successfully.');
            } else {
                return redirect("admin/agents")->with('error','Agent Not Added');
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
        
        $cash_in_hand = $r->get('cash_hand');
        $cash_bank = $r->get('cash_bank');
        
        $wallet->total_funds = $cash_in_hand + $cash_bank;
        $wallet->cash_in_hand = $cash_in_hand;
        $wallet->cash_bank = $cash_bank;
        
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

    //    $wallet = Wallet::where([['user_id', $id], ['date', Carbon::now()->toDateString()]])->select('total_funds')->first();
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
                        

        return view('users.detail', ['agents' => $agents, 'w' => $w, 'balance' => $balance, 'transactions' => $transactions]);
    }

    public function export(){
       return Excel::download(new AgentExport, 'invoices.xlsx');
    }
}
