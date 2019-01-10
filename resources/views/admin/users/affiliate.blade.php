
@extends('layouts.admin')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Affiliates Management
                <small>Overview</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-shield"></i> Affiliates Management</a></li>
            </ol>
        </section>


        <div class="modal modal-default fade" id="affsetup" >
            <div class="modal-dialog">
                <div class="box box-warning box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">Affiliates Management</h3>
                    </div>
                    <div class="box-body">
                        <form method="post" id="affModal" action="{{url('admin/users/affiliate')}}"  enctype="multipart/form-data">
                            {{csrf_field()}}
                            <input type="hidden" name="_method" value="POST" />
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Name</label>
                                            <input class="form-control" name=affname placeholder="Name" required>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Code</label>
                                            <input class="form-control" name=code type="text" placeholder="Code" required>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Payment Mode</label>
                                            <input class="form-control" name=paymentmode type="text" placeholder="Payment Mode" required>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Payment Instruction</label>
                                            <textarea class="form-control" name=paymentinst style="resize:vertical; width:100%;height:107px" placeholder="Payment Instruction" required></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Description</label>
                                            <textarea class="form-control" name=desc style="resize:vertical; width:100%;height:107px" placeholder="Affiliate Description" required></textarea>
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


        @foreach($aff as $item)

            <div class="modal modal-default fade" id="hasUser{{$item->AFF_ID }}" >
                <div class="modal-dialog" style="width: 1000px" >
                    <div class="box box-info box-solid">
                        <div class="box-header with-border">
                            <h3 class="box-title">{{$item->AFF_NAME}}</h3>
                        </div>
                        <div class="box-body">
                            <div class="col-lg-12">
                                <table id="example2" class="table table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th style="width: 30%">Name</th>
                                        <th>Email</th>
                                        <th>Date Issued</th>
                                        <th>Role</th>
                                        <th>Status</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($user->where('AFF_ID',$item->AFF_ID) as $item1)
                                        <tr>
                                            <td><strong>{{ $item1->name }}</strong></td>
                                            <td>{{$item1->email}}</td>
                                            <td>{{ (new DateTime($item1->created_at))->format('D M d, Y | h:i A') }}</td>
                                            <td>{{ $item1->role}}</td>
                                            <td>{{ ($item1->USER_DisplayStat==0)?'Inactive':'Active'}}</td>

                                        </tr>
                                    @endforeach
                                    </tbody>
                                    <tfoot>
                                        <th style="width: 30%">Name</th>
                                        <th>Email</th>
                                        <th>Date Issued</th>
                                        <th>Role</th>
                                        <th>Status</th>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        <div id="overlay" class="overlay" style="display:none">
                            <i class="fa fa-refresh fa-spin"></i>
                        </div>
                    </div>
                </div>
            </div>

    @endforeach


    <!-- Main content -->
        <section class="content">


            <div class="box box-success box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">Affiliates Setup</h3>

                    <div class="box-tools pull-right">
                        <a href="#affsetup" id="addTax" class="btn btn-success" data-toggle="modal"><i class="fa fa-plus"></i> Add Item</a>
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
                                    <th>Code</th>
                                    <th>Payment Mode</th>
                                    <th>Date Issued</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($aff as $item)
                                    <tr>
                                        <td><strong>{{ $item->AFF_NAME }}</strong><br><i>{{ $item->AFF_COD }}</i> </td>
                                        <td>{{$item->AFF_CODE}}</td>
                                        <td>{{ $item->AFF_PAYMENT_MODE   }}</td>
                                        <td>{{ (new DateTime($item->created_at))->format('D M d, Y | h:i A') }}</td>
                                        <td>
                                            <center>
                                                @if(!is_null($user->where('AFF_ID',$item->AFF_ID)->first()))
                                                    <a class="btn btn-success"  data-toggle="modal" vals="{{$item->AFF_ID }}" href="#hasUser{{$item->AFF_ID }}"><i class="fa fa-user"></i></a>

                                                @endif
                                                @if($item->AFF_DISPLAY_STATUS ==1)
                                                    <a class="btn btn-info" id='editTax'data-toggle="modal" vals="{{$item->AFF_ID }}" href="#affsetup"><i class="fa fa-pencil"></i></a>
                                                    <a id=deact  vals="{{$item->AFF_ID }}" class="btn btn-danger" data-toggle="modal" data-target="#deactivate"><i class="fa fa-ban"></i></a>
                                                @else
                                                    <a id=act  vals="{{$item->AFF_ID }}" class="btn btn-success" data-toggle="modal" data-target="#activate"><i class="fa fa-rotate-left"></i></a>
                                                @endif
                                            </center>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                <th style="width: 30%">Info</th>
                                <th>Code</th>
                                <th>Payment Mode</th>
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
            document.querySelector('#affModal').reset();
        });
        $("a[id='editTax']").on('click',function () {
            $('.modal-title').html('Editing Tax Reference');
            document.querySelector('#affModal').reset();
            $id = $(this).attr('vals');
            $.ajax({
                url: '/admin/users/affiliate/'+$id
                ,type: 'get'
                ,data: {_token:CSRF_TOKEN }
                ,dataType:'json'
                ,success:function($data){

                    $("input[name='affname']").val($data.data[0].AFF_NAME);
                    $("textarea[name='desc']").val($data.data[0].AFF_DESC);
                    $("textarea[name='paymentinst']").val($data.data[0].AFF_PAYMENT_INSTRUCTION);
                    $("input[name='paymentmode']").val($data.data[0].AFF_PAYMENT_MODE);
                    $("input[name='code']").val($data.data[0].AFF_CODE);
                    $('#affModal').attr('action','{{url('admin/users/affiliate')}}/'+$data.data[0].AFF_ID);
                    $("input[name='_method']").attr('value','PATCH');
                }
                ,error:function(){

                }
            });

        });

        $('table[id=example2]'  ).DataTable({
            'paging'      : true,
            'lengthChange': true,
            'searching'   : true,
            'ordering'    : true,
            'info'        : true,
            'autoWidth'   : true,dom: 'Bfrtip'
            ,   buttons: [
                { extend: 'copy', className: 'btn-sm',
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
                        url: '/affiliate/actDeact'
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
                        url: '/affiliate/actDeact'
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


