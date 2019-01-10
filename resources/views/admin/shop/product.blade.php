
@extends('layouts.admin')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Manage Products
                <small>Overview</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-barcode"></i>Manage Product</a></li>
            </ol>
        </section>
        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="small-box bg-purple-gradient">
                        <div class="inner">
                            <h3>{{\App\r_product_info::all()->where('PROD_DISPLAY_STATUS',1)->count()}}</h3>

                            <p>Products</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="small-box bg-green-gradient">
                        <div class="inner">
                            <h3>{{\App\r_product_info::all()->where('PROD_IS_APPROVED','1')->count()}}</h3>

                            <p>Approved</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-thumbs-up"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="small-box bg-aqua-gradient">
                        <div class="inner">
                            <h3>{{\App\r_product_info::all()->where('PROD_IS_APPROVED','null')->count()}}</h3>

                            <p>Pending</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-ellipsis-h"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="small-box bg-red-gradient">
                        <div class="inner">
                            <h3>{{\App\r_product_info::all()->where('PROD_IS_APPROVED','0')->count()}}</h3>

                            <p>Rejected</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-thumbs-down"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>


            </div>

            <div class="box box-success box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">Product Setup</h3>

                    <div class="box-tools pull-right">
                        <a href="#productsetup" id="addProduct" class="btn btn-success" data-toggle="modal"><i class="fa fa-plus"></i> Add Item</a>
                        {{--<a href="{{url('/product/export')}}" class="btn btn-info" ><i class="fa fa-print"></i> Export Excel</a>--}}
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
                                    <th>Base | Selling Price</th>
                                    <th>Date Modified</th>
                                    <th>Affiliate</th>
                                    <th width="15%">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($prodInfo as $item)
                                    <tr>
                                        <td>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <img style="width: 100%;height: 100%;" src="{{($item->PROD_IMG==null||!file_exists($item->PROD_IMG))?asset('uPackage.png'):asset($item->PROD_IMG)}}">
                                                    <br>
                                                </div>
                                                <div class="col-md-8">
                                                    <strong style="color:gray">{{$item->PROD_CODE}}</strong><br>
                                                    <strong>{{ $item->PROD_NAME}}</strong><br>
                                                  </div>
                                            </div>
                                        </td>
                                        <td>

                                            Base Price: {{$item->PROD_BASE_PRICE}} <br>
                                            Selling Price: {{$total=($item->PROD_IS_APPROVED==1)?(($item->PROD_REBATE/100)* $item->PROD_BASE_PRICE)
                                            +(($item->rTaxTableProfile->TAXP_TYPE==0)?($item->rTaxTableProfile->TAXP_RATE/100)* $item->PROD_BASE_PRICE:($item->rTaxTableProfile->TAXP_RATE)+ $item->PROD_BASE_PRICE)
                                            +(($item->PROD_MARKUP/100)* $item->PROD_BASE_PRICE)+$item->PROD_BASE_PRICE:'NAN'}}
                                        </td>
                                        <td data-order="{{$item->created_at}}">{{ (new DateTime($item->created_at))->format('D M d, Y | h:i A') }}</td>

                                        <td title ="{{$item->rAffiliateInfo->AFF_NAME}}"  data-order="{{$item->rAffiliateInfo->AFF_NAME}}" data-title="{{$item->rAffiliateInfo->AFF_NAME}}">
                                            <center>
                                                <img src="{{ Avatar::create($item->rAffiliateInfo->AFF_NAME)->toBase64() }}" style="height: 40px;">

                                                <br><span style="color: gray;">{{$item->rAffiliateInfo->AFF_NAME}}</span>
                                            </center>
                                        </td>
                                        <td>
                                            <center>

                                                {{--{{ ($item->PROD_APPROVED_AT=='')?'':(new DateTime($item->PROD_APPROVED_AT))->format('D M d, Y | h:i A') }}--}}
                                                    <div class="btn-group">
                                                        @if($item->PROD_DISPLAY_STATUS==1)
                                                        @if(is_null($item->PROD_IS_APPROVED))
                                                            <a href="#approve" data-toggle="modal" class="btn btn-success" id="app" vals="{{$item->PROD_ID}}"><i class="fa fa-thumbs-up"></i></a>
                                                            <a href="#disapprove" data-toggle="modal" class="btn btn-danger" id="disap" vals="{{$item->PROD_ID}}" ><i class="fa fa-thumbs-down"></i></a>
                                                        @elseif($item->PROD_IS_APPROVED==0)
                                                            <a href="#approve" data-toggle="modal" class="btn btn-success" id="app"  vals="{{$item->PROD_ID}}"><i class="fa fa-thumbs-up"></i></a>
                                                        @elseif($item->PROD_IS_APPROVED==1)
                                                            <a href="#disapprove" data-toggle="modal"  class="btn btn-danger" id="disap" vals="{{$item->PROD_ID}}"><i class="fa fa-thumbs-down"></i></a>
                                                        @endif
                                                        <button type="button" class="btn btn-info btn-flat dropdown-toggle" data-toggle="dropdown">
                                                            More
                                                            <span class="caret"></span>
                                                            <span class="sr-only">Toggle Dropdown</span>
                                                        </button>
                                                        <ul class="dropdown-menu" role="menu">
                                                        @if(Auth::user()->AFF_ID == $item->AFF_ID)
                                                                    <li> <a  id='viewProduct' total="{{$total}}" href="#prodView" data-toggle="modal" vals="{{$item->PROD_ID}}" >View</a></li>
                                                                    <li> <a  id='editProduct' href="#productsetup" data-toggle="modal" vals="{{$item->PROD_ID}}">Edit Product Info</a></li>
                                                                    <li> <a  id='editVariance' href="#productVariance" data-toggle="modal" vals="{{$item->PROD_ID}}" onclick="$('input[id=varProdID]').val({{$item->PROD_ID}});" >Product Variance</a></li>
                                                                    <li class="divider"></li>
                                                                    <li> <a  id=deact href="#"  vals="{{$item->PROD_ID}}"  >Deactivate</a></li>
                                                            @else
                                                                    <li> <a  id='viewProduct' total="{{$total}}" href="#prodView" data-toggle="modal" vals="{{$item->PROD_ID}}" >View</a></li>
                                                                    <li class="divider"></li>
                                                                    <li> <a  id=deact href="#"  vals="{{$item->PROD_ID}}"  >Deactivate</a></li>
                                                            @endif
                                                        </ul>
                                                        @else
                                                            <a id=act  vals="{{$item->PROD_ID}}" class="btn btn-success"><i class="fa fa-rotate-left"></i></a>
                                                        @endif
                                                    </div>
                                            </center>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                    <th>Product Info</th>
                                    <th>Base | Selling Price</th>
                                    <th>Date Modified</th>
                                    <th>Affiliate</th>
                                    <th>Action</th>
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
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->


    <div class="modal modal-default fade" id="prodView" >
        <div class="modal-dialog" style="width: 500px" >
            <div class="box box-info box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">Product Information</h3>
                </div>
                <div class="box-body">
                    <div class="col-lg-12">
                        <center><img name="prodImage" class="img-responsive pad" width="100%"  src="" alt=""></center>
                        <center><strong><span style="font-size:20px" name="prodname" ></span></strong> - <span name="prodtype" class="text-muted"></span></center>
                        <br>
                        <span name="prodprice" class="pull-right text-muted"></span>
                        <p style="color:darkslategray" name="proddesc"></p>
                    </div>
                    <br>
                    <div class="col-lg-12">
                        <div name="prodnote"></div>
                    </div>
                </div>
                <div id="overlay" class="overlay" style="display:none">
                    <i class="fa fa-refresh fa-spin"></i>
                </div>
            </div>
        </div>
    </div>





    <div class="modal modal-default fade" id="productsetup" >
        <div class="modal-dialog" style="width: 1000px" >
            <div class="box box-warning box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">Product Information</h3>
                </div>
                <div class="box-body">
                    <br>
                    <form method="post" id="productModal" action="{{url('member/shop/product')}}"  enctype="multipart/form-data">
                        {{csrf_field()}}
                        <input type="hidden" name="_method" value="POST" />
                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Product Code</label>
                                        <input class="form-control" name=prodcode readonly="readonly" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Product Name*</label>
                                        <input class="form-control" name=prodname placeholder="Product Name" required>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Product Base Price*</label>
                                        <div class="input-group">
                                            <input type="number" placeholder="0" name="baseprice" class="form-control" required>
                                            <div class="input-group-addon">
                                                <i class="fa fa-money"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Product Markup* (Sympies)</label>
                                        <div class="input-group">
                                            <input type="number" placeholder="0" name="prodmarkup" class="form-control" required>
                                            <div class="input-group-addon">
                                                %
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Starting Inventory*</label>
                                        <div class="input-group">
                                            <input type="number" placeholder="0" name="inv_qty" class="form-control" required>
                                            <div class="input-group-addon">
                                                #
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Inventory Critical Level*</label>
                                        <div class="input-group">
                                            <input type="number" placeholder="0" name="inv_critical" class="form-control" required>
                                            <div class="input-group-addon">
                                                #
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Product Rebate* (Affiliate)</label>
                                        <div class="input-group">
                                            <input type="number" placeholder="0" name="prodrebate" class="form-control" required>
                                            <div class="input-group-addon">
                                                %
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Product Tax*</label>
                                        <select class="form-control productTax" name="prodtax" style="width: 100%;" required>
                                            <option selected="selected" value="0" disabled>Please Select Product Tax</option>
                                            <optgroup label="Percentage">
                                                @foreach($taxProf->where('TAXP_TYPE',0) as $item)
                                                    <option value="{{$item->TAXP_ID}}">{{$item->TAXP_NAME}} - {{$item->TAXP_RATE}}</option>
                                                @endforeach
                                            </optgroup>
                                            <optgroup label="Fixed">
                                                @foreach($taxProf->where('TAXP_TYPE',1) as $item)
                                                    <option value="{{$item->TAXP_ID}}">{{$item->TAXP_NAME}} - {{$item->TAXP_RATE}}</option>
                                                @endforeach
                                            </optgroup>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Product Category*</label>
                                        <select class="form-control productType" name="prodtype" style="width: 100%;" required>
                                            <option selected="selected" value="0" disabled>Please Select Product Category</option>
                                            @foreach($prodType->where('PRODT_PARENT',null)->where('PRODT_DISPLAY_STATUS',1) as $item)
                                                <optgroup label="{{$item->PRODT_TITLE}}">
                                                    @foreach($prodType->where('PRODT_PARENT',$item->PRODT_ID)->where('PRODT_DISPLAY_STATUS',1) as $item1)
                                                        <option value="{{$item1->PRODT_ID}}">{{$item1->PRODT_TITLE}}</option>
                                                    @endforeach
                                                </optgroup>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Product Image (optional)</label>
                                        <input class="form-control" name=prodimg type="file">
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Product Description*</label>
                                        <textarea class="form-control" name=proddesc style="resize:vertical; width:100%;height:107px" placeholder="Product Description" required></textarea>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Product Note</label>
                                        <textarea class="form-control" name=prodnote style="resize:vertical; width:100%;height:107px" placeholder="Product Note"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12" >
                                <div class="pull-right" style="margin-right: 10px;">
                                    <button class="btn btn-success" type="submit" >Save</button>
                                    <a class="btn btn-danger" data-dismiss="modal"> Cancel</a>
                                </div>
                            </div>
                        </div>
                        <!-- /.row -->
                    </form>
                </div>
                <div id="overlay" class="overlay" style="display:none">
                    <i class="fa fa-refresh fa-spin"></i>
                </div>
            </div>
        </div>
    </div>


    <div class="modal modal-success fade" id="productVariance">
        <div class="modal-dialog" style="width:1200px">
            <div class="box box-warning box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">Product Variance Setup</h3>
                </div>
                <div class="box-body">
                    <form id="productVarianceForm" method="post" action="{{url('/product/ProductVar')}}" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <input id="varProdID" name="prodID" value="1" class="hidden">
                        <div class="row" style="padding: 10px;">
                            <div class="col-md-12" style="padding-bottom: 20px;">
                                <strong id="prodname">Product Name</strong>
                                <p id="proddesc">Product Description</p>
                            </div>
                            <table id="prodvartable" class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th>Name*</th>
                                    <th width="20%">Additional Price*</th>
                                    <th width="20%">Image (optional)</th>
                                    <th>Description*</th>
                                    <th>Stock Qty*</th>
                                    <th><a id=addVar class="btn btn-success"><i class="fa fa-plus"></i></a></th>
                                </tr>
                                </thead>
                                <tbody>
                                    {{--<tr>--}}
                                        {{--<td class="hidden"><input  name="prodVarID[]" value="0" class="hidden"></td>--}}
                                        {{--<td><input type="text" placeholder="Product Variance Name" name="prodvarname[]" class="form-control" required></td>--}}
                                        {{--<td><div class="input-group">--}}
                                                {{--<input type="number" placeholder="0" name="addprice[]" class="form-control" value=0 required>--}}
                                                {{--<div class="input-group-addon">--}}
                                                    {{--<i class="fa fa-money"></i>--}}
                                                {{--</div>--}}
                                            {{--</div>--}}
                                        {{--</td>--}}
                                        {{--<td><input class="form-control" name=prodvarimg[] type="file"></td>--}}
                                        {{--<td><textarea class="form-control" name=prodvardesc[] style="resize:vertical; width:100%;height:36px" placeholder="Product Description" required></textarea></td>--}}
                                        {{--<td>--}}
                                            {{--<div class="input-group">--}}
                                                {{--<input type="number" placeholder="0" name="prod_qty[]" class="form-control" required >--}}
                                                {{--<div class="input-group-addon">--}}
                                                    {{--#--}}
                                                {{--</div>--}}
                                            {{--</div>--}}
                                        {{--</td>--}}
                                        {{--<td><a class="btn btn-danger" onclick="if($('#prodvartable tbody tr').length>1)$(this).closest('tr').remove()"><i class="fa fa-minus"></i></a></td>--}}
                                    {{--</tr>--}}
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>Name</th>
                                    <th>Additional Price</th>
                                    <th>Image (optional)</th>
                                    <th>Description</th>
                                    <th>Stock Qty</th>
                                    <th><a id=clearAllVar class="btn btn-danger"><i class="fa fa-ban"></i></a></th>
                                </tr>
                                </tfoot>
                            </table>


                            <div class="pull-right" style="margin-right: 10px;">
                                <br>
                                <button type="submit" class="btn btn-success" id="appSave">Save changes</button>
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </form>
                </div>

                <div id="overlay" class="overlay" style="display:none">
                    <i class="fa fa-refresh fa-spin"></i>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->


    <div class="modal modal-success fade" id="approve">
        <div class="modal-dialog">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Product Approval</h3>
                </div>
                <div class="box-body">
                    <form id="approvalForm" method="post" action="{{url('/product/appDisapprove')}}" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <input name="type" value="1" class="hidden">
                        <input id="prodID" name="id" value="1" class="hidden">
                        <input type="hidden" name="_method" value="POST" />
                        <div class="row" style="padding: 10px;">
                            <div class="col-md-12" style="padding-bottom: 20px;">
                                <strong>Are you sure? you want to approved this product?</strong>
                                <p>Please provide the following inputs to validate the product in the market.</p>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Product Tax</label>
                                    <select class="form-control productType" name="prodtax" style="width: 100%;" required>
                                        <option selected value="0" disabled>Please Select Tax Reference</option>
                                        <optgroup label="Percentage">
                                            @foreach($taxProf->where('TAXP_TYPE',0) as $item)
                                                <option value="{{$item->TAXP_ID}}">{{$item->TAXP_NAME}} - {{$item->TAXP_RATE}} % </option>
                                            @endforeach
                                        </optgroup>
                                            <optgroup label="Fixed">
                                                @foreach($taxProf->where('TAXP_TYPE',1) as $item)
                                                    <option value="{{$item->TAXP_ID}}">{{$item->TAXP_NAME}} - {{$item->TAXP_RATE}}</option>
                                                @endforeach
                                            </optgroup>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Product Markup Value</label>
                                    <div class="input-group">
                                        <input type="number" placeholder="0" name="prodmarkup" class="form-control" required>
                                        <div class="input-group-addon">
                                            %
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Product Rebate (Affiliate)</label>
                                    <div class="input-group">
                                        <input type="number" placeholder="0" name="prodrebate" class="form-control" required>
                                        <div class="input-group-addon">
                                            %
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="pull-right" style="margin-right: 10px;">
                                <br>
                                <button type="submit" class="btn btn-success" id="appSave">Save changes</button>
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </form>
                </div>

                <div id="overlay" class="overlay" style="display:none">
                    <i class="fa fa-refresh fa-spin"></i>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->



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


        // $("input[name='prodsize']").tagsInput({
        //     'height':'28px',
        //     'width':'100%',});
        $("textarea[name='prodnote']").wysihtml5();
        $('.productType').select2();
        // $('.productColor').select2();
        // $('.productSize').select2();
        $('.productTax').select2();

        // function clearSizesTags(){
        //     $.each($("input[name='prodsize']").val().split(','),function(index,value){
        //         $("input[name='prodsize']").removeTag(value);
        //
        //     })
        // }

        $("#addVar").on("click",function(){
            $(this).closest('table').find('tbody').append(
                '   <tr>\n' +
                '            <td class=hidden><input  name="prodVarID[]" value="0" class="hidden"></td>\n' +
                '                <td><input type="text" placeholder="Product Variance Name" name="prodvarname[]" class="form-control" required></td>\n' +
                '            <td><div class="input-group">\n' +
                '                <input type="number" placeholder="0" name="addprice[]" value=0 class="form-control" required>\n' +
                '            <div class="input-group-addon">\n' +
                '                <i class="fa fa-money"></i>\n' +
                '                </div>\n' +
                '                </div>\n' +
                '                </td>\n' +
                '                <td><input class="form-control" name=prodvarimg[] type="file"></td>\n' +
                '                <td><textarea class="form-control" name=prodvardesc[] style="resize:vertical; width:100%;height:36px" placeholder="Product Description" required></textarea></td>\n' +
                '            <td><div class="input-group">\n' +
                '                <input type="number" placeholder="0" name="inv_qty[]" class="form-control" required>\n' +
                '            <div class="input-group-addon">\n' +
                '                #\n' +
                '                </div>\n' +
                '                </div>\n' +
                '                </td>\n' +
                '            <td><a class="btn btn-danger" onclick="if($(\'#prodvartable tbody tr\').length>1)$(this).closest(\'tr\').remove()"><i class="fa fa-minus"></i></a></td>\n' +
                '   </tr>'
            );
        });


        $("#clearAllVar").on('click',function(){
            $id = $("input[id=varProdID]").val();
            $.ajax({
                url: '/product/deleteAllProductVar'
                ,type: 'post'
                ,data: {_token:CSRF_TOKEN,id:$id }
                ,dataType:'json'
                ,success:function($data) {
                    window.location.reload();
                }
                ,error:function(){}
            });

        });
        $("a[id='editVariance']").on('click',function() {
            $('input[name=prodID]').val($(this).attr('vals'));
            $id = $(this).attr('vals');
            $.ajax({
                url: '/product/showProductVar/'+$id
                ,type: 'get'
                ,data: {_token:CSRF_TOKEN }
                ,dataType:'json'
                ,success:function($data){
                    $('#prodvartable').find('tbody tr').remove();
                    $.each($data.data,function(index,value){
                        $("#productVariance #prodname").html($data.data[0].r_product_info.PROD_NAME);
                        $("#productVariance #proddesc").html($data.data[0].r_product_info.PROD_DESC);
                        $('#prodvartable').find('tbody').append(
                            '   <tr>\n' +
                            '            <td class=hidden><input  name="prodVarID[]" value="'+$data.data[index].PRODV_ID+'" class="hidden"></td>\n>?' +
                            '                <td><input value="'+$data.data[index].PRODV_NAME+'" type="text" placeholder="Product Variance Name" name="prodvarname[]" class="form-control" required></td>\n' +
                            '            <td><div class="input-group">\n' +
                            '                <input value="'+$data.data[index].PRODV_ADD_PRICE+'"  type="number" placeholder="0" name="addprice[]" class="form-control" required >\n' +
                            '            <div class="input-group-addon">\n' +
                            '                <i class="fa fa-money"></i>\n' +
                            '                </div>\n' +
                            '                </div>\n' +
                            '                </td>\n' +
                            '                <td><input  class="form-control" name=prodvarimg[] type="file"></td>\n' +
                            '                <td><textarea class="form-control" name=prodvardesc[] style="resize:vertical; width:100%;height:36px" placeholder="Product Description" required>'+$data.data[index].PRODV_DESC+'</textarea></td>\n' +
                            '            <td><div class="input-group">\n' +
                            '                <input value="'+$data.data[index].PRODV_QTY+'"  type="number" placeholder="0" name="inv_qty[]" class="form-control" required>\n' +
                            '            <div class="input-group-addon">\n' +
                            '                #\n' +
                            '                </div>\n' +
                            '                </div>\n' +
                            '                </td>\n' +
                            '            <td><a class="btn btn-danger" onclick="if($(\'#prodvartable tbody tr\').length>1)$(this).closest(\'tr\').remove()"><i class="fa fa-minus"></i></a></td>\n' +
                            '            </tr>'
                        );

                    });

                    $('#prodvartable').find('tbody').append(
                    '   <tr>\n' +
                    '            <td class=hidden><input  name="prodVarID[]" value="0" class="hidden"></td>\n' +
                    '                <td><input type="text" placeholder="Product Variance Name" name="prodvarname[]" class="form-control" required></td>\n' +
                    '            <td><div class="input-group">\n' +
                    '                <input type="number" placeholder="0" name="addprice[]" class="form-control" required value=0>\n' +
                    '            <div class="input-group-addon">\n' +
                    '                <i class="fa fa-money"></i>\n' +
                    '                </div>\n' +
                    '                </div>\n' +
                    '                </td>\n' +
                    '                <td><input class="form-control" name=prodvarimg[] type="file"></td>\n' +
                    '                <td><textarea class="form-control" name=prodvardesc[] style="resize:vertical; width:100%;height:36px" placeholder="Product Description" required></textarea></td>\n' +
                        '            <td><div class="input-group">\n' +
                        '                <input type="number" placeholder="0" name="inv_qty[]" class="form-control" required>\n' +
                        '            <div class="input-group-addon">\n' +
                        '                #\n' +
                        '                </div>\n' +
                        '                </div>\n' +
                        '                </td>\n' +
                    '            <td><a class="btn btn-danger" onclick="if($(\'#prodvartable tbody tr\').length>1)$(this).closest(\'tr\').remove()"><i class="fa fa-minus"></i></a></td>\n' +
                    '   </tr>'
                    );

                }
                ,error:function(){}
                });

        });


        $("a[id='viewProduct']").on('click',function () {

            document.querySelector('#productModal').reset();

            $id = $(this).attr('vals');
            $total = $(this).attr('total');
            $.ajax({
                url: 'product/'+$id
                ,type: 'get'
                ,data: {_token:CSRF_TOKEN }
                ,dataType:'json'
                ,success:function($data){
                    $("img[name=prodImage]").attr('src',$data.data[1].IMG);

                    $("input[name='prodcode']").val($data.data[0].PROD_CODE);
                    $("p[name='proddesc']").text($data.data[0].PROD_DESC);
                    $("span[name='prodname']").text($data.data[0].PROD_NAME);
                    $("div[name='prodnote']").html($data.data[0].PROD_NOTE);
                    $("span[name='prodprice']").text($data.data[0].PROD_BASE_PRICE+' + '+$data.data[0].PROD_REBATE+'% '
                    +' + '+$data.data[0].PROD_MARKUP+'% = '+$total);
                    $("span[name='prodtype']").text($data.data[0].r_product_type.PRODT_TITLE);


                    $("input[name='baseprice']").val($data.data[0].PROD_BASE_PRICE);
                    $("input[name='prodrebate']").val($data.data[0].PROD_REBATE);
                    $("select[name='prodtax']").val($data.data[0].TAXP_ID).trigger('change');
                    $("input[name='prodmarkup']").val($data.data[0].PROD_MARKUP);
                    $("input[name='inv_qty']").val($data.data[0].PROD_QTY);
                    $("input[name='inv_critical']").val($data.data[0].PROD_CRITICAL);
                    var editorObj = $("textarea[name='prodnote']").data('wysihtml5');
                    var editor = editorObj.editor;
                    editor.setValue($data.data[0].PROD_NOTE);
                    $('#productModal').attr('action','{{url('admin/shop/product')}}/'+$data.data[0].PROD_ID);
                    $("input[name='_method']").attr('value','PATCH');
                }
                ,error:function(){

                }
            });

        });


        $("a[id='editProduct']").on('click',function () {

            document.querySelector('#productModal').reset();
            // clearSizesTags();
            // $("select[name='prodcolor[]']").val(null).trigger('change');
            $("select[name='prodtax']").val(0).trigger('change');
            $("select[name='prodtype']").val(0).trigger('change');

            $id = $(this).attr('vals');
            $.ajax({
                url: 'product/'+$id
                ,type: 'get'
                ,data: {_token:CSRF_TOKEN }
                ,dataType:'json'
                ,success:function($data){

                    $("input[name='prodcode']").val($data.data[0].PROD_CODE);
                    $("input[name='prodid']").val($data.data[0].PROD_ID);
                    $("input[name='prodname']").val($data.data[0].PROD_NAME);
                    $("input[name='baseprice']").val($data.data[0].PROD_BASE_PRICE);
                    $("input[name='prodrebate']").val($data.data[0].PROD_REBATE);
                    $("select[name='prodtax']").val($data.data[0].TAXP_ID).trigger('change');
                    $("input[name='prodmarkup']").val($data.data[0].PROD_MARKUP);
                    $("input[name='inv_qty']").val($data.data[0].PROD_QTY);
                    $("input[name='inv_critical']").val($data.data[0].PROD_CRITICAL);
                    $("select[name='prodtype']").val($data.data[0].PRODT_ID).trigger('change');
                    // $("select[name='prodcolor[]']").val(($data.data[0].PROD_COLOR)?$data.data[0].PROD_COLOR.split(',',2):"").trigger('change');
                    // $("input[name='prodsize']").importTags( $data.data[0].PROD_SIZE);
                    $("textarea[name='proddesc']").val($data.data[0].PROD_DESC);
                    var editorObj = $("textarea[name='prodnote']").data('wysihtml5');
                    var editor = editorObj.editor;
                    editor.setValue($data.data[0].PROD_NOTE);
                    $('#productModal').attr('action','{{url('admin/shop/product')}}/'+$data.data[0].PROD_ID);
                    $("input[name='_method']").attr('value','PATCH');
                }
                ,error:function(){

                }
            });

        });

        $('#example2').DataTable({
            'paging'      : true,
            'lengthChange': true,
            'searching'   : true,
            'ordering'    : true,
            'info'        : true,
            'autoWidth'   : true,
            "aaSorting": [[ 2, "desc" ]]
            ,dom: 'Bfrtip'
            ,   buttons: [
                { extend: 'copy', className: 'btn-sm',
                    exportOptions: {
                        columns: [0,1,2,3]
                    }
                },
                { extend: 'csv', className: 'btn-sm' ,
                    exportOptions: {
                        columns: [0,1,2,3]
                    }
                },
                { extend: 'excel', className: 'btn-sm',
                    exportOptions: {
                        columns: [0,1,2,3]
                    }
                },
                { extend: 'pdf', className: 'btn-sm',
                    exportOptions: {
                        columns: [0,1,2,3]
                    }
                },
                { extend: 'print', className: 'btn-sm',
                    exportOptions: {
                        columns: [0,1,2,3]
                    }
                },


            ],
        });

        $("a[id='addProduct']").on('click',function () {
            $('#productModal').attr('action','{{url('admin/shop/product')}}');
            document.querySelector('#productModal').reset();
            // clearSizesTags();
            $("select[name='prodtype']").val(0).trigger('change');
            // $("select[name='prodcolor[]']").val(null).trigger('change');
            $("select[name='prodtax']").val(0).trigger('change');
            $('input[name="prodcode"]').val('PROD-{{ sprintf('%05s',Auth::user()->AFF_ID) }}-{{DB::Table('R_PRODUCT_INFOS')
            ->where('AFF_ID',Auth::user()->AFF_ID)->get()->count()+1}}');
            $("input[name='_method']").attr('value','POST');
        });

        $("a[id='disap']").on('click',function(){
            $id = $(this).attr('vals');
            swal({
                title: "This product will be disapproved?"
                , text: "After this action, this product is not available on market, unless it is activated"
                , type: "warning"
                , showLoaderOnConfirm: true
                , showCancelButton: true
                , confirmButtonColor: '#9DD656'
                , confirmButtonText: 'Yes!'
                , cancelButtonText: "No!"
                , closeOnConfirm: false
                , closeOnCancel: true
            }, function (isConfirm) {
                if (isConfirm) {
                    $.ajax({
                        url: '/product/appDisapprove'
                        ,type: 'post'
                        ,data: {id:$id,_token:CSRF_TOKEN, type:0  }
                        ,success:function(){
                            window.location.reload();
                        }
                        ,error:function(){}
                    });
                }
            });
        });

        $("a[id='app']").on('click',function(){
            $id =$(this).attr('vals');
            $('#approvalForm #prodID').val($(this).attr('vals'));
            $("select[name='prodtax']").val(0).trigger('change');
            $("input[name='prodrebate']").val(null);
            $("input[name='prodmarkup']").val(null);
            $.ajax({
                url: 'product/'+$id
                ,type: 'get'
                ,data: {_token:CSRF_TOKEN }
                ,dataType:'json'
                ,success:function($data){
                    $("input[name='prodrebate']").val($data.data[0].PROD_REBATE);
                    $("select[name='prodtax']").val($data.data[0].TAXP_ID).trigger('change');
                    $("input[name='prodmarkup']").val($data.data[0].PROD_MARKUP);
                }
                ,error:function(){

                }
            });
        });
        $("a[id='deact']").on('click',function(){
            $id = $(this).attr('vals');
            swal({
                title: "This record will be deactivated?"
                , text: "After this action, this record is not available, unless it is activated"
                , type: "warning"
                , showLoaderOnConfirm: true
                , showCancelButton: true
                , confirmButtonColor: '#9DD656'
                , confirmButtonText: 'Yes!'
                , cancelButtonText: "No!"
                , closeOnConfirm: false
                , closeOnCancel: true
            }, function (isConfirm) {
                if (isConfirm) {
                    $.ajax({
                        url: '/product/actDeact'
                        , type: 'post'
                        , data: {id: $id, _token: CSRF_TOKEN, type: 0}
                        , success: function () {
                            location.reload();
                        }
                        , error: function () {

                        }
                    });
                }
            });
        });

        $("a[id='act']").on('click',function(){
            $id = $(this).attr('vals');
            swal({
                title: "This record will be activated?"
                , text: "After this action, this record is now available, unless it is deactivated"
                , type: "warning"
                , showLoaderOnConfirm: true
                , showCancelButton: true
                , confirmButtonColor: '#9DD656'
                , confirmButtonText: 'Yes!'
                , cancelButtonText: "No!"
                , closeOnConfirm: false
                , closeOnCancel: true
            }, function (isConfirm) {
                if (isConfirm) {
                    $.ajax({
                        url: '/product/actDeact'
                        , type: 'post'
                        , data: {id: $id, _token: CSRF_TOKEN, type: 1}
                        , success: function () {
                            location.reload();
                        }
                        , error: function () {

                        }
                    });
                }
            });
        });

    </script>
@endsection


