@extends('admin.app')

@section('content')
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8 mx-auto d-block">
                    <div class="card">
                        <div class="card-header">
                            <strong>Edit Agent</strong>
                        </div>
                        <div class="card-body card-block">
                            <form action="../../agents/update" method="post" class="form-horizontal">
                                @csrf
                                <div class="row form-group">
                                    <div class="col col-md-4">
                                        <label for="text-input" class=" form-control-label">Agent Name</label>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <input type="text" id="name" name="name" class="form-control" value="{{$agents->name}}">
                                        <input type="text" id="id" name="id" class="form-control" value="{{$agents->id}}">
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-4">
                                        <label for="text-input" class=" form-control-label">Username</label>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <input type="text" id="username" name="username" class="form-control" value="{{$agents->username}}">
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-4">
                                        <label for="text-input" class=" form-control-label">Password</label>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <input type="password" id="password" name="password" class="form-control">
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-4">
                                        <label for="text-input" class=" form-control-label">Agent Email</label>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <input type="email" id="email" name="email" class="form-control" value="{{$agents->email}}">
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-4">
                                        <label for="text-input" class=" form-control-label">Agent Phone Number</label>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <input type="text" id="phone_no" name="phone_no" class="form-control" value="{{$agents->phone_no}}">
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-4">
                                        <label for="text-input" class=" form-control-label">Address 1</label>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <input type="text" id="address1" name="address1" class="form-control" value="{{$agents->address1}}">
                                    </div>
                                </div>  
                                <div class="row form-group">
                                    <div class="col col-md-4">
                                        <label for="text-input" class=" form-control-label">Address 2</label>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <input type="text" id="address2" name="address2" class="form-control" value="{{$agents->address2}}">
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-4">
                                        <label for="text-input" class=" form-control-label">City</label>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <input type="text" id="city" name="city" class="form-control" value="{{$agents->city}}">
                                    </div>
                                </div> 
                                <div class="row form-group">
                                    <div class="col col-md-4">
                                        <label for="text-input" class=" form-control-label">State</label>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <input type="text" id="state" name="state" class="form-control" value="{{$agents->state}}">
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-4">
                                        <label for="text-input" class=" form-control-label">Country</label>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <input type="text" id="country" name="country" class="form-control" value="{{$agents->country}}">
                                    </div>
                                </div> 
                                <div class="row form-group">
                                    <div class="col col-md-4">
                                        <label for="text-input" class=" form-control-label">Operational Area</label>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <input type="text" id="operational_area" name="operational_area" class="form-control" value="{{$agents->operational_area}}">
                                    </div>
                                </div> 
                                <div class="row form-group">
                                    <div class="col col-md-4">
                                        <label for="text-input" class=" form-control-label">Agent Type</label>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <select class="form-control" name="type" id="type">
                                            @if($agents->agent_type == "self funded agent")
                                            <option value="self funded agent" selected>Self Funded Agent</option>
                                            <option value="funded agents">Funded Agents</option>
                                            @else
                                            <option value="self funded agent">Self Funded Agent</option>
                                            <option value="funded agents" selected>Funded Agents</option>
                                            @endif
                                        </select>
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
