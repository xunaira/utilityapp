<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        //
        $product = Product::all();
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
        $data->company_name = $_POST['company_name'];
        $data->comm_self = $_POST['comm_self'];
        $data->comm_cmp = $_POST['comm_cmp'];

        if ($data->save()) {
            return redirect("admin/products")->with('success','Product added successfully.');
        } else {
            return redirect("admin/products")->with('error','Product Not Added');
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
        //


        $data = Product::find($id);
        $data->fill($request->all());
        if ($data->save()) {
         return redirect("admin/products")->with('success','Product updated successfully.');
     } else {
        return redirect("admin/products")->with('error','Product Not updated');
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
            return back()->with('success','Product Deleted successfully.');
        } else {
            return back()->with('error','Product Not Deleted');
        }

    }
}
