@extends('layouts.admin')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                History Inventory
                <small>Overview</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-plus-square-o"></i> History Inventory</a></li>
            </ol>
        </section>
        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="small-box bg-purple-gradient">
                        <div class="inner">
                            <h3>{{DB::SELECT("SELECT COALESCE(SUM(INV_QTY),0) AS ORDERS FROM R_INVENTORY_INFOS WHERE PROD_ID = $id AND INV_TYPE='order'")[0]->ORDERS}}</h3>

                            <p>Total Orders</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-android-cart"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="small-box bg-red-gradient">
                        <div class="inner">
                            <h3>{{DB::SELECT("SELECT COALESCE(SUM(INV_QTY),0) AS DISPOSE FROM R_INVENTORY_INFOS WHERE PROD_ID = $id AND INV_TYPE='dispose'")[0]->DISPOSE}}</h3>

                            <p>Total Disposed</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-minus"></i>
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

                    <h3 class="box-title">( {{$prodInfo->PROD_NAME}} ) History Inventory Record</h3>
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
                                    <th >Date Modified</th>
                                    <th >Inventory Add</th>
                                    <th>Inventory Dispose</th>
                                    <th>Order</th>
                                    <th>Remaining Inventory</th>
                                    {{--<th>Action</th>--}}
                                </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $totalAdd = 0;
                                        $totalDispose = 0;
                                        $totalOrder = 0;
                                    @endphp

                                    @if($invInfo->where('PROD_ID',$id)!="[]")
                                @foreach($invInfo as $item)
                                    @php
                                        $totalAdd += ($invAdd = DB::SELECT("SELECT COALESCE(INV_QTY,0) AS ADDD FROM R_INVENTORY_INFOS WHERE INV_ID = $item->INV_ID AND INV_TYPE='ADD'"))?$invAdd[0]->ADDD:'0';
                                        $totalDispose += ($invDispose = DB::SELECT("SELECT COALESCE(INV_QTY,0) AS DISPOSE FROM R_INVENTORY_INFOS WHERE INV_ID = $item->INV_ID AND INV_TYPE='DISPOSE'"))?$invDispose[0]->DISPOSE:'0';
                                        $totalOrder += ($invOrder = DB::SELECT("SELECT COALESCE(INV_QTY,0) AS ORDERR FROM R_INVENTORY_INFOS WHERE INV_ID = $item->INV_ID AND INV_TYPE='ORDER'"))?$invOrder[0]->ORDERR:'0';
                                    @endphp
                                    @if($item->INV_TYPE == 'CAPITAL')
                                        <td data-order="{{$item->INV_ID}}">
                                            {{ (new DateTime($item->created_at))->format('D M d, Y | h:i A') }}
                                        </td>
                                        <td colspan="4">
                                            <strong>
                                                <center>
                                                 <b>{{ DB::SELECT("SELECT COALESCE(INV_QTY,0) AS CAPITAL FROM R_INVENTORY_INFOS WHERE INV_ID = $item->INV_ID AND INV_TYPE='CAPITAL'")[0]->CAPITAL }}</b>

                                                </center>
                                            </strong>
                                        </td>
                                    @endif
                                    <tr>
                                        <td data-order="{{$item->INV_ID}}">
                                                {{ (new DateTime($item->created_at))->format('D M d, Y | h:i A') }}
                                        </td>

                                        <td>
                                            <center>
                                                <strong>
                                                    {{  ($invAdd = DB::SELECT("SELECT COALESCE(INV_QTY,0) AS ADDD FROM R_INVENTORY_INFOS WHERE INV_ID = $item->INV_ID AND INV_TYPE='add'"))?$invAdd[0]->ADDD:'0' }}
                                                </strong>
                                            </center>

                                        </td>
                                        <td>
                                            <center>
                                                <strong>
                                                    {{  ($invDispose = DB::SELECT("SELECT COALESCE(INV_QTY,0) AS DISPOSE FROM R_INVENTORY_INFOS WHERE INV_ID = $item->INV_ID AND INV_TYPE='dispose'"))?$invDispose[0]->DISPOSE:'0' }}
                                                </strong>
                                            </center>
                                        </td>
                                        <td  >
                                            <center>
                                                <strong>
                                                    {{ ($invOrder = DB::SELECT("SELECT COALESCE(INV_QTY,0) AS ORDERR FROM R_INVENTORY_INFOS WHERE INV_ID = $item->INV_ID AND INV_TYPE='order'"))?$invOrder[0]->ORDERR:'0' }}
                                                </strong>
                                            </center>
                                        </td>
                                        <td>
                                            <center>
                                                <strong>
{{--                                                    {{$item}}--}}
                                                    {{--{{ ($item->PRODV_ID !=NULL)?$item->tProductVariance->PRODV_QTY:0  }}--}}
                                                        @php
                                                            $totalVariance = ((DB::select("SELECT * FROM t_PRODUCT_VARIANCES WHERE PROD_ID = $item->PROD_ID "))?(DB::select("SELECT SUM(PRODV_QTY) as INV_QTY FROM T_PRODUCT_VARIANCES WHERE PROD_ID = $item->PROD_ID ")[0]->INV_QTY):0);
                                                            $totalProduct =$item->rProductInfo->PROD_QTY;
                                                        @endphp
                                                    {{($totalVariance+ $totalProduct + $totalAdd ) - ($totalDispose+$totalOrder)}}
                                                </strong>
                                            </center>
                                        </td>
                                        {{--<td>--}}
                                            {{--<center>--}}

                                            {{--</center>--}}
                                        {{--</td>--}}
                                    </tr>
                                @endforeach
                                    @else
                                        <td colspan="5">
                                            <strong>
                                                <center>
                                                    <i style="color:orangered"> Still no update ({{$prodInfo->PROD_QTY }}) </i>

                                                </center>
                                            </strong>
                                        </td>
                                    @endif

                                </tbody>
                                <tfoot>
                                <tr>
                                    <th >Date Modified</th>
                                    <th >Inventory Add</th>
                                    <th>Inventory Dispose</th>
                                    <th>Order</th>
                                    <th>Remaining Inventory</th>
                                    {{--<th>Action</th>--}}
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
            <!-- /.box -->
            </div>
        </section>
    </div>

        <!-- /.content -->

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
            'searching'   : false,
            'ordering'    : false,
            'info'        : true,
            'autoWidth'   : true,
            "iDisplayLength": 100,
            "aaSorting": [[ 0, "desc" ]],
            buttons: [
            { extend: 'copy', className: 'btn-sm' },
            { extend: 'csv', className: 'btn-sm' },
            { extend: 'excel', className: 'btn-sm' },
            { extend: 'pdf', className: 'btn-sm' },
            { extend: 'print', className: 'btn-sm' }
        ],
        });




    </script>
@endsection
