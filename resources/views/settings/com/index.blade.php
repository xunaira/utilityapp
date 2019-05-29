@extends('admin.app')

@section('content')
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 mx-auto d-block">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="d-inline">Commissions</h4>
                            <div class="float-right d-inline">
                                <a href="{{url('admin/settings/commission')}}">
                                    <button class="au-btn au-btn-icon au-btn--green au-btn--small">
                                        <i class="zmdi zmdi-plus"></i>Add Commission
                                    </button>
                                </a> 
                                 
                            </div>
                        </div>
                        <div class="card-body">
                            <ul class="nav nav-pills mb-3 w-100" id="pills-tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="pills-self-funded" data-toggle="pill" href="#pills-sf" role="tab" aria-controls="pills-home" aria-selected="true">Self Funded Agents</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-f" role="tab" aria-controls="pills-profile"
                                        aria-selected="false">Funded Agents</a>
                                </li>
                            </ul>
                            <div class="tab-content pl-3 pt-2" id="nav-tabContent">
                                <div class="tab-pane fade show active" id="pills-sf" role="tabpanel" aria-labelledby="custom-nav-home-tab">
                                    <div class="table-responsive table-responsive-data2">
                                        <table class="table table-data2">
                                            <thead>
                                                <tr>
                                                    <th>Commission (%)</th>
                                                    <th>Value</th>
                                                    <th>Created At</th>
                                                    <th>Last Updated</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($comm as $p)
                                                    <tr class="tr-shadow">
                                                        <td>{{$p->comm}}</td>
                                                        <td class="desc">{{$p->value}}</td>
                                                        <?php 
                                                            $createdAt = Carbon\Carbon::parse($p->created_at)->format('M d Y');
                                                            $updatedAt = Carbon\Carbon::parse($p->updated_at)->format('M d Y');
                                                        ?>
                                                        <td>{{$createdAt}}</td>     
                                                        <td>{{$updatedAt}}</td>                                            
                                                        <td>
                                                            <div class="table-data-feature">
                                                                <a href="../admin/settings/edit/{{$p->id}}" class="pr-4"><button class="item" title="Edit">
                                                                    <i class="zmdi zmdi-edit"></i>
                                                                </button>
                                                                <a href="../admin/settings/delete/{{$p->id}}"><button class="item" title="Delete">
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
                                <div class="tab-pane fade show" id="pills-f" role="tabpanel" aria-labelledby="custom-nav-home-tab">
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
                                    </div>
                                    <div class="table-responsive table-responsive-data2">
                                        <table class="table table-data2">
                                            <thead>
                                                <tr>
                                                    <th>Commission (%)</th>
                                                    <th>Value</th>
                                                    <th>Created At</th>
                                                    <th>Last Updated</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($funded as $p)
                                                    <tr class="tr-shadow">
                                                        <td>{{$p->comm}}</td>
                                                        <td class="desc">{{$p->value}}</td>
                                                        <?php 
                                                            $createdAt = Carbon\Carbon::parse($p->created_at)->format('M d Y');
                                                            $updatedAt = Carbon\Carbon::parse($p->updated_at)->format('M d Y');
                                                        ?>
                                                        <td>{{$createdAt}}</td>     
                                                        <td>{{$updatedAt}}</td>                                            
                                                        <td>
                                                            <div class="table-data-feature">
                                                                <a href="../admin/settings/edit/{{$p->id}}" class="pr-4"><button class="item" title="Edit">
                                                                    <i class="zmdi zmdi-edit"></i>
                                                                </button>
                                                                <a href="../admin/settings/delete/{{$p->id}}"><button class="item" title="Delete">
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