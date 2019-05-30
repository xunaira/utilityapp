@extends('admin.app')

@section('content')
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                    <div class="col-md-12">
                        <!-- DATA TABLE -->
                        <h3 class="title-5 m-b-35">Agents Dashboard</h3>
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
                                <a href="{{url('admin/agents/add')}}">
                                    <button class="au-btn au-btn-icon au-btn--green au-btn--small">
                                        <i class="zmdi zmdi-plus"></i>Add Agent
                                    </button>
                                </a>
                                
                                <a href="{{url('admin/agent-sales/add')}}">
                                    <button class="au-btn au-btn-icon btn-info au-btn--small">
                                        <i class="zmdi zmdi-plus"></i>Add Agent Sales
                                    </button>
                                </a>
                               
                                <a href="{{url('admin/agents/add-balance')}}"><button class="au-btn au-btn-icon au-btn--blue au-btn--small">
                                    <i class="zmdi zmdi-plus"></i>Add Balance</button>
                                </a>
                                    
                            </div>
                        </div>
                        <div class="table-responsive table-responsive-data2">
                            <table class="table table-data2">
                                <thead>
                                    <tr>
                                        <th>Agent Name</th>
                                        <th>Agent Email</th>                                   
                                        <th>Operational Area</th>
                                        <th>Commission (%)</th>
                                        <th>Supervisor Name</th>
                                        <th>Created At</th>
                                        <th>Last Updated</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($agents as $p)
                                        <tr class="tr-shadow">
                                            <td style="vertical-align: middle !important;">{{$p->name}}</td>
                                            <td>{{$p->email}}</td>                             
                                            <td>{{$p->operational_area}}</td>
                                            <td>{{$p->commission}}</td>
                                            <td>{{$p->sup}}</td>
                                           
                                            <?php 
                                                $createdAt = Carbon\Carbon::parse($p->created_at)->format('M d Y');
                                            ?>
                                            <td>{{$createdAt}}</td>                                            
                                            <td>
                                                <div class="table-data-feature">
                                                    <a href="../admin/agents/detail/{{$p->id}}" class="pr-4">
                                                        <button class="item" title="Agent Detail">
                                                            <i class="fa fa-eye"></i>
                                                        </button>
                                                    </a>
                                                    <a href="../admin/agents/edit/{{$p->id}}" class="pr-4"><button class="item" title="Edit">
                                                        <i class="zmdi zmdi-edit"></i>
                                                    </button>
                                                    <a href="../admin/agents/delete/{{$p->id}}"><button class="item" title="Delete">
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