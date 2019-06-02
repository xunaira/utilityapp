@extends('admin.app')

@section('content')
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                    <div class="col-md-12">
                        <!-- DATA TABLE -->
                        <h3 class="title-5 m-b-35">Agents Contacts</h3>
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
                                <a href="{{url('admin/reports/agent-export')}}" class="d-inline float-right">  
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
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone Number</th>
                                        <th>Address 1</th>
                                        <th>Address 2</th>
                                        <th>City</th>
                                        <th>State</th>
                                        <th>Country</th>
                                        <th>Operational Area</th>
                                        <th>Agent Type</th>
                                        <th>Supervisor</th>
                                        <th>Commission (%)</th>
                                        <th>Salary</th>                                        
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($agents as $a)
                                            <tr>
                                                <td>{{$a->name}}</td>
                                                <td>{{$a->email}}</td>
                                                <td>{{$a->phone_no}}</td>
                                                <td>{{$a->address1}}</td>
                                                <td>{{$a->address2}}</td>
                                                <td>{{$a->city}}</td>
                                                <td>{{$a->state}}</td>
                                                <td>{{$a->country}}</td>
                                                <td>{{$a->operational_area}}</td>
                                                <td>{{$a->agent_type}}</td>
                                                <td>{{$a->sup}}</td>
                                                <td>{{$a->commission}}</td>
                                                <td>{{$a->salary}}</td>                                                
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