@extends('admin.app')

@section('content')
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8 mx-auto d-block">
                    <div class="card">
                        <div class="card-header">
                            <strong>Add Sale</strong>
                        </div>
                        <div class="card-body card-block">
                         <form action="{{url('admin/agent-sales/update')}}" method="post" class="form-horizontal">
                                @csrf
                                @foreach($sales as $sale)
                                    <div class="row form-group">
                                        <input value="{{$sale->id}}" class="d-none" name="id">
                                        <div class="col col-md-4">
                                            <label for="text-input" class=" form-control-label">Product</label>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <select id="product_id" name="product_id" id="text-input" class="form-control">
                                            @foreach($products as $p)
                                                @if($sale->product_id == $p->id)
                                                    <option id="product_idd" value="{{$p->id}}" selected>{{$p->product_name}}</option>
                                                @else
                                                    <option id="product_idd" value="{{$p->id}}">{{$p->product_name}}</option>
                                                @endif
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

                                            <input type="number" id="sales_values2" name="sale_value" required class="form-control" value="{{$sale->sale_value}}">
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col col-md-4">
                                            <label for="text-input" class=" form-control-label">Date</label>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <input type="date" id="date" name="date" class="form-control @error('product') is-invalid @enderror" value="{{$sale->date}}">
                                            @error('date')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div> 
                                    @if(Auth::user()->role_id == 1 || Auth::user()->role_id == 2)
                                        <div class="row form-group">
                                            <div class="col col-md-4">
                                                <label for="text-input" class=" form-control-label">Agent Name</label>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <select name="agent" class="form-control @error('product') is-invalid @enderror" id="text-input">
                                                @foreach($agents as $a)
                                                    <option value="{{$a->id}}">{{$a->name}}</option>
                                                @endforeach
                                                @error('product')
                                                    <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                                </select>
                                            </div>
                                        </div>
                                    @endif 
                                @endforeach                                        
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.js"></script>
<script type="text/javascript">


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
   $("#sales_values2").change(function () {
    console.log("working")
     var sales_values2 = $(this).val();
     var com_self = $('#comission').val();
     var result=sales_values2*com_self;
     $('#comission').val(result);

    });
</script>
@endsection
