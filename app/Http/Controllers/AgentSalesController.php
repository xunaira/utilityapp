<?php

namespace App\Http\Controllers;
use App\Product;
use App\AgentSales;
use Illuminate\Http\Request;
use Auth;
use App\agents_migration as Agents;
use DB;
use App\Wallet;
use Carbon\Carbon;

class AgentSalesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sales = DB::table('add_sales')
            ->join('products', 'add_sales.product_id', '=', 'products.id')
            ->join('users', 'add_sales.agent', '=', 'users.agent_id')
            ->select('add_sales.*', 'products.product_name', 'users.name')
            ->get();
        return view("agentsales.content",compact('sales'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $products = Product::all();
        $agents = DB::table('users')
            ->join('agents', 'users.agent_id', '=', 'agents.id')
            ->join('wallet', 'users.id', '=', 'wallet.user_id')
            ->select('users.name', 'users.username', 'users.email','agents.*', 'wallet.*', 'users.agent_id')
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

        if($validatedData) {
            $data =new AgentSales;
            $data->fill($request->all());
            if ($data->save()) {
                return back()->with('success','Sale added successfully.');
            } else {
                return back()->with('error','Sale Not updated');
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
        $id=$request->product_id;
        $getProduct=Product::where('id', $id)->first();
       
        return response()->json(['comission'=>$getProduct->comm_self]);
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
                return back()->with('success','Sale updated successfully.');
            } else {
                return back()->with('error','Sale Not updated');
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
            return back()->with('success','Sale Deleted successfully.');
        } else {
            return back()->with('error','Sale Not Deleted');
        }
    }

    public function getTotalBalance(Request $r){
        $id = $r->get('id');
        $today = Carbon::now()->toDateString();
        
        $b = Wallet::where([['user_id', $id], ['date', ">=", $today]])->select('total_funds')->get();

        return response()->json(['funds'=>$b]);

    }
}
