@extends('admin.app')

@section('content')
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                    <div class="col-md-12">
                        <!-- DATA TABLE -->
                        <h3 class="title-5 m-b-35">Sales Reports</h3>
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
                                <a href="{{url('admin/reports/sales-export')}}" class="d-inline float-right">  
                                    <button class="au-btn au-btn-icon au-btn--blue au-btn--small">
                                      Download Excel
                                    </button>                  
                                                       
                                  </a>
                            </div>
                        </div>
                        <div class="table-responsive table--no-card m-b-30">
                            <table class="table table-borderless table-striped table-earning">
                                <thead>
                                    <tr>
                                        <th>Agent Name</th>
                                        <th>Product Name</th>
                                        <th>Wallet</th>
                                        <th>Sale Value</th>
                                        <th>Remaining Balance</th>
                                        <th>Date</th>                                                                            
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($transactions as $a)
                                            <tr>
                                                <td>{{$a->name}}</td>
                                                <td>{{$a->product_name}}</td>
                                                <td>&#8358; {{$a->total_funds}}</td>
                                                <td>&#8358; {{$a->sale_value}}</td>
                                                <td>&#8358; {{$a->closing_balance}}</td>
                                                <?php 
                                                    $date = Carbon\Carbon::parse($a->date)->format('M d Y');
                                                  ?> 
                                                <td>{{$date}}</td>                                                                                                
                                            </tr>
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