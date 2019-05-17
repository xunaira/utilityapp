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
    public function generate_string($strength = 6) {
        $input = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $input_length = strlen($input);
        $random_string = '';
        for($i = 0; $i < $strength; $i++) {
            $random_character = $input[mt_rand(0, $input_length - 1)];
            $random_string .= $random_character;
        }

        return $random_string;
    }

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
        
        $request->validate([
        'product_id' => 'required|unique:products',
        ]);
        $data = new Product;
        // $data->fill($request->all());
        // $data->product_id = $this->generate_string();
        $data->product_id = $_POST['product_id'];
        $data->product_name = $_POST['product_name'];
        $data->product_price = $_POST['product_price'];

        if ($data->save()) {
            return redirect("/product")->with('success','Product added successfully.');
        } else {
            return redirect("/product")->with('error','Product Not Added');
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
        return view('products.edit', ['product'=>Product::find($id)]);
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
         return redirect("/product")->with('success','Product updated successfully.');
     } else {
        return redirect("/product")->with('error','Product Not updated');
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
