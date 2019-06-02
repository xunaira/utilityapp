@extends('admin.app')

@section('content')
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8 mx-auto d-block">
                    <div class="card">
                        <div class="card-header">
                            <strong>Add Company</strong>
                        </div>
                        <div class="card-body card-block">
                            <form action="../../admin/company/store" method="post" class="form-horizontal" enctype="multipart/form-data">
                                @csrf
                                @foreach($company as $c)
                                <div class="row form-group">
                                    <div class="col col-md-4">
                                        <label for="text-input" class=" form-control-label">Company Name</label>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <input type="text" id="name" name="name" class="form-control" value="{{$c->name}}">
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-4">
                                        <label for="text-input" class=" form-control-label">Company Email</label>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <input type="email" id="email" name="email" class="form-control" value="{{$c->email}}">
                                    </div>
                                </div>                                
                                <div class="row form-group">
                                    <div class="col col-md-4">
                                        <label for="text-input" class=" form-control-label">Company Phone Number</label>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <input type="number" id="phone_no" name="phone_no" class="form-control" value="{{$c->phone}}">
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-4">
                                        <label for="text-input" class=" form-control-label">Address 1</label>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <input type="text" id="address1" name="address1" class="form-control" value="{{$c->address1}}">
                                    </div>
                                </div>  
                                <div class="row form-group">
                                    <div class="col col-md-4">
                                        <label for="text-input" class=" form-control-label">Address 2</label>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <input type="text" id="address2" name="address2" class="form-control" value="{{$c->address2}}">
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-4">
                                        <label for="text-input" class=" form-control-label">City</label>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <input type="text" id="city" name="city" class="form-control" value="{{$c->city}}">
                                    </div>
                                </div> 
                                <div class="row form-group">
                                    <div class="col col-md-4">
                                        <label for="text-input" class=" form-control-label">State</label>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <input type="text" id="state" name="state" class="form-control" value="{{$c->state}}">
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-4">
                                        <label for="text-input" class=" form-control-label">Country</label>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <input type="text" id="country" name="country" class="form-control" value="{{$c->country}}">
                                    </div>
                                </div> 
                                <div class="row form-group">
                                    <div class="col col-md-4">
                                        <label for="text-input" class=" form-control-label">Role</label>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <select class="form-control" name="role" id="role">
                                            <option value="">- SELECT ROLE - </option>
                                            @foreach($roles as $role)
                                                @if($role->id == $c->role_id)
                                                    <option value="{{$c->role_id}}" style="text-transform: capitalize;" selected>{{$role->name}}</option> 
                                                @else
                                                    <option value="{{$role->id}}" style="text-transform: capitalize;">{{$role->name}}</option> 
                                                @endif                                               
                                            @endforeach
                                        </select>
                                    </div>
                                </div>  
                            @endforeach                                                  
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary btn-sm float-right">
                                <i class="fa fa-dot-circle-o"></i> Submit
                            </button>
                             <a href="{{url('admin/agents')}}"><button type="reset" class="btn btn-danger btn-sm">
                                <i class="fa fa-ban"></i> Cancel
                            </button></a>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
