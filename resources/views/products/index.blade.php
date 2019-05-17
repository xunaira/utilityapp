@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <table class="table table-responsive table-hover  table-striped  ">
                    <tr>
                        <th>Product Name</th>
                        <th>Product Price</th>
                        <th>Product Created</th>
                        <th>Product Updated</th>
                        <th>Action</th>

                    </tr>
                    @foreach($product as $product)
                    <tr>
                        <td>{{$product->product_name}}</td>
                        <td>{{$product->product_price}}</td>
                        <td>{{$product->created_at}}</td>
                        <td>{{$product->updated_at}}</td>
                        <td>
                            <a href="/product/edit/{{$product->id}}">Edit</a>
                            <a href="/product/delete/{{$product->id}}">/Delete</a>
                        </td>

                    </tr>
                    @endforeach
                </table>
    </div>
</div>
@endsection
