@extends('admin.app')
@section('content')
<div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12 mb-5">
                        <h3 class="title-5 m-b-35 d-inline">Agent Sales Dashboard</h3>
                        <a href="{{url('admin/agent-sales/add')}}" target="_blank" class="float-right d-inline">
                            <button class="au-btn au-btn-icon au-btn--green au-btn--small float-right d-inline mr-3" data-toggle="tooltip" data-placement="top" data-original-title="Add Agent">
                                <i class="zmdi zmdi-plus"></i> Add Sales
                            </button>
                        </a>
                    </div>
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <ul class="nav nav-pills mb-3 w-100" id="pills-tab" role="tablist">
                                    @if(empty(Auth::user()->agent_id))
                                    <li class="nav-item">
                                        <a class="nav-link active" id="pills-self-funded" data-toggle="pill" href="#pills-all" role="tab" aria-controls="pills-home" aria-selected="true">All</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-ap" role="tab" aria-controls="pills-profile"
                                            aria-selected="false">Approved</a>
                                    </li>
                                    @else
                                    <li class="nav-item">
                                        <a class="nav-link active" id="pills-profile-tab" data-toggle="pill" href="#pills-ap" role="tab" aria-controls="pills-profile"
                                            aria-selected="false">Approved</a>
                                    </li>
                                    @endif
                                    <li class="nav-item">
                                        <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-pa" role="tab" aria-controls="pills-profile"
                                            aria-selected="false">Pending Approval</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-rj" role="tab" aria-controls="pills-profile"
                                            aria-selected="false">Rejected</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="card-body">
                                <div class="tab-content pl-3 pt-2" id="nav-tabContent">
                                    @if(empty(Auth::user()->agent_id))
                                    <div class="tab-pane fade show active" id="pills-all" role="tabpanel" aria-labelledby="custom-nav-home-tab">
                                        <div class="table-responsive table-responsive-data2">
                                            <table class="table table-data2">
                                                <thead>
                                                    <tr>
                                                        <th>Agent Name</th>
                                                        <th>Product Name</th>
                                                        <th>Sales Value</th>
                                                        <th>Date</th>
                                                        <th>Status</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($all as $p)
                                                    
                                                        <tr class="tr-shadow">
                                                            <td>
                                                                {{$p->name}}
                                                            </td>
                                                            <td>{{$p->product_name}}</td>
                                                            <td>&#8358; {{$p->sale_value}}</td>
                                                            <?php 
                                                                $date = Carbon\Carbon::parse($p->date);
                                                                $d = $date->format('M d Y')
                                                            ?>
                                                            <td class="desc">{{$d}}</td>
                                                            <td>{{$p->status}}</td>                                            
                                                            <td>
                                                                <div class="table-data-feature">
                                                                    @if(Auth::user()->role_id == 1 || Auth::user()->role_id == 2)
                                                                        <a href="#" class="pr-4">
                                                                            <button class="item" data-toggle="modal" data-target="#detailModal" data-id="{{$p->id}}">
                                                                                <i class="fa fa-eye"></i>
                                                                            </button>
                                                                        </a>
                                                                        @if($p->status == "Approved")
                                                                            <a href="#" class="pr-4">
                                                                                <button class="item" data-toggle="tooltip" data-placement="top" title="Approve" style="background-color: #28a745 !important">
                                                                                    <i class="fa fa-check" style="color: #fff;"></i>
                                                                                </button>
                                                                            </a>
                                                                        @else
                                                                             <a href="../admin/agent-sales/approve/{{$p->id}}" class="pr-4">
                                                                                <button class="item" data-toggle="tooltip" data-placement="top" title="Approve">
                                                                                    <i class="fa fa-check"></i>
                                                                                </button>
                                                                            </a>

                                                                        @endif
                                                                        @if($p->status == "Rejected")
                                                                            <a href="#" class="pr-4">
                                                                                <button class="item" data-toggle="tooltip" data-placement="top" title="Rejected" style="background-color: #b30000 !important">
                                                                                    <i class="fa fa-close" style="color: #fff;"></i>
                                                                                </button>
                                                                            </a>
                                                                        @else
                                                                             @if($p->status == "Approved")
                                                                                <a href="../admin/agent-sales/reject/{{$p->id}}" class="pr-4 d-none">
                                                                                    <button class="item d-none" data-toggle="tooltip" data-placement="top" title="Reject">
                                                                                        <i class="fa fa-close"></i>
                                                                                    </button>
                                                                                </a>
                                                                            @else
                                                                                <a href="../admin/agent-sales/reject/{{$p->id}}" class="pr-4">
                                                                                    <button class="item" data-toggle="tooltip" data-placement="top" title="Reject">
                                                                                        <i class="fa fa-close"></i>
                                                                                    </button>
                                                                                </a>

                                                                            @endif


                                                                        @endif
                                                                    @endif
                                                                    <a href="../admin/agent-sales/edit/{{$p->id}}" class="pr-4"><button class="item" data-toggle="tooltip" data-placement="top" title="Edit">
                                                                        <i class="zmdi zmdi-edit"></i>
                                                                        </button>
                                                                    </a>
                                                                    <a href="../admin/agent-sales/delete/{{$p->id}}">
                                                                        <button class="item" data-toggle="tooltip" data-placement="top" title="Delete">
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
                                    <div class="tab-pane fade show" id="pills-ap" role="tabpanel" aria-labelledby="custom-nav-home-tab">
                                        <div class="table-responsive table-responsive-data2">
                                            <table class="table table-data2">
                                                <thead>
                                                    <tr>
                                                        <th>Agent Name</th>
                                                        <th>Product Name</th>
                                                        <th>Sales Value</th>
                                                        <th>Date</th>
                                                        <th>Status</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($approved as $p)
                                                    
                                                        <tr class="tr-shadow">
                                                            <td>
                                                                {{$p->name}}
                                                            </td>
                                                            <td>{{$p->product_name}}</td>
                                                            <td>&#8358; {{$p->sale_value}}</td>
                                                            <?php 
                                                                $date = Carbon\Carbon::parse($p->date);
                                                                $d = $date->format('M d Y')
                                                            ?>
                                                            <td class="desc">{{$d}}</td>
                                                            <td>{{$p->status}}</td>                                            
                                                            <td>
                                                                <div class="table-data-feature">
                                                                    @if(Auth::user()->role_id == 1 || Auth::user()->role_id == 2)
                                                                        <a href="#" class="pr-4">
                                                                            <button class="item" data-toggle="modal" data-target="#detailModal" data-id="{{$p->id}}">
                                                                                <i class="fa fa-eye"></i>
                                                                            </button>
                                                                        </a>
                                                                        @if($p->status == "Approved")
                                                                            <a href="#" class="pr-4">
                                                                                <button class="item" data-toggle="tooltip" data-placement="top" title="Approve" style="background-color: #28a745 !important">
                                                                                    <i class="fa fa-check" style="color: #fff;"></i>
                                                                                </button>
                                                                            </a>
                                                                        @else
                                                                             <a href="../admin/agent-sales/approve/{{$p->id}}" class="pr-4">
                                                                                <button class="item" data-toggle="tooltip" data-placement="top" title="Approve">
                                                                                    <i class="fa fa-check"></i>
                                                                                </button>
                                                                            </a>

                                                                        @endif 

                                                                    @endif
                                                                    <a href="../admin/agent-sales/edit/{{$p->id}}" class="pr-4"><button class="item" data-toggle="tooltip" data-placement="top" title="Edit">
                                                                        <i class="zmdi zmdi-edit"></i>
                                                                        </button>
                                                                    </a>
                                                                    
                                                                    <a href="../admin/agent-sales/delete/{{$p->id}}">
                                                                        <button class="item" data-toggle="tooltip" data-placement="top" title="Delete">
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
                                    @else
                                    <div class="tab-pane fade show active" id="pills-ap" role="tabpanel" aria-labelledby="custom-nav-home-tab">
                                        <div class="table-responsive table-responsive-data2">
                                            <table class="table table-data2">
                                                <thead>
                                                    <tr>
                                                        <th>Agent Name</th>
                                                        <th>Product Name</th>
                                                        <th>Sales Value</th>
                                                        <th>Date</th>
                                                        <th>Status</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($approved as $p)
                                                    
                                                        <tr class="tr-shadow">
                                                            <td>
                                                                {{$p->name}}
                                                            </td>
                                                            <td>{{$p->product_name}}</td>
                                                            <td>&#8358; {{$p->sale_value}}</td>
                                                            <?php 
                                                                $date = Carbon\Carbon::parse($p->date);
                                                                $d = $date->format('M d Y')
                                                            ?>
                                                            <td class="desc">{{$d}}</td>
                                                            <td>{{$p->status}}</td>                                            
                                                            <td>
                                                                <div class="table-data-feature">
                                                                    @if(Auth::user()->role_id == 1 || Auth::user()->role_id == 2)
                                                                        <a href="#" class="pr-4">
                                                                            <button class="item" data-toggle="modal" data-target="#detailModal" data-id="{{$p->id}}">
                                                                                <i class="fa fa-eye"></i>
                                                                            </button>
                                                                        </a>
                                                                        @if($p->status == "Approved")
                                                                            <a href="#" class="pr-4">
                                                                                <button class="item" data-toggle="tooltip" data-placement="top" title="Approve" style="background-color: #28a745 !important">
                                                                                    <i class="fa fa-check" style="color: #fff;"></i>
                                                                                </button>
                                                                            </a>
                                                                        @else
                                                                             <a href="../admin/agent-sales/approve/{{$p->id}}" class="pr-4">
                                                                                <button class="item" data-toggle="tooltip" data-placement="top" title="Approve">
                                                                                    <i class="fa fa-check"></i>
                                                                                </button>
                                                                            </a>

                                                                        @endif
                                                
                                                                    @endif
                                                                    @if($p->status == "Approved")
                                                                    <a href="../admin/agent-sales/edit/{{$p->id}}" class="pr-4 d-none"><button class="item" data-toggle="tooltip" data-placement="top" title="Edit">
                                                                        <i class="zmdi zmdi-edit"></i>
                                                                        </button>
                                                                    </a>                                                           
                                                                    <a href="../admin/agent-sales/delete/{{$p->id}}">
                                                                        <button class="item d-none" data-toggle="tooltip" data-placement="top" title="Delete">
                                                                        <i class="zmdi zmdi-delete"></i>
                                                                        </button>
                                                                    </a>
                                                                    @endif
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr class="spacer"></tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>                                        
                                    </div>
                                    @endif
                                    <div class="tab-pane fade show" id="pills-pa" role="tabpanel" aria-labelledby="custom-nav-home-tab">
                                        <div class="table-responsive table-responsive-data2">
                                            <table class="table table-data2">
                                                <thead>
                                                    <tr>
                                                        <th>Agent Name</th>
                                                        <th>Product Name</th>
                                                        <th>Sales Value</th>
                                                        <th>Date</th>
                                                        <th>Status</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($pending as $p)
                                                    
                                                        <tr class="tr-shadow">
                                                            <td>
                                                                {{$p->name}}
                                                            </td>
                                                            <td>{{$p->product_name}}</td>
                                                            <td>&#8358; {{$p->sale_value}}</td>
                                                            <?php 
                                                                $date = Carbon\Carbon::parse($p->date);
                                                                $d = $date->format('M d Y')
                                                            ?>
                                                            <td class="desc">{{$d}}</td>
                                                            <td>{{$p->status}}</td>                                            
                                                            <td>
                                                                <div class="table-data-feature">
                                                                    @if(Auth::user()->role_id == 1 || Auth::user()->role_id == 2)
                                                                        <a href="#" class="pr-4">
                                                                            <button class="item" data-toggle="modal" data-target="#detailModal" data-id="{{$p->id}}">
                                                                                <i class="fa fa-eye"></i>
                                                                            </button>
                                                                        </a>
                                                                        @if($p->status == "Approved")
                                                                            <a href="#" class="pr-4">
                                                                                <button class="item" data-toggle="tooltip" data-placement="top" title="Approve" style="background-color: #28a745 !important">
                                                                                    <i class="fa fa-check" style="color: #fff;"></i>
                                                                                </button>
                                                                            </a>
                                                                        @else
                                                                             <a href="../admin/agent-sales/approve/{{$p->id}}" class="pr-4">
                                                                                <button class="item" data-toggle="tooltip" data-placement="top" title="Approve">
                                                                                    <i class="fa fa-check"></i>
                                                                                </button>
                                                                            </a>

                                                                        @endif
                                                                        @if($p->status == "Rejected")
                                                                            <a href="#" class="pr-4">
                                                                                <button class="item" data-toggle="tooltip" data-placement="top" title="Rejected" style="background-color: #b30000 !important">
                                                                                    <i class="fa fa-close" style="color: #fff;"></i>
                                                                                </button>
                                                                            </a>
                                                                        @else
                                                                            @if($p->status == "Approved")
                                                                                <a href="../admin/agent-sales/reject/{{$p->id}}" class="pr-4 d-none">
                                                                                    <button class="item d-none" data-toggle="tooltip" data-placement="top" title="Reject">
                                                                                        <i class="fa fa-close"></i>
                                                                                    </button>
                                                                                </a>
                                                                            @else
                                                                                <a href="../admin/agent-sales/reject/{{$p->id}}" class="pr-4">
                                                                                    <button class="item" data-toggle="tooltip" data-placement="top" title="Reject">
                                                                                        <i class="fa fa-close"></i>
                                                                                    </button>
                                                                                </a>

                                                                            @endif

                                                                        @endif
                                                                    @endif
                                                                    <a href="../admin/agent-sales/edit/{{$p->id}}" class="pr-4"><button class="item" data-toggle="tooltip" data-placement="top" title="Edit">
                                                                        <i class="zmdi zmdi-edit"></i>
                                                                        </button>
                                                                    </a>
                                                                    <a href="../admin/agent-sales/delete/{{$p->id}}">
                                                                        <button class="item" data-toggle="tooltip" data-placement="top" title="Delete">
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
                                    <div class="tab-pane fade show" id="pills-rj" role="tabpanel" aria-labelledby="custom-nav-home-tab">
                                        <div class="table-responsive table-responsive-data2">
                                            <table class="table table-data2">
                                                <thead>
                                                    <tr>
                                                        <th>Agent Name</th>
                                                        <th>Product Name</th>
                                                        <th>Sales Value</th>
                                                        <th>Date</th>
                                                        <th>Status</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($rejected as $p)
                                                    
                                                        <tr class="tr-shadow">
                                                            <td>
                                                                {{$p->name}}
                                                            </td>
                                                            <td>{{$p->product_name}}</td>
                                                            <td>&#8358; {{$p->sale_value}}</td>
                                                            <?php 
                                                                $date = Carbon\Carbon::parse($p->date);
                                                                $d = $date->format('M d Y')
                                                            ?>
                                                            <td class="desc">{{$d}}</td>
                                                            <td>{{$p->status}}</td>                                            
                                                            <td>
                                                                <div class="table-data-feature">
                                                                    @if(Auth::user()->role_id == 1 || Auth::user()->role_id == 2)
                                                                        <a href="#" class="pr-4">
                                                                            <button class="item" data-toggle="modal" data-target="#detailModal" data-id="{{$p->id}}">
                                                                                <i class="fa fa-eye"></i>
                                                                            </button>
                                                                        </a>
                                                                        @if($p->status == "Rejected")
                                                                            <a href="#" class="pr-4">
                                                                                <button class="item" data-toggle="tooltip" data-placement="top" title="Rejected" style="background-color: #b30000 !important">
                                                                                    <i class="fa fa-close" style="color: #fff;"></i>
                                                                                </button>
                                                                            </a>
                                                                        @else
                                                                             <a href="../admin/agent-sales/reject/{{$p->id}}" class="pr-4">
                                                                                <button class="item" data-toggle="tooltip" data-placement="top" title="Reject">
                                                                                    <i class="fa fa-close"></i>
                                                                                </button>
                                                                            </a>

                                                                        @endif
                                                                    @endif
                                                                    <a href="../admin/agent-sales/edit/{{$p->id}}" class="pr-4"><button class="item" data-toggle="tooltip" data-placement="top" title="Edit">
                                                                        <i class="zmdi zmdi-edit"></i>
                                                                        </button>
                                                                    </a>
                                                                    <a href="../admin/agent-sales/delete/{{$p->id}}">
                                                                        <button class="item" data-toggle="tooltip" data-placement="top" title="Delete">
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
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="mediumModalLabel">Agent Sales Detail</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary">Confirm</button>
            </div>
        </div>
    </div>
</div>
@endsection
