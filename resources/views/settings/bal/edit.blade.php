@extends('admin.app')

@section('content')
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8 mx-auto d-block">
                    <div class="card">
                        <div class="card-header">
                            <strong>System Balance</strong>
                        </div>
                        <div class="card-body card-block">
                            <form action="{{url('admin/settings/update_balance')}}" method="post" class="form-horizontal">
                                @csrf
                                <div class="row form-group">
                                    <div class="col col-md-4">
                                        <label for="text-input" class=" form-control-label">Cash in Hand</label>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <input type="text" id="cash" name="cash" class="form-control" value="{{$bal->cash_hand}}">
                                        <input type="text" name="id" id="id" value="{{$bal->id}}" class="d-none">
                                    </div>
                                </div> 
                                <div class="row form-group">
                                    <div class="col col-md-4">
                                        <label for="text-input" class=" form-control-label">Cash in Bank</label>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <input type="text" id="cash_bank" name="cash_bank" class="form-control" value="{{$bal->cash_bank}}">
                                    </div>
                                </div> 
                                <div class="row form-group">
                                    <div class="col col-md-4">
                                        <label for="text-input" class=" form-control-label">Date</label>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <input type="date" id="date" name="date" class="form-control" value="<?php echo date('Y-m-d'); ?>">
                                    </div>
                                </div>                                         
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary btn-sm float-right">
                                <i class="fa fa-dot-circle-o"></i> Add
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
