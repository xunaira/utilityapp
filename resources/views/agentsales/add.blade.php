@extends('admin.app')

@section('content')
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8 mx-auto d-block">
                    <div class="card">
                        <div class="card-header">
                            <strong>Add Sale</strong>
                        </div>
                        <div class="card-body card-block">
                            <form action="../../admin/agent-sales/store" method="post" class="form-horizontal">
                                @csrf
                                <div class="row form-group">
                                    <div class="col col-md-4">
                                        <label for="text-input" class=" form-control-label">Product</label>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <select name="product" class="form-control @error('product') is-invalid @enderror" id="text-input">
                                            <option value="">-- SELECT PRODUCT --</option>
                                        @foreach($products as $p)
                                            <option value="{{$p->id}}">{{$p->product_name}}</option>
                                        @endforeach
                                        @error('product')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                        </select>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-4">
                                        <label for="text-input" class=" form-control-label">Value of Sales</label>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <input type="number" id="sales_value" name="value" class="form-control @error('value') is-invalid @enderror">
                                        @error('value')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-4">
                                        <label for="text-input" class=" form-control-label">Date</label>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <input type="date" id="date" name="date" class="form-control @error('product') is-invalid @enderror" value="<?php echo date('Y-m-d'); ?>">
                                        @error('date')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div> 
                                @if(Auth::user()->role_id == 1 || Auth::user()->role_id == 2)
                                    <div class="row form-group">
                                        <div class="col col-md-4">
                                            <label for="text-input" class=" form-control-label">Agent Name</label>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <select name="product" class="form-control @error('product') is-invalid @enderror" id="text-input">
                                                <option value="">-- SELECT AGENT --</option>
                                            @foreach($agents as $a)
                                                <option value="{{$a->id}}">{{$a->name}}</option>
                                            @endforeach
                                            @error('product')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                            </select>
                                        </div>
                                    </div>
                                @endif                                         
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
