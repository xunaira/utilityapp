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
use Carbon;

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
            ->orderBy('add_sales.date', 'DESC')
            ->paginate(10);

        $pending = DB::table('add_sales')
            ->join('products', 'add_sales.product_id', '=', 'products.id')
            ->join('users', 'add_sales.agent', '=', 'users.agent_id')
            ->select('add_sales.*', 'products.product_name', 'users.name')
            ->where('status', 'Pending Approval')
            ->orderBy('add_sales.date', 'DESC')
            ->paginate(10);
        
        $approved = DB::table('add_sales')
            ->join('products', 'add_sales.product_id', '=', 'products.id')
            ->join('users', 'add_sales.agent', '=', 'users.agent_id')
            ->select('add_sales.*', 'products.product_name', 'users.name')
            ->where('status', 'Approved')
            ->orderBy('add_sales.date', 'DESC')
            ->paginate(10);

        $rejected = DB::table('add_sales')
            ->join('products', 'add_sales.product_id', '=', 'products.id')
            ->join('users', 'add_sales.agent', '=', 'users.agent_id')
            ->select('add_sales.*', 'products.product_name', 'users.name')
            ->where('status', 'Rejected')
            ->orderBy('add_sales.date', 'DESC')
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
            ->where([['wallet.date', Carbon\Carbon::now()->toDateString()], ['users.company_id', Auth::user()->company_id]])
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
            $wallet = Wallet::where([['user_id', $id], ['date', Carbon\Carbon::now()->toDateString()]])->get();

            if(!empty($wallet)){
                $data =new AgentSales;
                $data->sale_value = $request->get('sale_value');
                $data->product_id = $request->get('product_id');
                $data->status = "Pending Approval";
                $data->agent = $id;
                $data->date = Carbon\Carbon::now()->toDateString();
                $data->created_at = Carbon\Carbon::now();
                $data->updated_at = Carbon\Carbon::now();
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
        $today = Carbon\Carbon::now()->toDateString();
        $sales = AgentSales::find($id);

        $wallet = Transactions::where([['agent_id', $sales->agent], ['date', ">=", $today]])->select('closing_balance')->orderBy('created_at', 'DESC')->first();

        if(!empty($wallet)){
            $sale_value = $wallet->closing_balance + $sales->sale_value;
            
            $sell = Transactions::where('sales_id', $sales->id)->first();
            //dd($sell);
            $delete = new Transactions;
            $delete->sales_id = $sales->id;
            $delete->agent_id = $sell->agent_id;
            $delete->wallet_id = $sell->wallet_id;
            $delete->date = Carbon\Carbon::now()->toDateString();
            $delete->created_at = Carbon\Carbon::now()->toDateString();
            $delete->updated_at = Carbon\Carbon::now()->toDateString();
            $delete->flag = "active";
            $delete->closing_balance = $sale_value;

            if($delete->save()){
               $sell->flag = "deleted";
               if ($sales->save()) {
                    return redirect("admin/agent-sales")->with(array('message' => 'Your sale has been deleted successfully.', 
                          'alert-type' => 'success'));
                } else {
                    return redirect("admin/agent-sales")->with(array('message' => 'There was a problem deleting this sale. Contact IT Administrator', 
                      'alert-type' => 'error'));
                }

            }else{
               return redirect("admin/agent-sales")->with(array('message' => 'There was a problem deleting this sale. Contact IT Administrator', 
                      'alert-type' => 'error'));
            }

        }
    }

    public function getTotalBalance(Request $r){
        $id = $r->get('id');   

        $today = Carbon\Carbon::now()->toDateString();        
        //check if sale is already added for today or not 
        $sale = AgentSales::where([['agent', $id], ['date', ">=", $today], ['status', 'Approved']])->orderBy('created_at', 'DESC')->get();       

        if(empty($sale)){
            $t = Transactions::where('agent_id', $id)->select('closing_balance')->orderBy('created_at', 'DESC')->first();            
            $b = $t->closing_balance;
            
        }else{
          $b = Wallet::where([['user_id', $id], ['date', ">=", $today]])->select('total_funds')->first();
        }

        return response()->json(['funds'=>$b]);

    }

    public function approve($id){
        $sales_id = $id;
        $today = Carbon\Carbon::now()->toDateString();
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
            $t->flag = "active";
            $funds = $wallet->total_funds;
            $t->closing_balance = $funds - $sale->sale_value;
            $t->created_at = Carbon\Carbon::now();
            $t->created_at = Carbon\Carbon::now();

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
            $t->created_at = Carbon\Carbon::now();
            $t->created_at = Carbon\Carbon::now();


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
        $today = Carbon\Carbon::now()->toDateString();
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
