@extends('admin.app')

@section('content')
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8 mx-auto d-block">
                    <div class="card">
                        <div class="card-header">
                            <strong>Create Product</strong>
                        </div>
                        <div class="card-body card-block">
                            <form action="../../products/update/{{$product->id}}" method="post" class="form-horizontal">
                                @csrf
                                <div class="row form-group">
                                    <div class="col col-md-4">
                                        <label for="text-input" class=" form-control-label">Product Name</label>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <input type="text" id="product_name" name="product_name" class="form-control" value="{{$product->product_name}}">
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-4">
                                        <label for="text-input" class=" form-control-label">Commission - Self</label>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <input type="text" id="comm_self" name="comm_self" class="form-control" value="{{$product->comm_self}}">
                                    </div>
                                </div>  
                                <div class="row form-group">
                                    <div class="col col-md-4">
                                        <label for="text-input" class=" form-control-label">Commission - Self Funded Agent</label>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <input type="text" id="comm_self_funded" name="comm_self_funded" class="form-control" value="{{$product->comm_self_funded}}">
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-4">
                                        <label for="text-input" class=" form-control-label">Commission - Funded Agent</label>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <input type="text" id="comm_funded" name="comm_funded" class="form-control" value="{{$product->comm_funded}}">
                                    </div>
                                </div>
                                                 
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary btn-sm float-right">
                                <i class="fa fa-dot-circle-o"></i> Submit
                            </button>
                            <a href="{{url('admin/products')}}">
                                <button type="reset" class="btn btn-danger btn-sm">
                                    <i class="fa fa-ban"></i> Cancel
                                </button>
                            </a>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
