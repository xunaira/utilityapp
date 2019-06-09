<?php

namespace App\Http\Controllers;
use App\Product;
use App\AgentSales;
use Illuminate\Http\Request;
use Auth;
use App\agents_migration as Agents;
use DB;
use App\Wallet;
use App\Transactions;
use Carbon\Carbon;

class AgentSalesController extends Controller
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
        $all = DB::table('add_sales')
            ->join('products', 'add_sales.product_id', '=', 'products.id')
            ->join('users', 'add_sales.agent', '=', 'users.agent_id')
            ->select('add_sales.*', 'products.product_name', 'users.name')
            ->get();

        $pending = DB::table('add_sales')
            ->join('products', 'add_sales.product_id', '=', 'products.id')
            ->join('users', 'add_sales.agent', '=', 'users.agent_id')
            ->select('add_sales.*', 'products.product_name', 'users.name')
            ->where('status', 'Pending Approval')
            ->get();
        
        $approved = DB::table('add_sales')
            ->join('products', 'add_sales.product_id', '=', 'products.id')
            ->join('users', 'add_sales.agent', '=', 'users.agent_id')
            ->select('add_sales.*', 'products.product_name', 'users.name')
            ->where('status', 'Approved')
            ->get();

        $rejected = DB::table('add_sales')
            ->join('products', 'add_sales.product_id', '=', 'products.id')
            ->join('users', 'add_sales.agent', '=', 'users.agent_id')
            ->select('add_sales.*', 'products.product_name', 'users.name')
            ->where('status', 'Rejected')
            ->get();
        return view("agentsales.content",compact('pending', 'all', 'approved', 'rejected'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $products = Product::where('company_id', Auth::user()->company_id)->get();
        $agents = DB::table('users')
            ->join('agents', 'users.agent_id', '=', 'agents.id')
            ->join('wallet', 'agents.id', '=', 'wallet.user_id')
            ->select('users.name', 'users.username', 'users.email','agents.*', 'wallet.*', 'users.agent_id')
            ->where([['wallet.date', Carbon::now()->toDateString()], ['users.company_id', Auth::user()->company_id]])
            ->get();
        
        return view("agentsales.add",['products' => $products, 'agents' => $agents]);
    } 

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
        'product_id' => 'required|max:255',
        'sale_value' => 'required|numeric',
        'date' => 'required',
        ]);

        if(Auth::user()->role_id == 1 || Auth::user()->role_id == 2){          
          $id = $request->get('agent');
        }elseif(Auth::user()->role_id == 3){
          $id = Auth::user()->agent_id;
        }
        
        if($validatedData) {
            //check if wallet exists for this agent
            $wallet = Wallet::where([['user_id', $id], ['date', Carbon::now()->toDateString()]])->get();

            if(!empty($wallet)){
                $data =new AgentSales;
                $data->sale_value = $request->get('sale_value');
                $data->product_id = $request->get('product_id');
                $data->status = "Pending Approval";
                $data->agent = $id;
                $data->date = Carbon::now()->toDateString();
                $data->created_at = Carbon::now();
                $data->updated_at = Carbon::now();
                if ($data->save()) {
                    return redirect("admin/agent-sales")->with(array('message' => 'Your sale has been submitted successfully. The sale will be visible when admin has approved it.', 
                          'alert-type' => 'success'));
                } else {
                    return redirect("admin/agent-sales")->with(array('message' => 'There was a problem adding this sale. Contact IT Administrator', 
                      'alert-type' => 'error'));
                }

            }
        }
    }

     /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function productGet(Request $request)
    {
       $id = $request->product_id;

        $getProduct = Product::where([['id', $id], ['company_id', Auth::user()->company_id]])->select('comm_self')->first();

        
        return response()->json(['comission' => $getProduct->comm_self]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $sales = DB::table('add_sales')
            ->join('products', 'add_sales.product_id', '=', 'products.id')
            ->select('add_sales.*', 'products.product_name')
            ->where('add_sales.id', $id)
            ->get();
        $products = Product::all();
         $agents = DB::table('users')
            ->join('agents', 'users.agent_id', '=', 'agents.id')
            ->select('users.name', 'users.username', 'users.email','agents.*')
            ->get();
        return view('agentsales.edit', ['sales' => $sales, 'products' => $products, 'agents' => $agents]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'id' => 'required',
        'product_id' => 'required|max:255',
        'sale_value' => 'required|numeric',
        'date' => 'required',
        ]);

        if($validatedData) {
            $data = AgentSales::find($request->get('id'));
            $data->fill($request->all());
            if ($data->save()) {
                    return redirect("admin/agent-sales")->with(array('message' => 'Your sale has been submitted successfully. The sale will be visible when admin has approved it.', 
                          'alert-type' => 'success'));
                } else {
                    return redirect("admin/agent-sales")->with(array('message' => 'There was a problem updating this sale. Contact IT Administrator', 
                      'alert-type' => 'error'));
                }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $sales = AgentSales::find($id);
        
        if(!is_null($sales)) {

            $sales->delete();
            if ($data->save()) {
                    return redirect("admin/agent-sales")->with(array('message' => 'Your sale has been deleted successfully.', 
                          'alert-type' => 'success'));
                } else {
                    return redirect("admin/agent-sales")->with(array('message' => 'There was a problem deleting this sale. Contact IT Administrator', 
                      'alert-type' => 'error'));
                }
            }
    }

    public function getTotalBalance(Request $r){
        $id = $r->get('id');      
        $today = Carbon::now()->toDateString();        
        $b = Wallet::where([['user_id', $id], ['date', ">=", $today]])->select('total_funds')->get();

        //check if sale is already added for today or not 
        $sale = AgentSales::where([['agent', "5"], ['date', ">=", $today]])->get();
        dd($sale);

        return response()->json(['funds'=>$b]);

    }

    public function approve($id){
        $sales_id = $id;
        $today = Carbon::now()->toDateString();
        $sale = AgentSales::find($id);
        $agent_id = $sale->agent;
        $wallet = Wallet::where([['user_id', $agent_id], ['date', $today]])->orderBy('date', 'DESC')->first();
        $wallet_id = $wallet->id;
        $w = Transactions::where('wallet_id', $wallet_id)->orderBy('date', 'DESC')->first();

        if(empty($w)){
            //create Transaction
            $t = new Transactions;
            $t->sales_id = $id;
            $t->wallet_id = $wallet_id;
            $t->agent_id = $agent_id;
            $t->date = $today;
            $funds = $wallet->total_funds;
            $t->closing_balance = $funds - $sale->sale_value;

             if($t->save()){
                $s = AgentSales::find($id);
                $s->status = "Approved";
                if($s->save()){
                    return redirect("admin/agent-sales")->with(array('message' => 'Sale has been approved.', 
                          'alert-type' => 'success'));
                }else{
                    return redirect("admin/agent-sales")->with(array('message' => 'There was a problem approving this sale. Contact IT Administrator', 
                          'alert-type' => 'error'));
                }

                return redirect("admin/agent-sales")->with(array('message' => 'There was a problem approving this sale. Contact IT Administrator', 
                          'alert-type' => 'error'));
                
            }else{
                return redirect("admin/agent-sales")->with(array('message' => 'There was a problem approving this sale. Contact IT Administrator', 
                          'alert-type' => 'error'));
            }
        }else{
            $remaining = $w->closing_balance;
            $t = new Transactions;
            $t->sales_id = $id;
            $t->wallet_id = $wallet_id;
            $t->agent_id = $agent_id;
            $t->date = $today;
            $funds = $wallet->total_funds;
            $t->closing_balance = $remaining - $sale->sale_value;

            if($t->save()){
                $s = AgentSales::find($id);
                $s->status = "Approved";
                if($s->save()){
                    return redirect("admin/agent-sales")->with(array('message' => 'Sale has been approved.', 
                          'alert-type' => 'success'));
                }else{
                    return redirect("admin/agent-sales")->with(array('message' => 'There was a problem approving this sale. Contact IT Administrator', 
                          'alert-type' => 'error'));
                }

                return redirect("admin/agent-sales")->with(array('message' => 'There was a problem approving this sale. Contact IT Administrator', 
                          'alert-type' => 'error'));
                
            }else{
                return redirect("admin/agent-sales")->with(array('message' => 'There was a problem approving this sale. Contact IT Administrator', 
                          'alert-type' => 'error'));
            }


        }

        


        //$sale->status = "Approved";
        if($sale->save()){
            //if the admin wants to approve this transaction
            //create a new transaction 
            //wallet_id, sale_id, agent_id 


        }
            
                
    }

    public function reject($id){
        $sales_id = $id;
        $today = Carbon::now()->toDateString();
        $sale = AgentSales::find($id);
        $sale->status = "Rejected";

        if($sale->save()){
             return redirect("admin/agent-sales")->with(array('message' => 'Your sale has been rejected successfully.', 
                          'alert-type' => 'success'));
        }else{
            return redirect("admin/agent-sales")->with(array('message' => 'There was a problem deleting this sale. Contact IT Administrator', 
                      'alert-type' => 'error'));
        }
              
    }
}
