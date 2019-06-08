<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use Auth;
class ProductController extends Controller
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
        //
        $product = Product::where('company_id', Auth::user()->company_id)->get();
        return view('products.index', compact('product'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('products.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Responser
     */
    public function store(Request $request)
    {
        $data = new Product;
        $data->product_name = $_POST['product_name'];
        $data->comm_self_funded = $_POST['comm_self_funded'];
        $data->comm_funded = $_POST['comm_funded'];
        $data->comm_self = $_POST['comm_self'];
        $data->company_id = Auth::user()->company_id;

        if ($data->save()) {
            return redirect("admin/products")->with(
                array('message' => 'Product added successfully.', 
                      'alert-type' => 'success'));
        } else {
            return redirect("admin/products")->with(array('message' => 'There was a problem adding your product', 
                      'alert-type' => 'error'));
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
        $product = Product::find($id);
        return view('products.edit', ['product'=> $product]);
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
        $data = Product::find($id);
        $data->product_name = $_POST['product_name'];
        $data->comm_self_funded = $_POST['comm_self_funded'];
        $data->comm_funded = $_POST['comm_funded'];
        $data->comm_self = $_POST['comm_self'];
        $data->company_id = Auth::user()->company_id;

        if ($data->save()) {
            return redirect("admin/products")->with(
                array('message' => 'Product updated successfully.', 
                      'alert-type' => 'success'));
        } else {
            return redirect("admin/products")->with(array('message' => 'There was a problem updating your product', 
                      'alert-type' => 'error'));
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
        $product = Product::find($id);
        
        if(!is_null($product)) {

            $product->delete();
            return redirect("admin/products")->with(
                array('message' => 'Product deleted successfully.', 
                      'alert-type' => 'success'));
        } else {
            return redirect("admin/products")->with(array('message' => 'There was a problem deleting your product', 
                      'alert-type' => 'error'));
        }

    }
}
