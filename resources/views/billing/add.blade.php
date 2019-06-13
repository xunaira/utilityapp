@extends('admin.app')

@section('content')
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <strong>Add Bill</strong>
                        </div>
                        <form action="../../admin/billing/create" method="post" class="form-horizontal">
                                @csrf
                            <div class="card-body card-block">
                                    <div class="row form-group">
                                        <div class="col col-md-4">
                                            <label for="text-input" class=" form-control-label">Customer Name</label>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <input type="text" id="name" name="name" required class="form-control">
                                        </div>                                        
                                    </div> 
                                    <div class="row form-group">
                                        <div class="col col-md-4">
                                            <label for="text-input" class=" form-control-label">Customer Email</label>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <input type="text" id="email" name="email" required class="form-control">
                                        </div> 
                                    </div>
                                    <div class="row form-group">
                                        <div class="col col-md-4">
                                            <label for="text-input" class=" form-control-label">Phone</label>
                                        </div>
                                        <div class="col-12 col-md-6">

                                            <input type="number" id="phone" name="phone" required class="form-control">
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col col-md-4">
                                            <label for="text-input" class=" form-control-label">Serial Number</label>
                                        </div>
                                        <div class="col-12 col-md-6">

                                            <input type="number" id="serial" name="serial" required class="form-control">
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col col-md-4">
                                            <label for="text-input" class=" form-control-label">Account Name</label>
                                        </div>
                                        <div class="col-12 col-md-6">

                                            <input type="text" id="account_name" name="account_name" required class="form-control">
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col col-md-4">
                                            <label for="text-input" class=" form-control-label">Account Number</label>
                                        </div>
                                        <div class="col-12 col-md-6">

                                            <input type="number" id="account" name="account" required class="form-control">
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col col-md-4">
                                            <label for="text-input" class=" form-control-label">Address 1</label>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <input type="text" id="address1" name="address1" class="form-control">
                                        </div>
                                    </div>  
                                    <div class="row form-group">
                                        <div class="col col-md-4">
                                            <label for="text-input" class=" form-control-label">Address 2</label>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <input type="text" id="address2" name="address2" class="form-control">
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col col-md-4">
                                            <label for="text-input" class=" form-control-label">City</label>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <input type="text" id="city" name="city" class="form-control">
                                        </div>
                                    </div> 
                                    <div class="row form-group">
                                        <div class="col col-md-4">
                                            <label for="text-input" class=" form-control-label">State</label>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <input type="text" id="state" name="state" class="form-control">
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col col-md-4">
                                            <label for="text-input" class=" form-control-label">Country</label>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <input type="text" id="country" name="country" class="form-control">
                                        </div>
                                    </div> 
                                    <div class="row form-group">
                                        <div class="col col-md-4">
                                            <label for="text-input" class=" form-control-label">Status</label>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <select class="form-control">
                                                <option>--SELECT STATUS--</option>
                                                <option>Unpaid</option>
                                                <option>Paid</option>
                                                <option>Pending</option>
                                            </select>
                                        </div>
                                    </div> 
                                    <div class="row form-group">
                                        <div class="col col-md-4">
                                            <label for="text-input" class=" form-control-label">Outstanding Bill</label>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <input type="text" id="outstanding" name="outstanding" class="form-control">
                                        </div>
                                    </div> 
                                    <div class="row form-group">
                                        <div class="col col-md-4">
                                            <label for="text-input" class=" form-control-label">Current Charge</label>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <input type="text" id="charge" name="charge" class="form-control">
                                        </div>
                                    </div> 
                                    <div class="row form-group">
                                        <div class="col col-md-4">
                                            <label for="text-input" class=" form-control-label">Date</label>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <input type="date" id="date" name="date" class="form-control @error('product') is-invalid @enderror" value="<?php echo date('Y-m-d'); ?>">
                                            <input type="text" class="d-none" name="status" value="Pending Approval">
                                            @error('date')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>                                     
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary btn-sm float-right" id="submit">
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
