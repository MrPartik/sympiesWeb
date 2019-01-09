
@extends('layouts.admin')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Tax Reference
                <small>Overview</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-tag"></i> Tax Reference</a></li>
            </ol>
        </section>


        <div class="modal modal-default fade" id="taxreferencesetup" >
            <div class="modal-dialog">
                <div class="box box-warning box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">Tax Reference</h3>
                    </div>
                    <div class="box-body">
                        <form method="post" id="taxModal" action="{{url('admin/shop/tax')}}"  enctype="multipart/form-data">
                            {{csrf_field()}}
                            <input type="hidden" name="_method" value="POST" />
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Name</label>
                                            <input class="form-control" name=taxname placeholder="Name" required>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Rate</label>
                                            <input class="form-control" name=taxrate type="number" placeholder="Rate" required>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Type</label>
                                            <select class="form-control " name="taxtype" style="width: 100%;" required>
                                                <option selected="selected"  disabled>Please Select Type</option>
                                                <option value=0 >Percentage</option>
                                                <option value=1 >Fixed</option>

                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Description</label>
                                            <textarea class="form-control" name=taxdesc style="resize:vertical; width:100%;height:107px" placeholder="Description" required></textarea>
                                        </div>
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


        <!-- Main content -->
        <section class="content">
            {{--<div class="row">--}}

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
                    <!-- /.info-box -->
                {{--</div>--}}

            {{--</div>--}}

            <div class="box box-success box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">Tax Reference Setup</h3>

                    <div class="box-tools pull-right">
                        <a href="#taxreferencesetup" id="addTax" class="btn btn-success" data-toggle="modal"><i class="fa fa-plus"></i> Add Item</a>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body" >
                    <div class="row">
                        <div class="col-md-12">
                            <table id="example2" class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th style="width: 30%">Info</th>
                                    <th>Type</th>
                                    <th>Rate</th>
                                    <th>Date Issued</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($tax as $item)
                                    <tr>
                                        {{--<td>{{ $affInfo->where('AFF_ID', $item->AFF_ID)->first()->AFF_NAME }}</td>--}}
                                        <td><strong>{{ $item->TAXP_NAME }}</strong><br><i>{{ $item->TAXP_DESC }}</i> </td>
                                        <td>@if($item->TAXP_TYPE ==0 )Percent @else Fixed @endif </td>
                                        <td>{{ $item->TAXP_RATE  }}</td>
                                        <td>{{ (new DateTime($item->created_at))->format('D M d, Y | h:i A') }}</td>
                                        <td>
                                            <center>
                                                @if($item->TAXP_DISPLAY_STATUS==1)
                                                    <a class="btn btn-info" id='editTax'data-toggle="modal" vals="{{$item->TAXP_ID}}" href="#taxreferencesetup"><i class="fa fa-pencil"></i></a>
                                                    <a id=deact  vals="{{$item->TAXP_ID}}" class="btn btn-danger" data-toggle="modal" data-target="#deactivate"><i class="fa fa-ban"></i></a>
                                                @else
                                                    <a id=act  vals="{{$item->TAXP_ID}}" class="btn btn-success" data-toggle="modal" data-target="#activate"><i class="fa fa-rotate-left"></i></a>
                                                @endif
                                            </center>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                <th style="width: 30%">Info</th>
                                <th>Type</th>
                                <th>Rate</th>
                                <th>Date Issued</th>
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
        $("a[id='addTax']").on('click',function(){
            document.querySelector('#taxModal').reset();
        });
        $("a[id='editTax']").on('click',function () {
            $('.modal-title').html('Editing Tax Reference');
            document.querySelector('#taxModal').reset();
            $id = $(this).attr('vals');
            $.ajax({
                url: 'tax/'+$id
                ,type: 'get'
                ,data: {_token:CSRF_TOKEN }
                ,dataType:'json'
                ,success:function($data){

                    $("input[name='taxname']").val($data.data[0].TAXP_NAME);
                    $("textarea[name='taxdesc']").val($data.data[0].TAXP_DESC);
                    $("select[name='taxtype']").val($data.data[0].TAXP_TYPE).trigger('change');
                    $("input[name='taxrate']").val($data.data[0].TAXP_RATE);
                    $('#taxModal').attr('action','{{url('admin/shop/tax')}}/'+$data.data[0].TAXP_ID);
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
            'autoWidth'   : true,dom: 'Bfrtip'
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


        $("a[id='deact']").on('click',function(){
            $id = $(this).attr('vals');
            // $("button[id='deactSave']").on('click',function () {
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
                        url: '/tax/actDeact'
                        ,type: 'post'
                        ,data: {id:$id,_token:CSRF_TOKEN, type:0  }
                        ,success:function(){
                            window.location.reload();
                        }
                        ,error:function(){

                        }
                    });

                }
            });
            // });
        });

        $("a[id='act']").on('click',function(){
            $id = $(this).attr('vals');
            // $("button[id='actSave']").on('click',function () {

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
                        url: '/tax/actDeact'
                        ,type: 'post'
                        ,data: {id:$id,_token:CSRF_TOKEN, type:1  }
                        ,success:function(){
                            window.location.reload();
                        }
                        ,error:function(){

                        }
                    });
                }
            });

            // });
        });

    </script>
@endsection


