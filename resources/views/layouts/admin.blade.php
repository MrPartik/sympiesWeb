<!Doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{config('app.name')}} | {{Request::route()->getName()}}</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    @include('includes.css')
</head>
<body class="hold-transition skin-green fixed sidebar-mini loading">
<div class="wrapper">

    <header class="main-header">
        <!-- Logo -->
        <a href="#" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"><img src="{{ Avatar::create('Sympies')->toBase64() }}" style="height: 40px;"></span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg"><b>Sympies</b></span>
        </a>

        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>
            <!-- Navbar Right Menu -->
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <!-- Messages: style can be found in dropdown.less-->
                    <li class="dropdown messages-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-envelope-o"></i>
                            <span class="label label-success">4</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="header">You have 4 messages</li>
                            <li>
                                <!-- inner menu: contains the actual data -->
                                <ul class="menu">
                                    <li><!-- start message -->
                                        <a href="#">
                                            <div class="pull-left">
                                                <img src="{{ Avatar::create(Auth::user()->name)->toBase64() }}" class="img-circle"
                                                     alt="User Image">
                                            </div>
                                            <h4>
                                                Support Team
                                                <small><i class="fa fa-clock-o"></i> 5 mins</small>
                                            </h4>
                                            <p>Why not buy a new awesome theme?</p>
                                        </a>
                                    </li>
                                    <!-- end message -->
                                </ul>
                            </li>
                            <li class="footer"><a href="#">See All Messages</a></li>
                        </ul>
                    </li>
                    <!-- Notifications: style can be found in dropdown.less -->
                    <li class="dropdown notifications-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-bell-o"></i>
                            <span class="label label-warning">10</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="header">You have 10 notifications</li>
                            <li>
                                <!-- inner menu: contains the actual data -->
                                <ul class="menu">
                                    <li>
                                        <a href="#">
                                            <i class="fa fa-users text-aqua"></i> 5 new members joined today
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="footer"><a href="#">View all</a></li>
                        </ul>
                    </li>
                    <!-- Tasks: style can be found in dropdown.less -->
                    <li class="dropdown tasks-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-flag-o"></i>
                            <span class="label label-danger">9</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="header">You have 9 tasks</li>
                            <li>
                                <!-- inner menu: contains the actual data -->
                                <ul class="menu">
                                    <li><!-- Task item -->
                                        <a href="#">
                                            <h3>
                                                Design some buttons
                                                <small class="pull-right">20%</small>
                                            </h3>
                                            <div class="progress xs">
                                                <div class="progress-bar progress-bar-aqua" style="width: 20%"
                                                     role="progressbar"
                                                     aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                                                    <span class="sr-only">20% Complete</span>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <!-- end task item -->
                                </ul>
                            </li>
                            <li class="footer">
                                <a href="#">View all tasks</a>
                            </li>
                        </ul>
                    </li>
                    <!-- User Account: style can be found in dropdown.less -->
                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <img src="{{ Avatar::create(Auth::user()->name)->toBase64() }}" class="user-image" alt="User Image">
                            <span class="hidden-xs">{{Auth::user()->name}}</span>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- User image -->
                            <li class="user-header">
                                <img src="{{ Avatar::create(Auth::user()->name)->toBase64() }}" class="img-circle" alt="User Image">

                                <p>
                                    {{Auth::user()->name}} -
                                    <small>Member since {{Auth::user()->created_at->format('M d Y')}}</small>
                                </p>
                            </li>
                            <!-- Menu Footer-->
                            <li class="user-footer">
                                <div class="pull-left">
                                    <button type="button" class="btn btn-default btn-flat" data-toggle="modal"
                                            data-target="#Settings">Settings
                                    </button>
                                </div>
                                <div class="pull-right">
                                    <a href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();" class="btn
                                        btn-default btn-flat">Sign out</a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                          style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </div>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
    </header>

    <!-- =============================================== -->

    <!-- Left side column. contains the sidebar -->
    <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
            <!-- Sidebar user panel -->
            <div class="user-panel">
                <div class="pull-left image">
                    <img src="{{ Avatar::create(Auth::user()->name)->toBase64() }}" class="img-circle" alt="User Image">
                </div>
                <div class="pull-left info">
                    <p>{{auth::user()->name}}</p>
                    <a href="#"><i class="fa fa-tag text-info"></i> {{auth::user()->email}}</a>
                </div>
            </div> <!-- search form -->
            <form action="#" method="get" class="sidebar-form">
                <div class="input-group">
                    <input type="text" name="q" class="form-control" placeholder="Search...">
                    <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat">
                  <i class="fa fa-search"></i>
                </button>
              </span>
                </div>
            </form>
            <!-- /.search form -->
            <!-- sidebar menu: : style can be found in sidebar.less -->
            <ul class="sidebar-menu" data-widget="tree">
                <li class="header">MAIN NAVIGATION</li>
                <li class="{{Request::is('admin/dashboard')?'active':''}}"><a href="{{url('admin/dashboard')}}"><i
                                class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>



                <li class="treeview {{Request::is('admin/shop/product','admin/shop/tax','admin/shop/category')?'active':''}}">
                    <a href="#">
                        <i class="fa fa-barcode"></i>
                        <span>Products</span>
                        <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="{{Request::is('admin/shop/product')?'active':''}}"><a href="{{url('admin/shop/product')}}"><i class="fa fa-barcode"></i>Manage Products</a></li>
                        <li class="{{Request::is('admin/shop/category')?'active':''}}"><a href="{{url('admin/shop/category')}}"><i class="fa fa-star"></i>Product Category</a></li>
                        <li class="{{Request::is('admin/shop/tax')?'active':''}}"><a href="{{url('admin/shop/tax')}}"><i class="fa fa-tag"></i> <span>Tax Reference</span></a></li>
                    </ul>
                </li>

                <li class="treeview {{(Request::is('admin/inventory/remaining','admin/inventory/add')||Route::is('History Inventory'))?'active':''}}">
                    <a href="#">
                        <i class="fa fa-bar-chart-o"></i>
                        <span>Inventory</span>
                        <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="{{Request::is('admin/inventory/add')?'active':''}}"><a href="{{url('admin/inventory/add')}}"><i class="fa fa-plus-square-o"></i>Manage Inventory</a></li>
                        <li class="{{Request::is('admin/inventory/remaining')?'active':''}}"><a href="{{url('admin/inventory/remaining')}}"><i class="fa fa-bar-chart-o"></i>Remaining Inventory</a></li>
                        {{--<li class="{{Request::is('admin/inventory/history')?'active':''}}"><a href="#"><i class="fa fa-history"></i>History Inventory</a></li>--}}
                    </ul>
                </li>

                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-shopping-cart"></i>
                        <span>Sales</span>
                        <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                    </a>
                    <ul class="treeview-menu">
                        {{--<li><a href=""><i class="fa fa-angle-right"></i>Manage Affiliates</a></li>--}}
                        {{--<li><a href=""><i class="fa fa-angle-right"></i>Manage Users</a></li>--}}
                        {{--<li><a href=""><i class="fa fa-angle-right"></i>Last Login</a></li>--}}
                    </ul>
                </li>


                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-truck"></i>
                        <span>Orders</span>
                        <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href=""><i class="fa fa-angle-right"></i>Pending Orders</a></li>
                        <li><a href=""><i class="fa fa-angle-right"></i>Cancelled Orders</a></li>
                        <li><a href=""><i class="fa fa-angle-right"></i>Complete Orders</a></li>
                    </ul>
                </li>

                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-send"></i>
                        <span>Courier</span>
                        <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href=""><i class="fa fa-angle-right"></i>Manage Affiliates</a></li>
                        <li><a href=""><i class="fa fa-angle-right"></i>Manage Users</a></li>
                        <li><a href=""><i class="fa fa-angle-right"></i>Last Login</a></li>
                    </ul>
                </li>


                <li class="treeview {{(Request::is('admin/users/affiliate','admin/users/manage','admin/users/track'))?'active':''}}">
                    <a href="#">
                        <i class="fa fa-users"></i>
                        <span>User Management</span>
                        <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="{{Request::is('admin/users/manage')?'active':''}}"><a href="{{url('admin/users/manage')}}"><i class="fa fa-angle-right"></i>Manage Users</a></li>
                        <li class="{{Request::is('admin/users/affiliate')?'active':''}}"><a href="{{url('admin/users/affiliate')}}"><i class="fa fa-angle-right"></i>Manage Affiliates</a></li>
                        <li class="{{Request::is('admin/users/track')?'active':''}}"><a href="{{url('admin/users/track')}}"><i class="fa fa-angle-right"></i>Last Login</a></li>
                    </ul>
                </li>

                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-gear"></i>
                        <span>Configuration</span>
                        <span class="pull-right-container">  <i class="fa fa-angle-left pull-right"></i> </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href=""><i class="fa fa-angle-right"></i>Manage Currencies</a></li>
                        <li><a href=""><i class="fa fa-angle-right"></i>Manage Affiliate's </a></li>
                    </ul>
                </li>

                <li><a href=""><i class="fa fa-shield"></i><span>Affiliates Agreement</span></a></li>
                <li><a href=""><i class="fa fa-calendar"></i><span>Calendar</span></a></li>

            </ul>
        </section>
        <!-- /.sidebar -->
    </aside>


    @yield('content')

    <footer class="main-footer">
        <div class="pull-right hidden-xs">
            <b>Version</b> 1.0.0
        </div>
        <strong>Copyright &copy; 2018 Sympies.</strong> All rights
        reserved.
    </footer>

</div>

<!-- Modals -->
<!-- Settings -->
<div id="Settings" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Settings</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <p>Change the Password</p>
                        <!-- Start form -->
                        <form>
                            <!-- <div class="form-group">
                              <div class="input-group" data-validate="email">
                                            <input type="text" class="form-control" name="validate-email" id="validate-email" placeholder="Email" required>
                                            <span class="input-group-addon danger"><span class="glyphicon glyphicon-remove"></span></span>
                                        </div>
                            </div> -->
                            <div class="form-group">
                                <label for="exampleInputPassword1">Old Password</label>
                                <input type="password" class="form-control" name="password" id="password"
                                       placeholder="Old Password">
                                <br>
                                <label for="exampleInputPassword1">New Password</label>
                                <input type="password" class="form-control" name="Newpassword" id="Newpassword"
                                       placeholder="New Password">
                            </div>
                            <div class="form-check">
                                <button class="btn btn-info" type="button" name="showpassword" id="showpassword"
                                        value="Show Password">Show password
                                </button>
                            </div>

                        </form>
                        <!-- End form -->
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-success">Save</button>
            </div>
        </div>
    </div>
</div>
<!-- End of Settings -->

<!-- End of Modals -->
</body>
@include('includes.js')
<script>
    // Show password Button
    $("#showpassword").on('click', function () {

        var pass = $("#Newpassword");
        var fieldtype = pass.attr('type');
        if (fieldtype == 'password') {
            pass.attr('type', 'text');
            $(this).text("Hide Password");
        } else {
            pass.attr('type', 'password');
            $(this).text("Show Password");
        }
    });
        $('.sidebar-menu').tree();
</script>
@yield('extrajs')
</html>
