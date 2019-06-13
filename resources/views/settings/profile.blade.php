@extends('admin.app')

@section('content')
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8 mx-auto d-block">
                    <div class="card">
                        <div class="card-header">
                            <strong>Update Profile</strong>
                        </div>
                        <div class="card-body card-block">
                            <form action="../../admin/settings/profile" method="post" class="form-horizontal" enctype="multipart/form-data">
                                @csrf
                                <div class="row form-group">
                                    <div class="col col-md-4">
                                        <label for="text-input" class=" form-control-label">Name</label>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <input type="text" id="name" name="name" class="form-control" value="{{$user->name}}">
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-4">
                                        <label for="text-input" class=" form-control-label">Username</label>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <input type="text" id="username" name="username" class="form-control" value="{{$user->username}}">
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-4">
                                        <label for="text-input" class=" form-control-label">Phone Number</label>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <input type="text" id="phone_no" name="phone_no" class="form-control" value="{{$user->phone_no}}">
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-4">
                                        <label for="text-input" class=" form-control-label">Address 1</label>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <input type="text" id="address1" name="address1" class="form-control" value="{{$user->address_line_1}}">
                                    </div>
                                </div>  
                                <div class="row form-group">
                                    <div class="col col-md-4">
                                        <label for="text-input" class=" form-control-label">Address 2</label>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <input type="text" id="address2" name="address2" class="form-control" value="{{$user->address_line_2}}">
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-4">
                                        <label for="text-input" class=" form-control-label">City</label>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <input type="text" id="city" name="city" class="form-control" value="{{$user->city}}">
                                    </div>
                                </div> 
                                <div class="row form-group">
                                    <div class="col col-md-4">
                                        <label for="text-input" class=" form-control-label">State</label>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <input type="text" id="state" name="state" class="form-control" value="{{$user->state}}">
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-4">
                                        <label for="text-input" class=" form-control-label">Country</label>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <input type="text" id="country" name="country" class="form-control" value="{{$user->country}}">
                                    </div>
                                </div>
                                @if(Auth::user()->role_id == 1 || Auth::user()->role_id == 2) 
                                <div class="row form-group">
                                    <div class="col col-md-4">
                                        <label for="text-input" class=" form-control-label">Operational Area</label>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <input type="text" id="operational_area" name="operational_area" class="form-control">
                                    </div>
                                </div>
                                @endif
                                <div class="row form-group">
                                    <div class="col col-md-4">
                                        <label for="text-input" class=" form-control-label">Profile Picture</label>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <input type="file" class="form-control" name="pic" id="pic">
                                    </div>
                                </div>
                                @if($user->pic != 'NULL' || !empty($user->pic))
                                <div class="row form-group">
                                	<div class="col col-md-4"></div>
                                	<div class="col col-md-6">
                                		<img src="{{Storage::url($user->pic)}}" alt="Profile Pic" class="img-fluid"> 
                                	</div>
                                </div> 
                                @endif        
                                                 
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
