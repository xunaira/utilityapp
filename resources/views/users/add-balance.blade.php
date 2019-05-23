@extends('admin.app')

@section('content')
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 mb-3">
                    <?php  
                        date_default_timezone_set('Africa/Lagos');
                        $time_now = Carbon\Carbon::now()->format('d M Y H:i:s'); 
                         ?>
                    <h5 class="float-right">Time Now: {{$time_now}}</h5>
                </div>
                <div class="col-lg-8 mx-auto d-block">
                    <div class="card">
                        <div class="card-header">
                            <strong>Wallet</strong>
                        </div>
                        <div class="card-body card-block">
                            <form action="../../admin/agents/add-balance" method="post" class="form-horizontal">
                                @csrf
                                <div class="row form-group">
                                    <div class="col col-md-4">
                                        <label for="text-input" class=" form-control-label">Total Fundings</label>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <input type="number" id="fundings" name="fundings" class="form-control">
                                    </div>
                                </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary btn-sm float-right">
                                <i class="fa fa-dot-circle-o"></i> Submit
                            </button>
                            <button type="reset" class="btn btn-danger btn-sm">
                                <i class="fa fa-ban"></i> Cancel
                            </button>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
