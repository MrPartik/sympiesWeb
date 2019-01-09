@extends('layouts.admin')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Add Inventory
                <small>Overview</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-plus-square-o"></i> Add Inventory</a></li>
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
                            <h3>{{\App\r_product_info::all()->where('PROD_IS_APPROVED','null')->count()}}</h3>

                            <p>Recently Added Inventory</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-plus-square-o"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="small-box bg-aqua-gradient">
                        <div class="inner">
                            <h3>{{\App\r_product_info::all()->where('PROD_IS_APPROVED','null')->count()}}</h3>

                            <p>Remaining Inventory</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-bar-chart-o"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>


            <div class="box box-success box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">Inventory Record</h3>

                    <div class="box-tools pull-right">
                        <a href="#addInventoryModal" id="addInventory" class="btn  btn-outline-success " data-toggle="modal"  ><i class="fa fa-plus-square-o"></i> Add Product Inventory </a>
                        <a href="#addInventoryVarModal" id="addInventory" class="btn btn-warning" data-toggle="modal"><i class="fa fa-plus-square-o"></i> Add Product Variance Inventory </a>
                        <a href="{{url('/product/export')}}" class="btn btn-info" ><i class="fa fa-print"></i> Export Excel</a>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body" >
                    <div class="row">
                        <div class="col-md-12">
                            <table id="inventory" class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th style="width: 20%">Product Info</th>
                                    <th style="width: 15%">Recent Activity in Inventory</th>
                                    <th>Total Inventory</th>
                                    <th>Date Modified</th>
                                    <th>Affiliate</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($prodInfo as $item)
                                    <tr>
                                        <td>
                                            <strong style="margin-bottom:50px">{{ $item->PROD_NAME}}</strong>
                                            <br><i>{{ $item->PROD_DESC }}</i>
                                            <br><i style="color:orangered">Critical Value: {{ $item->PROD_CRITICAL }}</i>
                                            <br>
                                        </td>
                                        <td>
                                            <center>
                                                <strong>
                                                    @if(DB::select("SELECT * FROM R_INVENTORY_INFOS WHERE PROD_ID = $item->PROD_ID "))
                                                        {{DB::select("SELECT CONCAT(INV_QTY, ' ( ',INV_TYPE,' )' ) AS INV_QTY FROM R_INVENTORY_INFOS WHERE PROD_ID = $item->PROD_ID  ORDER BY INV_ID DESC")[0]->INV_QTY}}
                                                    @else
                                                        <i style="color:orangered"> Still no update ({{$item->PROD_QTY }}) </i>
                                                    @endif
                                                </strong>
                                            </center>

                                        </td>

                                        <td>
                                            <center>
                                                    @if($item->PROD_CRITICAL < ($total=($item->PROD_QTY) +  ((DB::select("SELECT * FROM R_INVENTORY_INFOS WHERE PROD_ID = $item->PROD_ID "))?(DB::select("SELECT SUM(CASE WHEN INV_TYPE ='dispose' THEN -INV_QTY WHEN INV_TYPE='order' THEN -INV_QTY WHEN INV_TYPE='add' THEN INV_QTY END)  as TOTAL FROM R_INVENTORY_INFOS WHERE PROD_ID = $item->PROD_ID ")[0]->TOTAL ):0)+((DB::select("SELECT * FROM t_PRODUCT_VARIANCES WHERE PROD_ID = $item->PROD_ID "))?(DB::select("SELECT SUM(PRODV_QTY) as INV_QTY FROM T_PRODUCT_VARIANCES WHERE PROD_ID = $item->PROD_ID ")[0]->INV_QTY):0)) )
                                                        <strong>
                                                            {{$total}}
                                                        </strong>
                                                    @else
                                                        <strong style="color: orangered" >
                                                            {{$total}}
                                                        </strong>
                                                    @endif
                                            </center>

                                        </td>
                                        <td>{{ (new DateTime($item->created_at))->format('D M d, Y | h:i A') }}</td>
                                        <td title ="{{$item->rAffiliateInfo->AFF_NAME}}"  data-order="{{$item->rAffiliateInfo->AFF_NAME}}">
                                            <center>
                                                <img src="{{ Avatar::create($item->rAffiliateInfo->AFF_NAME)->toBase64() }}" style="height: 40px;">

                                                <br><span style="color: gray;">{{$item->rAffiliateInfo->AFF_NAME}}</span>
                                            </center>
                                        </td>
                                        <td>
                                            <center>
                                                @if($item->AFF_ID == Auth::user()->AFF_ID)
                                                <div class="btn-group">
                                                        <a href="#addInventoryModal" data-toggle="modal" class="btn btn-success" id="addInvProd" vals="{{$item->PROD_ID}}" onclick="$('#addInventoryForm #prodName').val({{$item->PROD_ID}}).trigger('change')"><i class="fa fa-plus"></i></a>

                                                        <a href="#addInventoryVarModal" data-toggle="modal" class="btn btn-warning" id="addInvProdVar" vals="{{$item->PROD_ID}}" onclick=" $('#addInventoryVarForm #prodName').val({{$item->PROD_ID}}).trigger('change')" ><i class="fa fa-plus"></i></a>
                                                        <button type="button" class="btn btn-info btn-flat dropdown-toggle" data-toggle="dropdown">
                                                            More
                                                            <span class="caret"></span>
                                                            <span class="sr-only">Toggle Dropdown</span>
                                                        </button>
                                                        <ul class="dropdown-menu" role="menu">
                                                                <li> <a  id='viewProduct' href="#viewProdModal" data-toggle="modal" vals="{{$item->PROD_ID}}" >View</a></li>
                                                                <li> <a  href="{{action('InventoryPageController@show',$item->PROD_ID)}}" >Inventory History</a></li>
                                                                <li class="divider"></li>
                                                                <li> <a  id='remProdInv' href="#addInventoryModal" data-toggle="modal" vals="{{$item->PROD_ID}}" onclick="$('#addInventoryForm #prodName').val({{$item->PROD_ID}}).trigger('change')">Dispose Product</a></li>
                                                                <li> <a  id='remProdVarInv' href="#addInventoryVarModal" data-toggle="modal" vals="{{$item->PROD_ID}}" onclick="$('#addInventoryVarForm #prodName').val({{$item->PROD_ID}}).trigger('change')">Dispose Product Variance</a></li>

                                                        </ul>
                                                </div>
                                                @else
                                                    <a href="{{action('InventoryPageController@show',$item->PROD_ID)}}" class="btn btn-warning" ><i class="fa fa-history"></i></a>
                                                    <a href="#" data-toggle="modal" class="btn btn-danger" id="notifyCritical" vals="{{$item->PROD_ID}}" ><i class="fa fa-envelope"></i></a>
                                                @endif

                                            </center>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th style="width: 20%">Product Info</th>
                                    <th>Recent Activity in Inventory</th>
                                    <th>Total Inventory</th>
                                    <th>Date Modified</th>
                                    <th>Affiliate</th>
                                    <th>Action</th>
                                </tr>
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
        <div class="modal modal-default fade" id="addInventoryModal" >
            <div class="modal-dialog">
                <div id=addInventoryBox class="box box-warning box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">Product Inventory</h3>
                    </div>
                    <div class="box-body">
                        <form method="post" id="addInventoryForm" action="{{url('admin/inventory/add')}}"  enctype="multipart/form-data">
                            {{csrf_field()}}
                            <input type="hidden" name="_method" value="POST" />
                            <input class="hidden" name="prodType" value="0">
                            <input class="hidden" name="type" value="0">
                            <div class="row">
                                <div class="col-md-12">

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Product Name</label>
                                            <select  id=prodName class="form-control" name="prodName" style="width: 100%;"  required>
                                                @foreach($prodInfo->where('PROD_DISPLAY_STATUS',1)->where('AFF_ID',Auth::user()->AFF_ID) as $item)
                                                    <option value="{{$item->PROD_ID}}">{{$item->PROD_NAME}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-12">

                                        <div class="form-group">
                                            <label id="invQTYDesc">Total Number of Item/s to be Added in Inventory*</label>
                                            <div class="input-group">
                                                <input type="number" placeholder="0" name="prodqty" class="form-control" required >
                                                <div class="input-group-addon">
                                                    #
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12" style="padding-bottom: 20px;">
                                        PRODUCT CODE: <strong id="prodCode">Product Code</strong>
                                        <br>PRODUCT DESCRIPTION: <strong id="proddesc">Product Description</strong>
                                        <br>PRODUCT CRITICAL LEVEL: <strong id="prodAlert">Product Alert</strong>
                                    </div>
                                    <!-- /.row -->
                                </div>
                                <div class="col-md-12" >
                                    <div class="pull-right" style="margin-right: 10px;">
                                        <button class="btn btn-success" type="submit" >Save</button>
                                        <a class="btn btn-danger" data-dismiss="modal"> Cancel</a>
                                    </div>
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



        <div class="modal modal-default fade" id="addInventoryVarModal" >
            <div class="modal-dialog" style="width: 700px;"  >
                <div id=addInventoryBox class="box box-warning box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">Product Variance Inventory</h3>
                    </div>
                    <div class="box-body">
                        <form method="post" id="addInventoryVarForm" action="{{url('admin/inventory/add')}}"  enctype="multipart/form-data">
                            {{csrf_field()}}
                            <input type="hidden" name="_method" value="POST" />
                            <input class="hidden" name="prodType" value="1">
                            <input class="hidden" name="type" value="0">
                            <div class="row">
                                <div class="col-md-12">

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Product Name</label>
                                            <select  id=prodName class="form-control" name="prodName" style="width: 100%;"  required>
                                                @foreach($prodInfo->where('PROD_DISPLAY_STATUS',1)->where('AFF_ID',Auth::user()->AFF_ID) as $item)
                                                    <option value="{{$item->PROD_ID}}">{{$item->PROD_NAME}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12">

                                        <label id="invQTYDesc">Total Number of Item/s to be Added in Inventory*</label>
                                        <table id="prodvartable" class="table table-bordered table-hover">
                                            <thead>
                                            <tr>
                                                <th>Name*</th>
                                                <th>Stock Qty (null value means no action to be taken)</th>
                                                <th>Initial Qty</th>
                                            </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                            <tfoot>
                                            <tr>
                                                <th>Name</th>
                                                <th>Stock Qty</th>
                                                <th>Initial Qty</th>
                                            </tr>
                                            </tfoot>
                                        </table>
                                    </div>



                                    <div class="col-md-12" style="padding-bottom: 20px;">
                                        PRODUCT CODE: <strong id="prodCode">Product Code</strong>
                                        <br>PRODUCT DESCRIPTION: <strong id="proddesc">Product Description</strong>
                                        <br>PRODUCT CRITICAL LEVEL: <strong id="prodAlert">Product Alert</strong>
                                    </div>
                                    <!-- /.row -->
                                </div>
                                <div class="col-md-12" >
                                    <div class="pull-right" style="margin-right: 10px;">
                                        <button class="btn btn-success" type="submit" >Save</button>
                                        <a class="btn btn-danger" data-dismiss="modal"> Cancel</a>
                                    </div>
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
    </div>
    <!-- /.content-wrapper -->
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

    $('#inventory').DataTable({
            dom: 'Bfrtip',
            'paging'      : true,
            'lengthChange': true,
            'searching'   : true,
            'ordering'    : true,
            'info'        : true,
            'autoWidth'   : true,
            "aaSorting": [[ 4, "desc" ]]
            ,   buttons: [
                { extend: 'copy', className: 'btn-sm',
                    exportOptions: {
                        columns: [0,1,2,3,4]
                    }
                },
                { extend: 'csv', className: 'btn-sm',
                    exportOptions: {
                        columns: [0,1,2,3,4]
                    }
                },
                { extend: 'excel', className: 'btn-sm' ,
                    exportOptions: {
                        columns: [0,1,2,3,4]
                    }
                },
                { extend: 'pdf', className: 'btn-sm' ,
                    exportOptions: {
                        columns: [0,1,2,3,4]
                    }
                },
                { extend: 'print', className: 'btn-sm',
                    exportOptions: {
                        columns: [0,1,2,3,4]
                    }
                }
            ],
            responsive: true
    });


    $("a[id=addInvProdVar]").on('click',function(){
        $id = $(this).attr('vals');
        showProdInfo($id);
        $("div[id=addInventoryBox]").removeClass("box-danger");
        $("div[id=addInventoryBox]").addClass("box-warning");
        $("label[id=invQTYDesc]").html("Total Number of Item/s to be Added in Inventory*");
        $("input[name='prodqty']").val(null);
        $("strong[id='prodCode']").html("");
        $("strong[id='proddesc']").html("");
        $("strong[id='prodAlert']").html("");

    });

    $("a[id=addInvProd]").on('click',function(){
        $id = $(this).attr('vals');
        showProdInfo($id);
        $("div[id=addInventoryBox]").removeClass("box-danger");
        $("div[id=addInventoryBox]").addClass("box-warning");
        $("input[name=type]").val(0);
        $("label[id=invQTYDesc]").html("Total Number of Item/s to be Added in Inventory*");
        $("input[name='prodqty']").val(null);
        $("strong[id='prodCode']").html("");
        $("strong[id='proddesc']").html("");
        $("strong[id='prodAlert']").html("");

    });


    $("a[id=addInventory]").on('click',function (){

        $("div[id=addInventoryBox]").removeClass("box-danger");
        $("div[id=addInventoryBox]").addClass("box-warning");
        $("input[name=type]").val(0);
        $("label[id=invQTYDesc]").html("Total Number of Item/s to be Added in Inventory*");
        $("select[name='prodName']").val(null).trigger('change');
        $("input[name='prodqty']").val(null);
        $("strong[id='prodCode']").html("")
        $("strong[id='proddesc']").html("");
        $("strong[id='prodAlert']").html("");
    });


    $("a[id=remProdVarInv]").on('click',function(){
        $("div[id=addInventoryBox]").removeClass("box-warning");
        $("div[id=addInventoryBox]").addClass("box-danger");
        $("input[name=type]").val(1);
        $("label[id=invQTYDesc]").html("Total Number of Item/s to be Removed in Inventory");
    });

    $("a[id=remProdInv]").on('click',function(){
        $("div[id=addInventoryBox]").removeClass("box-warning");
        $("div[id=addInventoryBox]").addClass("box-danger");
        $("input[name=type]").val(1);
        $("label[id=invQTYDesc]").html("Total Number of Item/s to be Removed in Inventory");
    });


    $('select[name=prodName]').select2({
        placeholder: "Please Select Product",
        allowClear: true
    });

    $('select[name=prodName]').on('change',function(){
        $id = $(this).val();
        showProdInfo($id)
    });

    function showProdInfo($id){
        $.ajax({
            url: '/product/showInfo/'+$id
            ,type: 'get'
            ,data: {_token:CSRF_TOKEN }
            ,dataType:'json'
            ,success:function($data){
                $("strong[id='prodCode']").html($data.data[0].PROD_CODE);
                $("strong[id='proddesc']").html($data.data[0].PROD_DESC);
                $("strong[id='prodAlert']").html($data.data[0].PROD_CRITICAL);
            }
            ,error:function(){

            }
        });
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
                        '            <td class=hidden><input  name="prodVarID[]" value="'+$data.data[index].PRODV_ID+'" class="hidden"></td>\n' +
                        '            <td><strong>'+$data.data[index].PRODV_NAME+'</strong></td>\n' +
                        '            <td><div class="input-group">\n' +
                        '                <input  type="number" placeholder="0" name="inv_qty[]" class="form-control">\n' +
                        '            <div class="input-group-addon">\n' +
                        '                #\n' +
                        '                </div>\n' +
                        '                </div>\n' +
                        '            </td>\n' +
                        '            <td>'+$data.data[index].PRODV_QTY+'</td>\n'+
                        '   </tr>'
                    );

                });

            }
            ,error:function(){}
        });
    }
    $("a[id=notifyCritical]").on('click',function(){
       alert("notify");
    });

</script>
@endsection
