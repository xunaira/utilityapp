<?php

namespace App\Http\Controllers;
use App\Product;
use Illuminate\Http\Request;
use Auth;
use App\AgentSales;
use App\agents_migration as Agents;

class AgentSalesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $sales = AgentSales::all();
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
        $agents = Agents::all();
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
            'product' => 'required',
            'value' => 'required',
            'date' => 'required'
        ]);

        $sales = new AgentSales();

        $user_id = Auth::user()->id;
        if(Auth::user()->role_id == '1' || Auth::user()->role_id == '2'){
            $sales->admin_id = $user_id;
        }else{
            $sales->user_id = $user_id;
        }
        $sales->product_id = $request->get('product');
        $sales->value = $request->get('value');
        $sales->date = $request->get('date');

        if ($sales->save()) {
            return redirect("admin/agent-sales")->with('success','Sale added successfully.');
        } else {
            return redirect("admin/agent-sales")->with('error','Sale Not Added');
        }

        
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
}
