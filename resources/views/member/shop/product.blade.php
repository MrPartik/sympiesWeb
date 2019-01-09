
@extends('layouts.member')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Product
                <small>Overview</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-barcode"></i> Product</a></li>
            </ol>
        </section>


        <!-- Main content -->
        <section class="content">
            <div class="row">

                {{--<div class="col-md-3 col-sm-6 col-xs-12">--}}
                    {{--<div class="info-box">--}}
                        {{--<span class="info-box-icon bg-aqua"><i class="fa fa-shopping-cart"></i></span>--}}

                        {{--<div class="info-box-content">--}}
                            {{--<span class="info-box-text">--sample--</span>--}}
                            {{--<span class="info-box-number">1,410</span>--}}
                        {{--</div>--}}
                        {{--<!-- /.info-box-content -->--}}
                    {{--</div>--}}
                    {{--<!-- /.info-box -->--}}
                {{--</div>--}}

                {{--<div class="col-md-3 col-sm-6 col-xs-12">--}}
                    {{--<div class="info-box">--}}
                        {{--<span class="info-box-icon bg-green"><i class="fa fa-users"></i></span>--}}

                        {{--<div class="info-box-content">--}}
                            {{--<span class="info-box-text">--sample--</span>--}}
                            {{--<span class="info-box-number">10</span>--}}
                        {{--</div>--}}
                        {{--<!-- /.info-box-content -->--}}
                    {{--</div>--}}
                    {{--<!-- /.info-box -->--}}
                {{--</div>--}}

            </div>

            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">Products</h3>

                    <div class="box-tools pull-right">
                        <a href="#productsetup" id="addProduct" class="btn btn-success" data-toggle="modal"><i class="fa fa-plus"></i> Add Products</a>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body" >
                    <div class="row">
                      <div class="col-md-12">
                          <table id="example2" class="table table-bordered table-hover" >
                              <thead>
                              <tr>
                                  <th width=30%>Product Info</th>
                                  <th>Affiliate Price and Selling Price</th>
                                  <th>Approval Status</th>
                                  <th>Date Issued</th>
                                  <th width=15%>Action</th>
                              </tr>
                              </thead>
                              <tbody>
                              @foreach($prodInfo->where('AFF_ID',Auth::user()->AFF_ID) as $item)
                              <tr>
                                  {{--<td>{{ $affInfo->where('AFF_ID', $item->AFF_ID)->first()->AFF_NAME }}</td>--}}
                                  <td>
                                      <div class="row">
                                          <div class="col-md-4">
                                              <img style="width: 100%;height: 100%;" src="{{($item->PROD_IMG==null||!file_exists(explode(',',$item->PROD_IMG)[0]))?asset('uPackage.png'):asset(explode(',',$item->PROD_IMG)[0])}}">
                                          </div>
                                          <div class="col-md-8">
                                              <strong> {{ $item->PROD_NAME}}</strong><br>
                                              {{( !isset($item->rProductType->PRODT_TITLE) )?'': $item->rProductType->PRODT_TITLE}}<br>
                                              {{($item->PROD_DESC=='')?'unknown description':$item->PROD_DESC}}<br>
                                              {{($item->PROD_SIZE=='')?'unknown size':$item->PROD_SIZE}}<br>
                                              {{--<div style="width: 100%;height: 10px; background: {{$item->PROD_COLOR}}"; ></div>--}}
                                          </div>
                                      </div>
                                  </td>
                                  <td>
                                      Base Price: {{$item->PROD_BASE_PRICE}} <br>
                                      Selling Price:
                                      @if($item->PROD_IS_APPROVED==1)
                                          {{ (($item->PROD_REBATE/100)* $item->PROD_BASE_PRICE)
                                      +(($item->rTaxTableProfile->TAXP_TYPE==0)?($item->rTaxTableProfile->TAXP_RATE/100)* $item->PROD_BASE_PRICE:($item->rTaxTableProfile->TAXP_RATE)+ $item->PROD_BASE_PRICE)
                                      +(($item->PROD_MARKUP/100)* $item->PROD_BASE_PRICE)+$item->PROD_BASE_PRICE }}
                                      @else
                                          <label style="color:red">Your product is not approved</label>
                                      @endif
                                  </td>
                                  <td>
                                      <center>
                                          @if($item->PROD_IS_APPROVED=='')
                                              <span class="label label-info">Pending</span>
                                          @elseif($item->PROD_IS_APPROVED==1)
                                              <span class="label label-success">Approved</span>
                                          @elseif($item->PROD_IS_APPROVED==0)
                                              <span class="label label-danger">Rejected</span>
                                          @endif
                                      </center>
                                  </td>
                                  <td data-order="{{$item->created_at}}">{{ (new DateTime($item->created_at))->format('D M d, Y | h:i A') }}</td>
                                  <td>
                                      <center>
                                          @if($item->PROD_DISPLAY_STATUS==1)
                                              <div id="activePanel">
                                                  <a class="btn btn-info" id='editProduct' href="#productsetup" data-toggle="modal" vals="{{$item->PROD_ID}}" href="#prodsetup"><i class="fa fa-pencil"></i></a>
                                                  <a  id='editVariance' class="btn btn-warning" href="#productVariance" data-toggle="modal" vals="{{$item->PROD_ID}}" onclick="$('input[id=varProdID]').val({{$item->PROD_ID}});" ><i class="fa fa-list"></i></a>
                                                  <a id=deact  vals="{{$item->PROD_ID}}" class="btn btn-danger" ><i class="fa fa-ban"></i></a>
                                              </div>
                                           @else
                                              <div id="deactivatedPanel">
                                                  <a id=act  vals="{{$item->PROD_ID}}" class="btn btn-success"><i class="fa fa-rotate-left"></i></a>
                                              </div>
                                          @endif
                                      </center>
                                  </td>
                              </tr>
                              @endforeach
                              </tbody>
                              <tfoot>
                                  <th>Product Info</th>
                                  <th>Affiliate Price and Selling Price</th>
                                  <th>Approval Status</th>
                                  <th>Date Issued</th>
                                  <th>Action</th>
                              </tfoot>
                          </table>
                      </div>
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.box-body -->
                <div id="overlay" class="overlay" style="display:none">
                    <i class="fa fa-refresh fa-spin"></i>
                </div>
            </div>
            <!-- /.box -->


        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->


    <div class="modal modal-success fade" id="productVariance">
        <div class="modal-dialog" style="width:1000px">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Product Variance Setup</h3>
                </div>
                <div class="box-body">
                    <form id="productVarianceForm" method="post" action="{{url('/product/ProductVar')}}" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <input id="varProdID" name="prodID" value="1" class="hidden">
                        <input type="hidden" name="_method" value="POST" />
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
                                    <th><a id=addVar class="btn btn-success"><i class="fa fa-plus"></i></a></th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td class="hidden"><input  name="prodVarID[]" value="0" class="hidden"></td>
                                    <td><input type="text" placeholder="Product Variance Name" name="prodvarname[]" class="form-control" required></td>
                                    <td><div class="input-group">
                                            <input type="number" placeholder="0" name="addprice[]" class="form-control" required>
                                            <div class="input-group-addon">
                                                <i class="fa fa-money"></i>
                                            </div>
                                        </div>
                                    </td>
                                    <td><input class="form-control" name=prodvarimg[] type="file"></td>
                                    <td><textarea class="form-control" name=prodvardesc[] style="resize:vertical; width:100%;height:36px" placeholder="Product Description" required></textarea></td>
                                    <td><a class="btn btn-danger" onclick="if($('#prodvartable tbody tr').length>1)$(this).closest('tr').remove()"><i class="fa fa-minus"></i></a></td>
                                </tr>
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>Name</th>
                                    <th>Additional Price</th>
                                    <th>Image (optional)</th>
                                    <th>Description</th>
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



    <div class="modal modal-default fade" id="productsetup" >
        <div class="modal-dialog" style="width: 800px" >
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">Product Information</h3>
                        </div>
                        <div class="box-body">
                    <form method="post" id="productModal" action="{{url('member/shop/product')}}"  enctype="multipart/form-data">
                        {{csrf_field()}}
                        <input type="hidden" name="_method" value="POST" />
                        <div class="row">
                            <div class="col-md-12">
                                        <input class="hidden" name=prodcode >
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Product Name</label>
                                        <input class="form-control" name=prodname placeholder="Product Name" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Product Base Price</label>
                                        <div class="input-group">
                                            <input type="number" placeholder="0" name="baseprice" class="form-control" required>
                                            <div class="input-group-addon">
                                                <i class="fa fa-money"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Product Type</label>
                                        <select class="form-control productType" name="prodtype" style="width: 100%;" required>
                                            <option selected="selected" value="0" disabled>Please Select Product Type</option>
                                            @foreach($prodType->where('PRODT_PARENT',null) as $item)
                                                <optgroup label="{{$item->PRODT_TITLE}}">
                                                    @foreach($prodType->where('PRODT_PARENT',$item->PRODT_ID) as $item1)
                                                        <option value="{{$item1->PRODT_ID}}">{{$item1->PRODT_TITLE}}</option>
                                                    @endforeach
                                                </optgroup>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>


                                {{--<div class="col-md-6">--}}
                                    {{--<div class="form-group">--}}
                                        {{--<label>Product Size (optional)</label>--}}
                                        {{--<select class="form-control productSize" name=prodsize[] placeholder="Product Size" multiple="multiple"  style="width: 100%;">--}}
                                        {{--<option value="XS">Extra Small</option>--}}
                                        {{--<option value="S">Small</option>--}}
                                        {{--<option value="M">Medium</option>--}}
                                        {{--<option value="L">Large</option>--}}
                                        {{--<option value="XL">Extra Large</option>--}}
                                        {{--</select>--}}
                                        {{--<input type="text" placeholder="Press enter to input sizes" name="prodsize" class="form-control" required>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                                {{--<div class="col-md-12">--}}
                                    {{--<div class="form-group">--}}
                                        {{--<label>Product Color (optional)</label>--}}
                                        {{--<select class="form-control productColor" name="prodcolor[]" multiple="multiple" style="width: 100%;" >--}}
                                            {{--@foreach($dataColor as $item)--}}
                                                {{--<option value="{{$item->hex}}">{{$item->name}}</option>--}}
                                            {{--@endforeach--}}
                                        {{--</select>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Product Image (optional)</label>
                                        <input class="form-control" name=prodimg[] type="file" multiple>
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
                                        <textarea class="form-control" name=prodnote style="resize:vertical; width:100%;height:107px" placeholder="Product Note" required></textarea>
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
    <!-- /.modal -->

    {{--<a href="#productsetup" id="addProduct" class="float" data-toggle="modal"><i class="fa fa-plus my-float"></i></a>--}}
@endsection

@section('extrajs')
    <script>
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');


        // $("input[name='prodsize']").tagsInput({
        //     'height':'28px',
        //     'width':'100%',});
        $("textarea[name='prodnote']").wysihtml5();
        $('.productType').select2();
        // $('.productColor').select2();
        // $('.productSize').select2();



        $("#addVar").on("click",function(){
            $(this).closest('table').find('tbody').append(
                '   <tr>\n' +
                '            <td class=hidden><input  name="prodVarID[]" value="0" class="hidden"></td>\n' +
                '                <td><input type="text" placeholder="Product Variance Name" name="prodvarname[]" class="form-control" required></td>\n' +
                '            <td><div class="input-group">\n' +
                '                <input type="number" placeholder="0" name="addprice[]" class="form-control" required>\n' +
                '            <div class="input-group-addon">\n' +
                '                <i class="fa fa-money"></i>\n' +
                '                </div>\n' +
                '                </div>\n' +
                '                </td>\n' +
                '                <td><input class="form-control" name=prodvarimg[] type="file"></td>\n' +
                '                <td><textarea class="form-control" name=prodvardesc[] style="resize:vertical; width:100%;height:36px" placeholder="Product Description" required></textarea></td>\n' +
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
                            '                <input value="'+$data.data[index].PRODV_ADD_PRICE+'"  type="number" placeholder="0" name="addprice[]" class="form-control" required>\n' +
                            '            <div class="input-group-addon">\n' +
                            '                <i class="fa fa-money"></i>\n' +
                            '                </div>\n' +
                            '                </div>\n' +
                            '                </td>\n' +
                            '                <td><input  class="form-control" name=prodvarimg[] type="file"></td>\n' +
                            '                <td><textarea class="form-control" name=prodvardesc[] style="resize:vertical; width:100%;height:36px" placeholder="Product Description" required>'+$data.data[index].PRODV_DESC+'</textarea></td>\n' +
                            '            <td><a class="btn btn-danger" onclick="if($(\'#prodvartable tbody tr\').length>1)$(this).closest(\'tr\').remove()"><i class="fa fa-minus"></i></a></td>\n' +
                            '            </tr>'
                        );

                    });

                    $('#prodvartable').find('tbody').append(
                        '   <tr>\n' +
                        '            <td class=hidden><input  name="prodVarID[]" value="0" class="hidden"></td>\n' +
                        '                <td><input type="text" placeholder="Product Variance Name" name="prodvarname[]" class="form-control" required></td>\n' +
                        '            <td><div class="input-group">\n' +
                        '                <input type="number" placeholder="0" name="addprice[]" class="form-control" required>\n' +
                        '            <div class="input-group-addon">\n' +
                        '                <i class="fa fa-money"></i>\n' +
                        '                </div>\n' +
                        '                </div>\n' +
                        '                </td>\n' +
                        '                <td><input class="form-control" name=prodvarimg[] type="file"></td>\n' +
                        '                <td><textarea class="form-control" name=prodvardesc[] style="resize:vertical; width:100%;height:36px" placeholder="Product Description" required></textarea></td>\n' +
                        '            <td><a class="btn btn-danger" onclick="if($(\'#prodvartable tbody tr\').length>1)$(this).closest(\'tr\').remove()"><i class="fa fa-minus"></i></a></td>\n' +
                        '   </tr>'
                    );

                }
                ,error:function(){}
            });

        });



        $('#example2').DataTable({
        'paging'      : true,
        'lengthChange': true,
        'searching'   : true,
        'ordering'    : true,
        'info'        : true,
        'autoWidth'   : true,
            'aaSorting': [[ 3, "asc" ]]
        });

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
        $("a[id='addProduct']").on('click',function () {
            $('#productModal').attr('action','{{url('member/shop/product')}}');
            document.querySelector('#productModal').reset();
            // clearSizesTags();
            $("select[name='prodtype']").val(0).trigger('change');
            // $("select[name='prodcolor[]']").val(null).trigger('change');
            $('.modal-title').html('Adding Product');
            $('input[name="prodcode"]').val('PROD-{{ sprintf('%05s',Auth::user()->AFF_ID) }}-{{DB::Table('R_PRODUCT_INFOS')
            ->where('PROD_DISPLAY_STATUS',1)
            ->where('AFF_ID',Auth::user()->AFF_ID)->get()->count()+1}}');$("input[name='_method']").attr('value','POST');
        });
        // function clearSizesTags(){
        //     $.each($("input[name='prodsize']").val().split(','),function(index,value){
        //         $("input[name='prodsize']").removeTag(value);
        //
        //     })
        // }
        $("a[id='editProduct']").on('click',function () {

            document.querySelector('#productModal').reset();
            // clearSizesTags();
            // $("select[name='prodcolor[]']").val(null).trigger('change');
            $("select[name='prodtype']").val(0).trigger('change');

            $('.modal-title').html('Editing Product');
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
                    $("select[name='prodtype']").val($data.data[0].PRODT_ID).trigger('change');
                    $("select[name='prodcolor[]']").val(($data.data[0].PROD_COLOR)?$data.data[0].PROD_COLOR.split(',',2):"").trigger('change');
                    $("input[name='prodsize']").importTags( $data.data[0].PROD_SIZE);
                    $("textarea[name='proddesc']").val($data.data[0].PROD_DESC);
                    var editorObj = $("textarea[name='prodnote']").data('wysihtml5');
                    var editor = editorObj.editor;
                    editor.setValue($data.data[0].PROD_NOTE);
                    $('#productModal').attr('action','{{url('member/shop/product')}}/'+$data.data[0].PROD_ID);
                    $("input[name='_method']").attr('value','PATCH');
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


