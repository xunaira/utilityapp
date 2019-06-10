@extends('admin.app')

@section('content')
<div class="page-content--bgf7">
    <!-- WELCOME-->
    <section class="welcome p-t-10" style="margin-top: 5rem !important;">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="title-4 d-inline">Welcome back
                        <span style="text-transform: capitalize;">{{Auth::user()->name}}!</span>
                    </h1>
                    @if(Auth::user()->role_id == 1 || Auth::user()->role_id == 2)
                    <a href="{{url('admin/agents/add')}}" target="_blank" class="float-right d-inline">
                        <button class="au-btn au-btn-icon au-btn--green au-btn--small float-right d-inline mr-3" data-toggle="tooltip" data-placement="top" data-original-title="Add Agent">
                            <i class="zmdi zmdi-accounts-add zmdi-hc-2x mt-2"></i>
                        </button>
                    </a>
                    @endif
                    @if(Auth::user()->role_id == 1)
                    <a href="{{url('/admin/users/add')}}" target="_blank" class="float-right d-inline">
                        <button class="au-btn au-btn-icon au-btn--blue au-btn--small float-right d-inline mr-3" data-toggle="tooltip" data-placement="top" data-original-title="Add Supervisor">
                            <i class="zmdi zmdi-account-add zmdi-hc-2x mt-2"></i>
                        </button>
                    </a>


                    @endif
                    <a href="{{url('admin/agent-sales/add')}}" target="_blank" class="float-right d-inline">
                        <button class="au-btn au-btn-icon au-btn--blue2 au-btn--small float-right d-inline mr-3" data-toggle="tooltip" data-placement="top" data-original-title="Add Sale">
                            <i class="zmdi zmdi-shopping-cart zmdi-hc-2x mt-2"></i>
                        </button>
                    </a>
                    <a href="{{url('admin/agents/add-balance')}}" target="_blank" class="float-right d-inline">
                        <button class="au-btn au-btn-icon au-btn--red au-btn--small float-right d-inline mr-3" data-toggle="tooltip" data-placement="top" data-original-title="Add Agent Wallet">
                            <i class="zmdi zmdi-balance-wallet zmdi-hc-2x mt-2"></i>
                        </button>
                    </a>
                    @if(Auth::user()->role_id == 1 || Auth::user()->role_id == 2)
                    <a href="{{url('admin/settings/system')}}" target="_blank" class="float-right d-inline"> 
                        <button class="au-btn au-btn-icon au-btn--purple au-btn--small float-right d-inline mr-3" data-toggle="tooltip" data-placement="top" data-original-title="Add System Balance">
                            <i class="zmdi zmdi-money zmdi-hc-2x mt-2"></i>
                        </button>
                    </a>
                    @endif
                    <hr class="line-seprate">
                </div>
            </div>
        </div>
    </section>
    <!-- END WELCOME-->
    <!-- STATISTIC-->
    <section class="statistic statistic2">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-lg-3">
                    <div class="statistic__item statistic__item--green">
                        @if($tday == 0)
                            <h2 class="number">&#8358; 0</h2>
                        @else
                            <h2 class="number">&#8358; {{$tday}}</h2>
                        @endif
                        <span class="desc">today's sales</span>
                        <div class="icon">
                            <i class="zmdi zmdi-money"></i>
                        </div>
                    </div>
                </div>               
                <div class="col-md-6 col-lg-3">
                    <div class="statistic__item statistic__item--orange">
                        @if($mo == 0)
                            <h2 class="number">&#8358; 0</h2>
                        @else
                            <h2 class="number">&#8358; {{$mo}}</h2>
                        @endif
                        <span class="desc">monthly sales</span>
                        <div class="icon">
                            <i class="zmdi zmdi-shopping-cart"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                        <div class="statistic__item statistic__item--red">
                            @if($earnings == 0)
                                <h2 class="number">&#8358; 0</h2>
                            @else
                                <h2 class="number">&#8358; {{$earnings}}</h2>
                            @endif
                            <span class="desc">total earnings</span>
                            <div class="icon">
                                <i class="zmdi zmdi-money"></i>
                            </div>
                        </div>
                </div>
                @if(Auth::user()->role_id == 1 || Auth::user()->role_id == 2)
                    <div class="col-md-6 col-lg-3">
                        <div class="statistic__item statistic__item--blue">
                            @if($agents == 0)
                                <h2 class="number">0</h2>
                            @else
                                <h2 class="number">{{$agents}}</h2>
                            @endif
                            <span class="desc">Agents</span>
                            <div class="icon">
                                <i class="zmdi zmdi-account-o"></i>
                            </div>
                        </div>
                    </div>
                @elseif(Auth::user()->role_id == 3)
                    <div class="col-md-6 col-lg-3">
                        <div class="statistic__item statistic__item--blue">
                                <h2 class="number">0</h2>
                            <span class="desc">Sales</span>
                            <div class="icon">
                                <i class="zmdi zmdi-account-o"></i>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>
    <!-- END STATISTIC-->
    <section>
        <div class="container">
            <div class="row">
                @if(Auth::user()->role_id == 3)
                    <div class="col-md-6">
                        <!-- TASK PROGRESS-->
                        <div class="task-progress">
                            <div class="au-skill-container">
                                <div class="au-progress">  
                                    <?php 
                                        if(!$agent_target->target == 0){
                                            $total = $agent_target->target->target;
                                            $s = $sum;
                                            $p = ($s / $total) * 100;
                                        }else{
                                            $p = 0;
                                        }
                                        
                                    ?>               
                                    <span class="au-progress__title">Target Progress</span>
                                    <div class="progress mb-3" style="height: 15px;">
                                        <div class="progress-bar bg-success progress-bar-striped progress-bar-animated" role="progressbar" style="width: {{$p}}%" aria-valuenow="{{$p}}" aria-valuemin="0" aria-valuemax="100">{{$p}}%</div>
                                    </div>
                                </div>
                            </div>
                        <!-- END TASK PROGRESS-->
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="au-card au-card--bg-blue au-card-top-countries m-b-30">
                            <h2 class="title-3 text-white">Today's Sales</h2>
                            <div class="au-card-inner">
                                <div class="table-responsive">
                                    <table class="table table-top-countries">
                                        <tbody>
                                            @foreach($get_sales as $g)
                                            <tr>
                                                <td>{{$g->product_name}}</td>
                                                <td class="text-right">&#8358; {{$g->sale_value}}</td>
                                               
                                            </tr>
                                             @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div> 
    </section>
    <!-- STATISTIC CHART-->
   <section class="statistic-chart">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h3 class="title-5 m-b-35">statistics</h3>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 col-lg-8">
                    <div class="recent-report2">
                        <h3 class="title-3">monthly sales report</h3>
                        <div class="recent-report__chart">
                            <canvas id="recent-rep2-chart"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="chart-percent-2">
                        <h3 class="title-3 m-b-30">Yearly Sales Percentage</h3>
                        <div class="chart-wrap">
                            <canvas id="percent-chart2"></canvas>
                            <div id="chartjs-tooltip">
                                <table></table>
                            </div>
                            
                        </div>    
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- END STATISTIC CHART-->
    <!-- DATA TABLE-->
    <section class="p-t-20">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    @if(Auth::user()->role_id == 1 || Auth::user()->role_id == 2)
                    <h3 class="title-5 m-b-35 d-inline">Agents Progress</h3>
                        <button class="au-btn au-btn-icon au-btn--green au-btn--small float-right d-inline mr-3 m-b-35" data-toggle="modal" data-target="#mediumModal">
                                <i class="zmdi zmdi-plus">Add Target</i>
                        </button>
                    @endif
                </div>
                @if(Auth::user()->role_id == 1)
                <div class="col-md-6">
                    <!-- TASK PROGRESS-->
                    <div class="task-progress">
                        <h3 class="title-5 m-b-35">Agent Progress</h3>
                        <div class="au-skill-container">
                            @foreach($target as $t)
                                <div class="au-progress">                                
                                    <span class="au-progress__title">{{$t->name}}</span>
                                    <div style="height: 5px;">
                                            <?php 
                                                $sale = 0;
                                                if(!empty($t->sales)){
                                                    foreach($t->sales as $s){
                                                        $sale += $s->sale_value; 
                                                    }
                                                }
                                                if(!empty($t->target)){
                                                $target = $t->target->target;                        
                                            }else{
                                                $target = 0;
                                            }    
                                            if($target != 0){
                                                $percent = ($sale / $target) * 100;
                                            }else{
                                                $percent = 0;                                        
                                            }


                                             ?>
                                            <div class="progress mb-3" style="height: 15px;">
                                                <div class="progress-bar bg-success progress-bar-striped progress-bar-animated" role="progressbar" style="width: {{$percent}}%" aria-valuenow="{{$percent}}" aria-valuemin="0" aria-valuemax="{{$t->target}}">{{$percent}}%</div>
                                            </div>
                                    </div>
                                </div>

                            @endforeach
                        </div>
                        
                    <!-- END TASK PROGRESS-->
                    </div>
                </div>
                @elseif(Auth::user()->role_id == 2)
                <div class="col-md-6">
                    <!-- TASK PROGRESS-->
                    <div class="task-progress">
                        <h3 class="title-5 m-b-35">Agent Progress</h3>
                        <div class="au-skill-container">
                            @foreach($target as $t)

                                <div class="au-progress">                                
                                    <span class="au-progress__title">{{$t->name}}</span>
                                    <div style="height: 5px;">
                                            <?php 
                                                $sale = 0;

                                                if(!empty($t->sales)){
                                                    
                                                    foreach($t->sales as $s){
                                                        $sale += $s->sale_value; 
                                                    }
                                                }

                                                dd($sale);
                                                if(!empty($t->target)){
                                                    $target = $t->target;                        
                                                }else{
                                                    $target = 0;
                                                }    
                                                if($target != 0){
                                                    $percent = ($sale / $target) * 100;

                                                }else{
                                                    $percent = 0;                                        
                                                }

                                                dd($percent);


                                             ?>
                                            <div class="progress mb-3" style="height: 15px;">
                                                <div class="progress-bar bg-success progress-bar-striped progress-bar-animated" role="progressbar" style="width: {{$percent}}%" aria-valuenow="{{$percent}}" aria-valuemin="0" aria-valuemax="{{$t->target}}">{{$percent}}%</div>
                                            </div>
                                    </div>
                                </div>

                            @endforeach
                        </div>
                        
                    <!-- END TASK PROGRESS-->
                    </div>
                </div>
                @endif
                @if(Auth::user()->role_id == 1 || Auth::user()->role_id == 2)
                <div class="col-md-6 col-lg-5 offset-lg-1 bg-blue">
                    <div class="au-card au-card--bg-blue au-card-top-countries m-b-30">
                        <h3 class="title-3 text-white mb-3 d-inline">Agent Sales</h3>
                        <div class="au-card-inner">
                            <div class="table-responsive">
                                <table class="table table-top-countries">
                                    <tbody>
                                        @foreach($sales as $s)
                                        <tr>
                                            <td>{{$s->name}}</td>
                                            <td class="text-right">&#8358; {{$s->sales}}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                @else

                @endif
            </div>
        </div>
    </section>
    <!-- END DATA TABLE-->
    @if(Auth::user()->role_id == 1)
        <section>
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h3 class="title-5 m-b-35">Commissions</h3>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="au-card au-card--bg-blue au-card-top-countries m-b-30">
                            <h2 class="title-3 text-white">Self funded commission</h2>
                            <div class="au-card-inner">
                                <div class="table-responsive">
                                    <table class="table table-top-countries">
                                        <tbody>
                                            @foreach($comm as $g)
                                            <tr>                                                
                                                <td>{{$g->comm}}</td>
                                                <td class="text-right">&#8358; {{$g->value}}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="au-card au-card--bg-green au-card-top-countries m-b-30">
                            <h2 class="title-3 text-white">Funded Commission</h2>
                            <div class="au-card-inner">
                                <div class="table-responsive">
                                    <table class="table table-top-countries">
                                        <tbody>
                                            @foreach($funded as $g)
                                            <tr>
                                                <td>{{$g->comm}}</td>
                                                <td class="text-right">&#8358; {{$g->value}}</td>                              
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

    <!-- COPYRIGHT-->
    <section class="p-t-60 p-b-20">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="copyright">
                        <p>Copyright © <?php echo Carbon\Carbon::now()->year ?> IQI Power App. All rights reserved.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- END COPYRIGHT-->
</div>
<!-- modal -->
@include('dashboard.target')
@endsection