@extends('admin.app')
@section('content')
<div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <!-- DATA TABLE -->
                        <h3 class="title-5 m-b-35">Agent Sales Dashboard</h3>
                        <div class="table-data__tool">
                            <div class="table-data__tool-left">
                                <div class="rs-select2--light rs-select2--sm">
                                    <select class="js-select2" name="time">
                                        <option selected="selected">Today</option>
                                        <option value="">3 Days</option>
                                        <option value="">1 Week</option>
                                    </select>
                                    <div class="dropDownSelect2"></div>
                                </div>
                            </div>
                            <div class="table-data__tool-right">
                                <a href="{{url('admin/agent-sales/add')}}">
                                    <button class="au-btn au-btn-icon au-btn--green au-btn--small">
                                        <i class="zmdi zmdi-plus"></i>Add Sale
                                    </button>
                                </a>
                                <a href="{{url('admin/agents/add-balance')}}">
                                    <button class="au-btn au-btn-icon au-btn--blue au-btn--small">
                                        <i class="zmdi zmdi-plus"></i>Add Balance
                                    </button>
                                </a>
                                    
                            </div>
                        </div>
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
                                    @foreach($sales as $p)
                                    
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
                        <!-- END DATA TABLE -->
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
