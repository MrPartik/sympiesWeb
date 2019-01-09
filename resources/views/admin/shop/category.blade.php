
@extends('layouts.admin')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Product Category
                <small>Overview</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-tag"></i> Product Category</a></li>
            </ol>
        </section>


        <div class="modal modal-default fade" id="prodcatsetup" >
            <div class="modal-dialog">
                <div class="box box-warning box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">Product Category</h3>
                    </div>
                    <div class="box-body">
                        <form method="post" id="prodtCatForm" action="{{url('admin/shop/category')}}"  enctype="multipart/form-data">
                            {{csrf_field()}}
                            <input type="hidden" name="_method" value="POST" />
                            <input class="hidden" name="type" value="0">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Title</label>
                                            <input class="form-control" name=prodttitle placeholder="Name" required>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Description</label>
                                            <textarea class="form-control" name=prodtdesc style="resize:vertical; width:100%;height:107px" placeholder="Description" required></textarea>
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

<div class="modal modal-default fade" id="prodsubcat" >
            <div class="modal-dialog">
                <div class="box box-warning box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">Product Sub-Category</h3>
                    </div>
                    <div class="box-body">
                        <form method="post" id="prodtSubCatForm" action="{{url('admin/shop/category')}}"  enctype="multipart/form-data">
                            {{csrf_field()}}
                            <input type="hidden" name="_method" value="POST" />
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Title</label>
                                            <input class="form-control" name=prodttitle placeholder="Name" required>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Description</label>
                                            <textarea class="form-control" name=prodtdesc style="resize:vertical; width:100%;height:107px" placeholder="Description" required></textarea>
                                        </div>
                                    </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Product Parent (optional)</label>
                                        <select class="form-control prodParent" name="prodparent" style="width: 100%;" >
                                            @foreach($cat->where('PRODT_PARENT',null)->where('PRODT_DISPLAY_STATUS',1)   as $item)
                                                <option value="{{$item->PRODT_ID}}">{{$item->PRODT_TITLE}}</option>
                                            @endforeach
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
            <div class="row">
        <div class="col-md-12">
            <div class="box box-success box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">Product Category</h3>

                    <div class="box-tools pull-right">
                        <a href="#prodcatsetup" id="addProduct" class="btn btn-sucess" data-toggle="modal"><i class="fa fa-plus-square-o"></i> Add Category</a>
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i> </button>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body" >
                    <div class="row">
                        <div class="col-md-12">
                            <table id="tableCat" class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th style="width: 30%">Info</th>
                                    <th>Sub-Categories</th>
                                    <th>Date Issued</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($cat->where('PRODT_PARENT',null) as $item)
                                    <tr>
                                        {{--<td>{{ $affInfo->where('AFF_ID', $item->AFF_ID)->first()->AFF_NAME }}</td>--}}
                                        <td><strong>{{ $item->PRODT_TITLE }}</strong><br><i>{{ $item->PRODT_DESC }}</i></td>
                                        <td><center>
                                                @foreach($cat->where('PRODT_PARENT',$item->PRODT_ID) as $sub)
                                                    @if($sub->PRODT_DISPLAY_STATUS==1)
                                                        <label class="label label-primary">{{$sub->PRODT_TITLE}}</label>
                                                    @else
                                                        <label class="label label-danger">{{$sub->PRODT_TITLE}}</label>
                                                    @endif
                                                @endforeach
                                            </center>
                                        </td>
                                        <td>{{ (new DateTime($item->updated_at))->format('D M d, Y | h:i A') }}</td>
                                        <td>
                                            <center>
                                                @if($item->PRODT_DISPLAY_STATUS==1)
                                                    <a class="btn btn-info" id='editCat'data-toggle="modal" vals="{{$item->PRODT_ID}}" href="#prodcatsetup"><i class="fa fa-pencil"></i></a>
                                                    <a id=deact  vals="{{$item->PRODT_ID}}" class="btn btn-danger" data-toggle="modal" data-target="#deactivate"><i class="fa fa-ban"></i></a>
                                                @else
                                                    <a id=act  vals="{{$item->PRODT_ID}}" class="btn btn-success" data-toggle="modal" data-target="#activate"><i class="fa fa-rotate-left"></i></a>
                                                @endif
                                            </center>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                <th style="width: 30%">Info</th>
                                <th>Sub-Categories</th>
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
        </div>
                <div class="col-md-12">
                    <div class="box box-primary box-solid">
                        <div class="box-header with-border">
                            <h3 class="box-title">Product Sub-Category</h3>

                            <div class="box-tools pull-right">
                                <a href="#prodsubcat" id="addProduct" class="btn btn-primary" data-toggle="modal"><i class="fa fa-plus-square-o"></i> Add Sub-Category</a>
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i> </button>
                            </div>
                            <!-- /.box-tools -->
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                           <div class="row">
                               <div class="col-md-12">
                                   <table id="tablesubCat" class="table table-bordered table-hover">
                                       <thead>
                                       <tr>
                                           <th style="width: 30%">Info</th>
                                           <th>Parent Category</th>
                                           <th>Date Issued</th>
                                           <th>Action</th>
                                       </tr>
                                       </thead>
                                       <tbody>
                                       @foreach($cat->where('PRODT_PARENT','!=',null) as $item)
                                           <tr>
                                               {{--<td>{{ $affInfo->where('AFF_ID', $item->AFF_ID)->first()->AFF_NAME }}</td>--}}
                                               <td><strong>{{ $item->PRODT_TITLE }}</strong><br><i>{{ $item->PRODT_DESC }}</i></td>
                                               <td>
                                                   <center>
                                                       @if($item->rProductType->PRODT_DISPLAY_STATUS==1)
                                                           <label class="label label-success">{{$item->rProductType->PRODT_TITLE}}</label>
                                                       @else
                                                           <label class="label label-danger">{{$item->rProductType->PRODT_TITLE}}</label>
                                                       @endif
                                                   </center>
                                               </td>
                                               <td>{{ (new DateTime($item->updated_at))->format('D M d, Y | h:i A') }}</td>
                                               <td>
                                                   <center>
                                                       @if($item->PRODT_DISPLAY_STATUS==1)
                                                           <a class="btn btn-info" id='editsubCat'data-toggle="modal" vals="{{$item->PRODT_ID}}" href="#prodsubcat"><i class="fa fa-pencil"></i></a>
                                                           <a id=deact  vals="{{$item->PRODT_ID}}" class="btn btn-danger" data-toggle="modal" data-target="#deactivate"><i class="fa fa-ban"></i></a>
                                                       @else
                                                           <a id=act  vals="{{$item->PRODT_ID}}" class="btn btn-success" data-toggle="modal" data-target="#activate"><i class="fa fa-rotate-left"></i></a>
                                                       @endif
                                                   </center>
                                               </td>
                                           </tr>
                                       @endforeach
                                       </tbody>
                                       <tfoot>
                                       <th style="width: 30%">Info</th>
                                       <th>Parent Category</th>
                                       <th>Date Issued</th>
                                       <th>Action</th>
                                       </tfoot>
                                   </table>
                               </div>
                           </div>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </div>
                <!-- /.col -->
            </div>


        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->



@endsection

@section('extrajs')
    <script>

        $('.prodParent').select2();
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

        $("a[id='addProduct']").on('click',function(){
            document.querySelector('#prodtCatForm').reset();
            document.querySelector('#prodtSubCatForm').reset();
            $("input[name='_method']").attr('value','POST');

        });
        $("a[id='editCat']").on('click',function () {
            document.querySelector('#prodtCatForm').reset();
            document.querySelector('#prodtSubCatForm').reset();
            $id = $(this).attr('vals');
            $.ajax({
                url: '/admin/shop/category/'+$id
                ,type: 'get'
                ,data: {_token:CSRF_TOKEN }
                ,dataType:'json'
                ,success:function($data){

                    $("input[name='prodttitle']").val($data.data[0].PRODT_TITLE);
                    $("textarea[name='prodtdesc']").val($data.data[0].PRODT_DESC);
                    $('form').attr('action','{{url('admin/shop/category')}}/'+$data.data[0].PRODT_ID);
                    $("input[name='_method']").attr('value','PATCH');
                }
                ,error:function(){

                }
            });

        });



        $("a[id='editsubCat']").on('click',function () {
            document.querySelector('#prodtCatForm').reset();
            document.querySelector('#prodtSubCatForm').reset();
            $id = $(this).attr('vals');
            $.ajax({
                url: '/admin/shop/category/'+$id
                ,type: 'get'
                ,data: {_token:CSRF_TOKEN }
                ,dataType:'json'
                ,success:function($data){

                    $("input[name='prodttitle']").val($data.data[0].PRODT_TITLE);
                    $("textarea[name='prodtdesc']").val($data.data[0].PRODT_DESC);
                    $("select[name='prodparent']").val($data.data[0].PRODT_PARENT).trigger('change');
                    $('form').attr('action','{{url('admin/shop/category')}}/'+$data.data[0].PRODT_ID);
                    $("input[name='_method']").attr('value','PATCH');
                }
                ,error:function(){

                }
            });

        });

        $('table#tableCat, table#tablesubCat').DataTable({
            'paging'      : true,
            'lengthChange': true,
            'searching'   : true,
            'ordering'    : true,
            'info'        : true,
            'autoWidth'   : true
            ,dom: 'Bfrtip'
            ,   buttons: [
                { extend: 'copy', className: 'btn-sm' ,
                    exportOptions: {
                        columns: [0,1,2]
                    }
                },
                { extend: 'csv', className: 'btn-sm'  ,
                    exportOptions: {
                        columns: [0,1,2]
                    }
                },
                { extend: 'excel', className: 'btn-sm'  ,
                    exportOptions: {
                        columns: [0,1,2]
                    }
                },
                { extend: 'pdf', className: 'btn-sm'  ,
                    exportOptions: {
                        columns: [0,1,2]
                    }
                },
                { extend: 'print', className: 'btn-sm'  ,
                    exportOptions: {
                        columns: [0,1,2]
                    }
                }
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
                        url: '/category/actDeact'
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
                        url: '/category/actDeact'
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


