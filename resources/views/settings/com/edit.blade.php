@extends('admin.app')

@section('content')
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8 mx-auto d-block">
                    <div class="card">
                        <div class="card-header">
                            <strong>Commissions</strong>
                        </div>
                        <div class="card-body card-block">
                            <form action="{{url('admin/settings/update')}}" method="post" class="form-horizontal">
                                @csrf
                                <div class="row form-group">
                                    <div class="col col-md-4">
                                        <label for="text-input" class=" form-control-label">Set Commissions (%)</label>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <input type="text" id="comm" name="comm_percent" class="form-control" value="{{$value->comm}}">
                                        <input type="text" id="id" name="id" class="form-control d-none" value="{{$value->id}}">
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-4">
                                        <label for="text-input" class=" form-control-label">Set Commission Threshold</label>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <input type="text" id="value" name="value" class="form-control" value="{{$value->value}}">
                                    </div>
                                </div>     
                                <div class="row form-group">
                                    <div class="col col-md-4">
                                        <label for="text-input" class=" form-control-label">Agent Type</label>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <select class="form-control" name="type" id="type">
                                            @if($value->type == "self funded agents")
                                                <option value="self funded agents" selected>Self Funded Agent</option>
                                                <option value="funded agents">Funded Agents</option>
                                            @else
                                                <option value="self funded agents">Self Funded Agent</option>
                                                <option value="funded agents" selected>Funded Agents</option>
                                            @endif
                                        </select>
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
