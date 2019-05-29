@extends('admin.app')

@section('content')
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            <strong>Add Sale</strong>
                        </div>
                        <div class="card-body card-block">
                         <form action="../../admin/agent-sales/store" method="post" class="form-horizontal">
                                @csrf
                                @if(Auth::user()->role_id == 1 || Auth::user()->role_id == 2)
                                    <div class="row form-group">
                                        <div class="col col-md-4">
                                            <label for="text-input" class=" form-control-label">Agent Name</label>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <select name="agent" class="form-control @error('product') is-invalid @enderror" id="agent">
                                                <option value="">-- SELECT AGENT --</option>
                                            @foreach($agents as $a)
                                                <option value="{{$a->agent_id}}">{{$a->name}}</option>
                                            @endforeach
                                            @error('product')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                            </select>
                                        </div>
                                    </div>
                                @endif  
                                <div class="row form-group">
                                    <div class="col col-md-4">
                                        <label for="text-input" class=" form-control-label">Product</label>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <select id="product_id" name="product_id" id="text-input" class="form-control">
                                            <option value="">-- SELECT PRODUCT --</option>
                                        @foreach($products as $p)
                                            <option id="product_idd" value="{{$p->id}}">{{$p->product_name}}</option>
                                        @endforeach
                                        @error('product')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                        </select>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-4">
                                        <label for="text-input" class=" form-control-label">Value of Sales</label>
                                    </div>
                                    <div class="col-12 col-md-6">

                                        <input type="number" id="sales_values2" name="sale_value" required class="form-control">
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-4">
                                        <label for="text-input" class=" form-control-label">Date</label>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <input type="date" id="date" name="date" class="form-control @error('product') is-invalid @enderror" value="<?php echo date('Y-m-d'); ?>">
                                        <input type="text" class="d-none" name="status" value="Pending Approval">
                                        @error('date')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div> 
                                <input type="number" class="rem_balance" class="d-none">                                    
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary btn-sm float-right" id="submit">
                                <i class="fa fa-dot-circle-o"></i> Submit
                            </button>
                            <button type="reset" class="btn btn-danger btn-sm">
                                <i class="fa fa-ban"></i> Cancel
                            </button>
                        </div>
                    </form>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header">
                            <strong>Summary</strong>
                        </div>
                        <div class="card-body card-block">
                            <div class="p-2">
                                <div class="form-control-label"><h4 class="mr-3 d-inline">Total Balance: </h4><span class="d-inline" id="total_balance"></span></div>
                                <input type="number" id="total" class="d-none">
                            </div>  
                            <div class="p-2">
                                <div class="form-control-label"><h4 class="mr-3 d-inline">Sales: </h4><span class="d-inline" id="sales_balance"></span></div>
                            </div> 
                            <div class="p-2">
                                <div class="form-control-label"><h4 class="mr-3 d-inline">Remaining Balance: </h4><span class="d-inline" id="rem_balance"></span></div>
                            </div> 
                        </div>
                        
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.js"></script>
<script type="text/javascript">
$('#submit').attr('disabled', 'true');

  $("#product_id").change(function () {
        var product_id = $(this).val();
       
        var sales_token = '{{csrf_token()}}';
        $.ajax({
            url:'{{route("get_product")}}',
            method:"Post",
            data:{product_id:product_id,_token:sales_token},
            datatype:"text",
            success:function(data) {
                console.log(data);
                   $('#comission').val(data.comission);
            }
        });
    });
   $('#sales_values2').change(function(){
        var icon = "<span>&#8358</span>";
        var sale = $('#sales_values2').val();
        $('#sales_balance').html(icon + " " + sale);

        var total = $('#total').text();
        console.log("total" + total);

        var rem = total - sale;

        $('#rem_balance').html(icon + " " + rem);
        $('.rem_balance').html(rem);


   })
   $("#agent").change(function () {
        //get the agent ID
        var id = $(this).val();

         //get the balance of this particular agent 
        var sales_token = '{{csrf_token()}}';

        $.ajax({
            url:'{{url("admin/agent-sales/balance")}}',
            method:"GET",
            data:{id:id,_token:sales_token},
            datatype:"text",
            success:function(data) {
                console.log(typeof data.funds[0]);
                console.log(data.funds[0] != " ");
                if(typeof data.funds[0] != "undefined"){
                    $('#submit').removeAttr('disabled');
                    
                    var icon = "<span>&#8358</span>";
                    $('div #total_balance').html(icon + " " + data.funds[0].total_funds);
                    $('#total').text(data.funds[0].total_funds);


                

                }else{
                    $('#submit').attr('disabled', 'true');
                    alert('Please add Agents wallet before adding sales');
                }

            }
            
        });
        $('div #total_balance').text(" ");


    });
</script>
@endsection
