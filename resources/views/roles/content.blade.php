@extends('admin.app')

@section('content')
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 mx-auto d-block">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="d-inline">System Users</h4>
                            <div class="float-right d-inline">
                                <a href="{{url('admin/users/add')}}">
                                    <button class="au-btn au-btn-icon au-btn--green au-btn--small">
                                        <i class="zmdi zmdi-plus"></i>Add User
                                    </button>
                                </a> 
                                <a href="{{url('admin/agents/add')}}">
                                    <button class="au-btn au-btn-icon au-btn--blue au-btn--small">
                                        <i class="zmdi zmdi-plus"></i>Add Agent
                                    </button>
                                </a> 
                                 
                            </div>
                        </div>
                        <div class="card-body">
                            <ul class="nav nav-pills mb-3 w-100" id="pills-tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="pills-self-funded" data-toggle="pill" href="#pills-sf" role="tab" aria-controls="pills-home" aria-selected="true">Administrators</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-f" role="tab" aria-controls="pills-profile"
                                        aria-selected="false">Supervisors</a>
                                </li>
                            </ul>
                            <div class="tab-content pl-3 pt-2" id="nav-tabContent">
                                <div class="tab-pane fade show active" id="pills-sf" role="tabpanel" aria-labelledby="custom-nav-home-tab">
                                    <div class="table-responsive table-responsive-data2">
                                        <table class="table table-data2">
                                            <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Username</th>
                                                    <th>Email</th>
                                                    <th>Role</th>
                                                    <th>Created At</th>
                                                    <th>Last Updated</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($agents as $p)
                                                    <tr class="tr-shadow">
                                                        
                                                        <td>{{$p->name}}</td>
                                                        <td>{{$p->username}}</td>
                                                        <td>{{$p->email}}</td>
                                                        @if($p->role_id == 1)
                                                        <td>
                                                            Admin
                                                        </td>
                                                        @else
                                                        <td>
                                                            Supervisor
                                                        </td>
                                                        @endif
                                                        <?php 
                                                            $createdAt = Carbon\Carbon::parse($p->created_at)->format('M d Y');
                                                            $updatedAt = Carbon\Carbon::parse($p->updated_at)->format('M d Y');
                                                        ?>
                                                        <td>{{$createdAt}}</td>     
                                                        <td>{{$updatedAt}}</td>                                            
                                                        <td>
                                                            <div class="table-data-feature">
                                                                <a href="../admin/users/edit/{{$p->id}}" class="pr-4">  <button class="item" title="Edit">
                                                                    <i class="zmdi zmdi-edit"></i>
                                                                    </button>
                                                                </a>
                                                                <a href="../admin/users/delete/{{$p->id}}">
                                                                    <button class="item" title="Delete">
                                                                    <i class="zmdi zmdi-delete"></i>
                                                                    </button>
                                                                </a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr class="spacer"></tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="tab-pane fade show" id="pills-f" role="tabpanel" aria-labelledby="custom-nav-home-tab">
                                    <div class="table-responsive table-responsive-data2">
                                        <table class="table table-data2">
                                            <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Username</th>
                                                    <th>Email</th>
                                                    <th>Role</th>
                                                    <th>Created At</th>
                                                    <th>Last Updated</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($sup as $p)
                                                    <tr class="tr-shadow">
                                                        <td>{{$p->name}}</td>
                                                        <td>{{$p->username}}</td>
                                                        <td>{{$p->email}}</td>
                                                        @if($p->role_id == 1)
                                                        <td>
                                                            Admin
                                                        </td>
                                                        @else
                                                        <td>
                                                            Supervisor
                                                        </td>
                                                        @endif
                                                        <?php 
                                                            $createdAt = Carbon\Carbon::parse($p->created_at)->format('M d Y');
                                                            $updatedAt = Carbon\Carbon::parse($p->updated_at)->format('M d Y');
                                                        ?>
                                                        <td>{{$createdAt}}</td>     
                                                        <td>{{$updatedAt}}</td>                                            
                                                        <td>
                                                            <div class="table-data-feature">
                                                                <a href="../admin/users/agents/{{$p->id}}" class="pr-4">
                                                                    <button class="item" title="Edit">
                                                                    <i class="zmdi zmdi-accounts"></i>
                                                                    </button>
                                                                     
                                                                </a>
                                                                <a href="../admin/users/edit/{{$p->id}}" class="pr-4"><button class="item" title="Edit">
                                                                    <i class="zmdi zmdi-edit"></i>
                                                                </button>
                                                                <a href="../admin/users/delete/{{$p->id}}"><button class="item" title="Delete">
                                                                    <i class="zmdi zmdi-delete"></i>
                                                                </button>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr class="spacer"></tr>
                                                @endforeach
                                            </tbody>

                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection