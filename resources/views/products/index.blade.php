@extends('admin.app')
@section('content')
<div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <!-- DATA TABLE -->
                        <h3 class="title-5 m-b-35">Products Dashboard</h3>
                        <div class="table-data__tool">
                            <div class="table-data__tool-left">
                            </div>
                            <div class="table-data__tool-right">
                                <a href="{{url('admin/products/create')}}"><button class="au-btn au-btn-icon au-btn--green au-btn--small">
                                    <i class="zmdi zmdi-plus"></i>Add Product</button></a>
                                    
                            </div>
                        </div>
                        <div class="table-responsive table-responsive-data2">
                            <table class="table table-data2">
                                <thead>
                                    <tr>
                                        <th>Product Name</th>
                                        <th>Merchant Name</th>
                                        <th>Commission - Dealer (%)</th>
                                        <th>Commission - Funded Agent (%)</th>
                                        <th>Commission - Self Funded Agent (%)</th>
                                        <th>Created On</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($product as $p)
                                        <tr class="tr-shadow">
                                            <td>{{$p->product_name}}</td>
                                            <td>{{$p->company_name}}</td>
                                            <td>
                                                {{$p->comm_self}}
                                            </td>
                                            <td class="desc">{{$p->comm_funded}}</td>
                                            <td class="desc">{{$p->comm_self_funded}}</td>
                                            <?php 
                                                $createdAt = Carbon\Carbon::parse($p->created_at)->format('M d Y');
                                            ?>
                                            <td>{{$createdAt}}</td>                                            
                                            <td>
                                                <div class="table-data-feature">
                                                    <a href="../admin/products/edit/{{$p->id}}" class="pr-4"><button class="item" data-toggle="tooltip" data-placement="top" title="Edit">
                                                        <i class="zmdi zmdi-edit"></i>
                                                    </button>
                                                    <a href="../admin/products/delete/{{$p->id}}"><button class="item" data-toggle="tooltip" data-placement="top" title="Delete">
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
                        <!-- END DATA TABLE -->
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
