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
                    <a href="{{url('admin/agents/add')}}" target="_blank" class="float-right d-inline">
                        <button class="au-btn au-btn-icon au-btn--green au-btn--small float-right d-inline mr-3" data-toggle="tooltip" data-placement="top" data-original-title="Add Agent">
                            <i class="zmdi zmdi-accounts-add zmdi-hc-2x mt-2"></i>
                        </button>
                    </a>
                    <a href="{{url('/admin/users/add')}}" target="_blank" class="float-right d-inline">
                        <button class="au-btn au-btn-icon au-btn--blue au-btn--small float-right d-inline mr-3" data-toggle="tooltip" data-placement="top" data-original-title="Add Supervisor">
                            <i class="zmdi zmdi-account-add zmdi-hc-2x mt-2"></i>
                        </button>
                    </a>
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
                    <a href="{{url('admin/settings/system')}}" target="_blank" class="float-right d-inline"> 
                        <button class="au-btn au-btn-icon au-btn--purple au-btn--small float-right d-inline mr-3" data-toggle="tooltip" data-placement="top" data-original-title="Add System Balance">
                            <i class="zmdi zmdi-money zmdi-hc-2x mt-2"></i>
                        </button>
                    </a>
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
            </div>
        </div>
    </section>
        <!-- END STATISTIC-->
        <!-- STATISTIC CHART-->
    <section class="statistic-chart">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h3 class="title-5 m-b-35 d-inline">statistics</h3>
                    
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 col-lg-12">
               <!-- CHART-->
                    <div class="recent-report2">
                        <h3 class="title-3">recent reports</h3>
                        <div class="chart-info">
                            <div class="chart-info__left">
                                <div class="chart-note">
                                    <span class="dot dot--blue"></span>
                                    <span>products</span>
                                </div>
                                <div class="chart-note">
                                    <span class="dot dot--green"></span>
                                    <span>Services</span>
                                </div>
                            </div>
                            <div class="chart-info-right">
                                <div class="rs-select2--dark rs-select2--md m-r-10">
                                    <select class="js-select2" name="property">
                                        <option selected="selected">All Properties</option>
                                        <option value="">Products</option>
                                        <option value="">Services</option>
                                    </select>
                                    <div class="dropDownSelect2"></div>
                                </div>
                                <div class="rs-select2--dark rs-select2--sm">
                                    <select class="js-select2 au-select-dark" name="time">
                                        <option selected="selected">All Time</option>
                                        <option value="">By Month</option>
                                        <option value="">By Day</option>
                                    </select>
                                <div class="dropDownSelect2"></div>
                            </div>
                        </div>
                    </div>
                    <div class="recent-report__chart">
                        <canvas id="recent-rep2-chart"></canvas>
                    </div>
                </div>
                <!-- END CHART-->
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
                    <h3 class="title-5 m-b-35 d-inline">Agents Progress</h3>
                    <button class="au-btn au-btn-icon au-btn--green au-btn--small float-right d-inline mr-3 m-b-35">
                            <i class="zmdi zmdi-plus">Add Target</i>
                    </button>
                </div>
                <div class="col-md-6">
                    <!-- TASK PROGRESS-->
                    <div class="task-progress">
                        <h3 class="title-5 m-b-35">Agent Progress</h3>
                        <div class="au-skill-container">
                            <div class="au-progress">
                                <span class="au-progress__title">Web Design</span>
                                <div class="au-progress__bar">
                                    <div class="au-progress__inner js-progressbar-simple" role="progressbar" data-transitiongoal="90">
                                        <span class="au-progress__value js-value"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END TASK PROGRESS-->
                </div>
                <div class="col-md-6 col-lg-5 offset-lg-1 bg-blue">
                    <div class="au-card au-card--bg-blue au-card-top-countries m-b-30">
                        <h3 class="title-3 text-white mb-3 d-inline">Agent Sales</h3>
                    </button>
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
            </div>
        </div>
    </section>
    <!-- END DATA TABLE-->

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

@endsection