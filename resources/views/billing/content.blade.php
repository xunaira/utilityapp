@extends('admin.app')
@section('content')
<div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12 mb-5">
                        <h3 class="title-5 m-b-35 d-inline">Billings Dashboard</h3>
                        <a href="{{url('admin/billing/add')}}" target="_blank" class="float-right d-inline">
                            <button class="au-btn au-btn-icon au-btn--green au-btn--small float-right d-inline mr-3" data-toggle="tooltip" data-placement="top" data-original-title="Add Agent">
                                <i class="zmdi zmdi-plus"></i> Add New Bill
                            </button>
                        </a>
                    </div>
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h2 class="title">Billing Dashboard</h2>
                            </div>
                            <div class="card-body">
                                <div class="tab-content pl-3 pt-2" id="nav-tabContent">
                                    <div class="table-responsive table-responsive-data2">
                                        <table class="table table-data2">
                                            <thead>
                                                <tr>
                                                    <th>Customer Name</th>
                                                    <th>Email</th>
                                                    <th>Phone</th>
                                                    <th>Outstanding Bill</th>
                                                    <th>Current Charge</th>
                                                    <th>Status</th>
                                                    <th>Date</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($billing as $p)
                                                    <tr class="tr-shadow">
                                                        <td>
                                                            {{$p->name}}
                                                        </td>
                                                        <td>{{$p->email}}</td>
                                                        <td>{{$p->phone}}</td>                           
                                                        <td> &#8358; {{$p->outstanding}}</td>
                                                        <td>&#8358;{{$p->charge}}</td>
                                                        <td>{{$p->status}}</td>
                                                        <?php 
                                                            $date = Carbon\Carbon::parse($p->date);
                                                            $d = $date->format('M d Y')
                                                        ?>
                                                        <td class="desc">{{$d}}</td>                                          
                                                            <td>
                                                            <div class="table-data-feature">
                                                                <a href="../admin/billing/edit/{{$p->id}}" class="pr-4">
                                                                    <button class="item" data-toggle="tooltip" data-placement="top" title="Edit">
                                                                        <i class="zmdi zmdi-edit"></i>
                                                                    </button>
                                                                </a>
                                                                <a href="../admin/billing/delete/{{$p->id}}">
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
                                            <div class="float-right">
                                                {{$billing->links()}}
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
