@extends('layouts.app')

@section('content')

            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                    Sympies Shopping Cart
                    <small>View</small>
                </h1>
                <ol class="breadcrumb">
                    <li><a href="#"><i class="fa fa-shop-cart"></i>Sympies Shop</a></li>
                    <li class="active"><a href="#">Cart</a>
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">

                <div class="box box-warning box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">Sympies Shopping Cart</h3>

                        <div class="box-tools pull-right">

                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body" >
                        <div class="row">
                            <div class="col-md-12">
                                <table id="example2" class="table table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th width="30%">Product Info</th>
                                        <th width="10%">Quantity</th>
                                        <th>Summary</th>
                                        <th width="15%">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach((array) $cart as $item)
                                        <tr>
                                            <td>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <img style="width: 100%;height: 100%;" src="{{($item['prodimg']==null||!file_exists($item['prodimg']))?asset('uPackage.png'):asset($item['prodimg'])}}" >
                                                        <br>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <strong style="color:gray"> {{$item['prodname']}}</strong><br>
                                                        Price: {{$item['prodprice']}} <br>
                                                        <label style="color:gray; font-size:10px">powered by: sympies and magpie.im</label>
                                                    </div>
                                                </div>
                                            </td>
                                            <td >
                                                <center>
                                                    {{--<input type="number" min="1" oninput="validity.valid||(value='');" class="form-control" name=qty  value ={{($item['qty'])?$item['qty']:0}} required>--}}
                                                    {{($item['qty'])?$item['qty']:0}}
                                                </center>
                                            </td>
                                            <td>
                                                {{--<label style="color:gray;font-size:15px; font-weight: 700">Computation</label><br>--}}
                                                The total price of {{$item['qty']}} pc/s, {{$item['prodname']}} is <strong style="color: gray;"> {{$item['qty']* $item['prodprice']}}</strong>

                                            </td>
                                            <td>
                                                <center>
                                                    @foreach(\App\r_product_info::all()->where('PROD_IS_APPROVED',1)->where('PROD_DISPLAY_STATUS',1)->where('PROD_ID',$item['id']) as $item1)
                                                    <form method="post"  action="{{url('/cart/add',$item['id'])}}"  enctype="multipart/form-data">
                                                        {{csrf_field()}}
                                                        <input type="hidden" name="_method" value="POST" />
                                                        <input class="hidden" name="id" value="{{$item1->PROD_ID}}" />
                                                        <input class="hidden" name="price" value="{{(($item1->PROD_REBATE/100)* $item1->PROD_BASE_PRICE)
                                                       +(($item1->rTaxTableProfile->TAXP_TYPE==0)?($item1->rTaxTableProfile->TAXP_RATE/100)* $item1->PROD_BASE_PRICE:($item1->rTaxTableProfile->TAXP_RATE)+ $item1->PROD_BASE_PRICE)
                                                       +(($item1->PROD_MARKUP/100)* $item1->PROD_BASE_PRICE)
                                                       +$item1->PROD_BASE_PRICE}}" />
                                                        <button class="btn btn-success" type="submit"><i class="fa fa-plus"></i> </button>
                                                        <button class="btn btn-danger"><i class="fa fa-minus"></i> </button>
                                                    </form>
                                                    @endforeach
                                                </center>
                                            </td>
                                        </tr>
                                    @endforeach

                                    </tbody>
                                    <tfoot>
                                    <th >Product Info</th>
                                    <th>Total Quantity</th>
                                    <th>Amount Due</th>
                                    <th width="15%">Action</th>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        <!-- /.row -->
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer" >
                    </div>
                </div>
                <!-- /.box -->

            </section>

@endsection
@section('extrajs')

    <script>
        @if(session('success'))
        iziToast.success({
            title: 'OK',
            position:"topRight",
            message: '{{session('success')}}',
        });
        @elseif(session('error'))
        iziToast.error({
            title: 'Error',
            position:"topRight",
            message: '{{session('error')}}',
        });
        @endif

    </script>
@endsection
