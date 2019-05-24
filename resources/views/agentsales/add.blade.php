@extends('admin.app')

@section('content')
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8 mx-auto d-block">
                    <div class="card">
                        <div class="card-header">
                            <strong>Create Product</strong>
                        </div>
                        <div class="card-body card-block">
                            <form action="{{route('store')}}" method="post" class="form-horizontal">
                                @csrf
                                <div class="row form-group">
                                    <div class="col col-md-4">
                                        <label for="text-input" class=" form-control-label">Product</label>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <select id="product_id" name="product_id" id="text-input">
                                        @foreach($products as $p)
                                            <option id="product_idd" value="{{$p->id}}">{{$p->product_name}}</option>
                                        @endforeach
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
                                        <input type="text" readonly id="comm_company" name="date" value="{{date('Y/m/d')}}" class="form-control">
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-4">
                                        <label for="text-input" class=" form-control-label">Comission</label>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <input type="text" readonly id="comission" name="com_price" class="form-control">
                                    </div>
                                </div> 
<!-- 
                                 <div class="row form-group">
                                    <div class="col col-md-4">
                                        <label for="text-input" class=" form-control-label">Comission</label>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <input type="number" id="comm_self" name="comm_self" class="form-control">
                                    </div>
                                </div>   -->
                                                 
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
