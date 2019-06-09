@extends('admin.app')

@section('content')
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
              <div class="col-12">
                <div class="float-right mb-3">
                  <a href="{{url('admin/agent-sales/add')}}">
                    <button class="au-btn au-btn-icon btn-info au-btn--small">
                      <i class="zmdi zmdi-plus"></i>Add Agent Sales
                    </button>
                  </a>
                  <a href="{{url('admin/agents/add-balance')}}">
                    <button class="au-btn au-btn-icon au-btn--blue au-btn--small">
                      <i class="zmdi zmdi-plus"></i>Add Balance
                    </button>
                  </a>
                </div>
              </div>
            	<div class="col-md-8 mx-auto d-block">
            		<div class="card">
            			@foreach($agents as $a)
            			     <div class="card-header user-header alt bg-dark">
                            <div class="media">                            
                                <div class="media-body d-inline">
                                    <h2 class="text-light display-6 mb-2">{{$a->name}}</h2>
                                    <p class="text-light text-capitalize">{{$a->agent_type}}</p>                                
                                </div>
                                <div class="float-right d-inline">
                                  @if(!empty($w))
                                    	<span class="badge badge-primary pr-3 pl-3 pt-2 pb-2 mr-4">Wallet: &#8358; {{$w}}</span>
                                  @else

                                      <span class="badge badge-primary pr-3 pl-3 pt-2 pb-2 mr-4">Wallet: &#8358; 0</span>
                                  @endif
                                  <a href="../../../{{$detailurl}}" class="d-inline float-right">                    
                                    <i class="zmdi zmdi-download text-light zmdi-hc-2x"></i>                    
                                  </a>
                                    </div>
                            </div>
                        </div>                        
                        <div class="card-body">                            
                           <div class="row">
                           	<div class="col-6">
                           		<div id="email" class="mb-2">
                           			<label class="form-control-label">Email:</label>
                           			<a href="mailto:{{$a->email}}">{{$a->email}}</a>
                           		</div>
                           		<div id="address1" class="mb-2">
                           			<label class="form-control-label">Address Line 1:</label>
                           			<h5 class="d-inline form-control-label">{{$a->address1}}</h5>
                           		</div>
                           		<div id="address1" class="mb-2">
                           			<label class="form-control-label">State:</label>
                           			<h5 class="d-inline form-control-label">{{$a->state}}</h5>
                           		</div>
                           		<div id="country" class="mb-2">
                           			<label class="form-control-label">Country:</label>
                           			<h5 class="d-inline form-control-label">{{$a->country}}</h5>
                           		</div>
                           		<div id="commission" class="mb-2">
                           			<label class="form-control-label">Commission (%):</label>
                           			<h5 class="d-inline form-control-label">{{$a->commission}}</h5>
                           		</div>
                           		<div id="supervisor">
                           			<label class="form-control-label">Supervisor:</label>
                           			<h5 class="d-inline form-control-label">{{$a->sup}}</h5>
                           		</div>       

                           	</div>
                           	<div class="col-6">
                           		<div id="phone" class="mb-2">
                           			<label class="form-control-label">Phone:</label>
                           			<h5 class="d-inline form-control-label">{{$a->phone_no}}</h5>
                           		</div>
                           		<div id="address2" class="mb-2">
                           			<label class="form-control-label">Address Line 2:</label>
                           			<h5 class="d-inline form-control-label">{{$a->address2}}</h5>
                           		</div>
                           		<div id="city" class="mb-2">
                           			<label class="form-control-label">City:</label>
                           			<h5 class="d-inline form-control-label">{{$a->city}}</h5>
                           		</div>
                           		<div id="area" class="mb-2">
                           			<label class="form-control-label">Operational Area:</label>
                           			<h5 class="d-inline form-control-label">{{$a->operational_area}}</h5>
                           		</div>
                           		<div id="salary" class="mb-2">
                           			<label class="form-control-label">Salary:</label>
                           			<h5 class="d-inline form-control-label">{{$a->salary}}</h5>
                           		</div>
                              <div id="kyc" class="mb-2">
                                <?php $url = $a->kyc; ?>
                                    <a href="{{Storage::url($url)}}" class="btn-info pl-3 pr-3" target="_blank">View KYC</a>
                              </div>
                           	</div>
                           </div>
                        </div>
                        @endforeach
                    </div>
                  <div class="card">
                    <div class="card-header user-header alt bg-warning">
                        <h2 class="text-light display-6 mb-2 d-inline">Agent Targets</h2>
                    </div>
                    <div class="card-body">
                      <table class="table table-top-countries">
                          <thead>
                            <th>
                              Target Value (&#8358;)
                            </th>
                            <th>
                              Date
                            </th>
                          </thead>
                          <tbody>
                            @foreach($target as $t)
                            <tr>
                              <td class="text-dark">&#8358; {{$t->target}}</td>
                              <?php 
                                  $createdAt = Carbon\Carbon::parse($t->date)->format('M d Y');
                                ?>
                              <td class="text-dark">{{$createdAt}}</td>
                            </tr>
                            @endforeach
                          </tbody>
                      </table>
                    </div>
                  </div>
                  <div class="card">
                    <div class="card-header user-header alt bg-success">
                        <h2 class="text-light display-6 mb-2 d-inline">Bank Balance</h2>
                        <a href="../../../{{$bankurl}}" class="d-inline float-right">                    
                                      <i class="zmdi zmdi-download text-light zmdi-hc-2x"></i>                    
                                    </a>
                    </div>
                    <div class="card-body">
                      <table class="table table-top-countries">
                          <thead>
                            <th>
                              Cash in Bank
                            </th>
                            <th>
                              Cash in Hand
                            </th>
                            <th>
                              Total Funds
                            </th>
                            <th>
                              Closing Balance
                            </th>
                            <th>
                              Date
                            </th>
                          </thead>
                          <tbody>
                            @foreach($balance as $c)
                            <tr>
                              <td class="text-dark">&#8358; {{$c->cash_bank}}</td>
                              <td class="text-dark">&#8358; {{$c->cash_in_hand}}</td>
                              <td class="text-dark">&#8358; {{$c->total_funds}}</td>
                              <td class="text-dark">&#8358; {{$c->closing_balance}}</td>
                              <td class="text-dark">
                                <?php 
                                  $createdAt = Carbon\Carbon::parse($c->date)->format('M d Y');
                                ?> 
                                {{$createdAt}}
                              </td>
                            </tr>
                            @endforeach
                          </tbody>
                      </table>
                    </div>
                  </div>
            	  <div class="card">
                  <div class="card-header user-header alt bg-info">
                      <h2 class="text-light display-6 mb-2 d-inline">Transactions</h2>
                      <a href="../../../{{$exporturl}}" class="d-inline float-right">                    
                        <i class="zmdi zmdi-download text-light zmdi-hc-2x"></i>                    
                      </a>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive m-b-40">
                      <table class="table table-top-countries">
                        <thead>
                          <tr>
                            <th>Product</th>
                            <th>Product Price</th>
                            <th>Wallet</th>
                            <th>Closing Balance</th>
                            <th>Date</th>                                            
                          </tr>
                        </thead>
                        <tbody>
                          @foreach($transactions as $t)
                           <tr>
                              <td class="text-dark">{{$t->product_name}}</td>
                              <td class="text-dark">&#8358; {{$t->sale_value}}</td>
                              <td class="text-dark">&#8358; {{$t->total_funds}}</td>
                              <td class="text-dark">&#8358; {{$t->closing_balance}}</td>
                              <td class="text-dark">
                                <?php 
                                  $createdAt = Carbon\Carbon::parse($t->date)->format('M d Y');
                                ?>
                                {{$createdAt}}
                              </td>                                            
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
    </div>
</div>
@endsection