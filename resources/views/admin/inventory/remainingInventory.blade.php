@extends('layouts.admin')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Remaining Inventory
                <small>Overview</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-chart-o"></i> Remaining Inventory</a></li>
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
                                    <th style="width: 15%">Total Orders</th>
                                    <th>Total Disposed</th>
                                    <th style="background: #7ff77f;">Total Inventory</th>
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
                                        </td>
                                        <td>
                                            <center>
                                                <strong>
                                                  {{DB::SELECT("SELECT COALESCE(SUM(INV_QTY),0) AS ORDERS FROM R_INVENTORY_INFOS WHERE PROD_ID = $item->PROD_ID AND INV_TYPE='order'")[0]->ORDERS}}
                                                </strong>
                                            </center>

                                        </td>
                                        <td>
                                            <center>
                                                <strong>

                                                    {{DB::SELECT("SELECT COALESCE(SUM(INV_QTY),0) AS DISPOSE FROM R_INVENTORY_INFOS WHERE PROD_ID = $item->PROD_ID AND INV_TYPE='dispose'")[0]->DISPOSE}}
                                                </strong>
                                            </center>
                                        </td>
                                        <td style="background: {{($item->PROD_CRITICAL < ($total=($item->PROD_QTY) +  ((DB::select("SELECT * FROM R_INVENTORY_INFOS WHERE PROD_ID = $item->PROD_ID "))?(DB::select("SELECT SUM(CASE WHEN INV_TYPE ='dispose' THEN -INV_QTY WHEN INV_TYPE='order' THEN -INV_QTY WHEN INV_TYPE='add' THEN INV_QTY END)  as TOTAL FROM R_INVENTORY_INFOS WHERE PROD_ID = $item->PROD_ID ")[0]->TOTAL ):0)+((DB::select("SELECT * FROM t_PRODUCT_VARIANCES WHERE PROD_ID = $item->PROD_ID "))?(DB::select("SELECT SUM(PRODV_QTY) as INV_QTY FROM T_PRODUCT_VARIANCES WHERE PROD_ID = $item->PROD_ID ")[0]->INV_QTY):0)))?'#7ff77f ':'orange' }};">
                                            <center>
                                                    <strong>
                                                        {{$total}}
                                                    </strong>
                                            </center>

                                        </td>

                                        <td title ="{{$item->rAffiliateInfo->AFF_NAME}}"  data-order="{{$item->rAffiliateInfo->AFF_NAME}}">
                                            <center>
                                                <img src="{{ Avatar::create($item->rAffiliateInfo->AFF_NAME)->toBase64() }}" style="height: 40px;">
                                                <br><span style="color: gray;">{{$item->rAffiliateInfo->AFF_NAME}}</span>
                                            </center>
                                        </td>
                                        {{--<td>{{ (new DateTime($item->created_at))->format('D M d, Y | h:i A') }}</td>--}}
                                        <td>
                                            <center>
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
                                                        <li class="divider"></li>
                                                        <li> <a  id='remProdInv' href="#addInventoryModal" data-toggle="modal" vals="{{$item->PROD_ID}}" onclick="$('#addInventoryForm #prodName').val({{$item->PROD_ID}}).trigger('change')">Remove Product</a></li>
                                                        <li> <a  id='remProdVarInv' href="#addInventoryVarModal" data-toggle="modal" vals="{{$item->PROD_ID}}" onclick="$('#addInventoryVarForm #prodName').val({{$item->PROD_ID}}).trigger('change')">Remove Product Variance</a></li>

                                                    </ul>
                                                </div>
                                            </center>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th style="width: 20%">Product Info</th>
                                    <th style="width: 15%">Total Orders</th>
                                    <th>Total Disposed</th>
                                    <th style="background: #7ff77f;">Total Inventory</th>
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
                { extend: 'copy', className: 'btn-sm' ,
                    exportOptions: {
                        columns: [0,1,2,3,4]
                    }
                },
                { extend: 'csv', className: 'btn-sm' ,
                    exportOptions: {
                        columns: [0,1,2,3,4]
                    }
                },
                { extend: 'excel', className: 'btn-sm',
                    exportOptions: {
                        columns: [0,1,2,3,4]
                    }
                },
                { extend: 'pdf', className: 'btn-sm',
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


    </script>
@endsection
