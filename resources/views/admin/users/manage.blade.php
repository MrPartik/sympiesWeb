
@extends('layouts.admin')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                User Management
                <small>Overview</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-users"></i> User Management</a></li>
            </ol>
        </section>


        <div class="modal modal-default fade" id="usersetup" >
            <div class="modal-dialog">
                <div class="box box-warning box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">User Management</h3>
                    </div>
                    <div class="box-body">
                        <form method="post" id="userModal" action="{{url('admin/users/manage')}}"  enctype="multipart/form-data">
                            {{csrf_field()}}
                            <input type="hidden" name="_method" value="POST" />
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Name</label>
                                            <input class="form-control" name=name placeholder="Name" required>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Email</label>
                                            <input class="form-control" name=email type="text" placeholder="Email" required>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Password</label>
                                            <input class="form-control" name=password type="password" placeholder="Password" required>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Register Affiliate </label>
                                            <select class="form-control " name="affiliates" style="width: 100%;" required>
                                                <option selected="selected"  disabled>Please Select Affiliate</option>
                                                @foreach($aff as $item)
                                                    <option value={{$item->AFF_ID}} >{{$item->AFF_NAME}}</option>
                                                @endforeach

                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Role </label>
                                            <select class="form-control " name="role" style="width: 100%;" required>
                                                <option selected="selected"  disabled>Please Select Role</option>
                                                <option value="admin">Admin</option>
                                                <option value="member">Member</option>
                                            </select>
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


            <div class="box box-success box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">User Setup</h3>

                    <div class="box-tools pull-right">
                        <a href="#usersetup" id="addUser" class="btn btn-success" data-toggle="modal"><i class="fa fa-plus"></i> Add Item</a>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body" >
                    <div class="row">
                        <div class="col-md-12">
                            <table id="example2" class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th style="width: 30%">Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Date Issued</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($user as $item)
                                    <tr>
                                        <td><strong>{{ $item->name }}</strong> </td>
                                        <td>{{$item->email}}</td>
                                        <td>{{ $item->role}}</td>
                                        <td>{{ (new DateTime($item->created_at))->format('D M d, Y | h:i A') }}</td>
                                        <td>
                                            <center>

                                                @if($item->USER_DisplayStat ==1)
                                                    <a class="btn btn-info" id='editUser'data-toggle="modal" vals="{{$item->id }}" href="#usersetup"><i class="fa fa-pencil"></i></a>
                                                    <a id=deact  vals="{{$item->id }}" class="btn btn-danger" data-toggle="modal" data-target="#deactivate"><i class="fa fa-ban"></i></a>
                                                @else
                                                    <a id=act  vals="{{$item->id }}" class="btn btn-success" data-toggle="modal" data-target="#activate"><i class="fa fa-rotate-left"></i></a>
                                                @endif
                                            </center>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                    <th style="width: 30%">Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
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


        $('select[name=affiliates]').select2();
        $('select[name=role]').select2();
        $("a[id='addUser']").on('click',function(){
            document.querySelector('#userModal').reset();
            $("input[name='password']").attr('required','required');
        });
        $("a[id='editUser']").on('click',function () {
            document.querySelector('#userModal').reset();
            $id = $(this).attr('vals');
            $.ajax({
                url: '/admin/users/manage/'+$id
                ,type: 'get'
                ,data: {_token:CSRF_TOKEN }
                ,dataType:'json'
                ,success:function($data){

                    $("input[name='name']").val($data.data[0].name);
                    $("input[name='email']").val($data.data[0].email);
                    $("input[name='password']").removeAttr('required');
                    $("select[name='affiliates']").val($data.data[0].AFF_ID).trigger('change');
                    $("select[name='role']").val($data.data[0].role).trigger('change');
                    $("input[name='code']").val($data.data[0].AFF_CODE);
                    $('#userModal').attr('action','{{url('admin/users/manage')}}/'+$data.data[0].id);
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
                        url: '/user/manage/actDeact'
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
                        url: '/user/manage/actDeact'
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


