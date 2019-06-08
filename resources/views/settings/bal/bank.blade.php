@extends('admin.app')

@section('content')
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 mx-auto d-block">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="d-inline">System Balance</h4>
                            <div class="float-right d-inline">
                                @if($bal < 1)
                                <a href="{{url('admin/settings/system')}}">
                                    <button class="au-btn au-btn-icon au-btn--green au-btn--small">
                                        <i class="zmdi zmdi-plus"></i>Add System Balance
                                    </button>
                                </a> 
                                @endif                                 
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive table-responsive-data2">
                                <table class="table table-data2">
                                    <thead>
                                        <tr>
                                            <th>Cash in Hand (&#8358;)</th>
                                            <th>Cash in Bank (&#8358;)</th>
                                            <th>Total Cash (&#8358;)</th>
                                            <th>Created At</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($balance as $b)
                                            <tr class="tr-shadow">
                                                <td>&#8358; {{$b->cash_bank}}</td>
                                                <td>&#8358; {{$b->cash_hand}}</td>
                                                <?php 
                                                    $createdAt = Carbon\Carbon::parse($b->created_at)->format('M d Y');
                                                ?>
                                                <td class="desc">
                                                    <?php $total = $b->cash_bank + $b->cash_hand; ?>
                                                    &#8358; {{$total}}
                                                </td>
                                                <td>{{$createdAt}}</td>                                               
                                                <td>
                                                    <div class="table-data-feature">
                                                        <a href="../../admin/settings/edit_balance/{{$b->id}}" class="pr-4">
                                                            <button class="item" title="Edit">
                                                                <i class="zmdi zmdi-edit"></i>
                                                            </button>
                                                        </a>
                                                        <a href="../../admin/settings/delete_balance/{{$b->id}}">
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
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection