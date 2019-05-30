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
                            <form action="{{url('admin/agents/update')}}" method="post" class="form-horizontal" enctype="multipart/form-data">
                                @csrf
                                @foreach($agents as $agents)
                                <div class="row form-group">
                                    <div class="col col-md-4">
                                        <label for="text-input" class=" form-control-label">Agent Name</label>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <input type="text" id="name" name="name" class="form-control" value="{{$agents->name}}">
                                        <input type="text" id="id" name="id" value="{{$agents->id}}" class="d-none">
                                        <input type="text" id="email" name="email" value="{{$agents->email}}" class="d-none">
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
                                        <label for="text-input" class=" form-control-label">Agent Commission (%)</label>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <input type="text" id="commission" name="commission" class="form-control" value="{{$agents->commission}}">
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-4">
                                        <label for="text-input" class=" form-control-label">Agent Salary (if applies)</label>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <input type="text" id="salary" name="salary" class="form-control" value="{{$agents->salary}}">
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-4">
                                        <label for="text-input" class=" form-control-label">Agent Type</label>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <select class="form-control" name="type" id="type">
                                            <option value="">- SELECT AGENT TYPE - </option>
                                            @if($agents->agent_type == 'funded agents')
                                            <option value="self funded agent">Self Funded Agent</option>
                                            <option value="funded agents" selected>Funded Agents</option>
                                            @else
                                            <option value="self funded agent" selected>Self Funded Agent</option>
                                            <option value="funded agents">Funded Agents</option>
                                            @endif
                                        </select>
                                    </div>
                                </div>  
                                <div class="row form-group">
                                    <div class="col col-md-4">
                                        <label for="text-input" class=" form-control-label">Supervisor</label>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <select class="form-control" name="sup" id="sup" required>
                                            <option value="">- SELECT SUPERVISOR - </option>
                                            @foreach($sup as $s)
                                                @if($s->id == $agents->supervisor_id)
                                                    <option value="{{$s->id}}" selected>{{$s->name}}</option>
                                                @else
                                                    <option value="{{$s->id}}">{{$s->name}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-4">
                                        <label for="text-input" class=" form-control-label">Upload KYC</label>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <input type="file" class="form-control mb-2" name="kyc" id="kyc">
                                        <?php $url = $agents->kyc; ?>
                                        <a href="{{Storage::url($url)}}" class="btn-info pl-3 pr-3" target="_blank">View KYC</a>
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
