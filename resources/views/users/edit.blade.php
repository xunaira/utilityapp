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
                                        <label for="text-input" class=" form-control-label">Username</label>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <input type="text" id="name" name="name" class="form-control" value="{{$agents->name}}">
                                        <input type="text" id="id" name="id" class="form-control d-none" value="{{$agents->id}}">
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
                                        <label for="text-input" class=" form-control-label">Email Address</label>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <input type="email" id="email" name="email" class="form-control" value="{{$agents->email}}">
                                    </div>
                                </div>  
                                <div class="row form-group">
                                    <div class="col col-md-4">
                                        <label for="text-input" class=" form-control-label">Role</label>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <select class="form-control" name="role" id="role">
                                            @foreach($roles as $role)
                                                @if($agents->role_id == $role->id)
                                                    <option value="{{$role->id}}" selected>{{$role->name}}</option>
                                                @else
                                                    <option value="{{$role->id}}">{{$role->name}}</option>
                                                @endif
                                            @endforeach
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
