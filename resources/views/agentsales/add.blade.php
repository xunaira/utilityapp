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
                            <form action="../../admin/products/store" method="post" class="form-horizontal">
                                @csrf
                                <div class="row form-group">
                                    <div class="col col-md-4">
                                        <label for="text-input" class=" form-control-label">Product</label>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <select name="product" id="text-input">
                                        @foreach($products as $p)
                                            <option value="{{$p->id}}">{{$p->product_name}}</option>
                                        @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-4">
                                        <label for="text-input" class=" form-control-label">Value of Sales</label>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <input type="number" id="" name="company_name" class="form-control">
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-4">
                                        <label for="text-input" class=" form-control-label">Date</label>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <input type="date" id="comm_company" name="comm_cmp" class="form-control">
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-4">
                                        <label for="text-input" class=" form-control-label">Current Balance</label>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <input type="text" id="comm_self" name="comm_self" class="form-control">
                                    </div>
                                </div> 

                                 <div class="row form-group">
                                    <div class="col col-md-4">
                                        <label for="text-input" class=" form-control-label">Comission</label>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <input type="number" id="comm_self" name="comm_self" class="form-control">
                                    </div>
                                </div>  
                                                 
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary btn-sm float-right">
                                <i class="fa fa-dot-circle-o"></i> Submit
                            </button>
                            <button type="reset" class="btn btn-danger btn-sm">
                                <i class="fa fa-ban"></i> Cancel
                            </button>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
