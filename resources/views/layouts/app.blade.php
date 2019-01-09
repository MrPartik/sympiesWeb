@php
$countCart=0;
if($cart  = Session::get('cart'))
    foreach ($cart as $id => $val){
        $countCart =  $countCart + $cart[$id]['qty'];
    }
@endphp
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{config('app.name')}} | {{Request::route()->getName()}}</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    @include('includes.css')
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<!-- ADD THE CLASS layout-top-nav TO REMOVE THE SIDEBAR. -->
<body class="hold-transition skin-green fixed layout-top-nav loading">
<div class="wrapper">

    <header class="main-header">
        <nav class="navbar navbar-static-top">
            <div class="container">
                <div class="navbar-header">
                    <a href="{{url('/')}}" class="navbar-brand"><b>Sympies</b></a>
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
                        <i class="fa fa-bars"></i>
                    </button>
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse pull-left" id="navbar-collapse">

                    <ul class="nav navbar-nav">
                        <li class="{{Route::is('Welcome')?'active':''}}"><a href="{{url('/')}}">Shop</a></li>
                        <li class=""><a href="#">Contact us</a></li>
                        @if(Auth::guest())
                        <li class="{{Route::is('login')?'active':''}}"><a href="{{route('login')}}">Login</a></li>
                        @else
                        <li><a href="@if(Auth::user()->role=='admin') {{route('Dashboard')}}
                            @else (Auth::user()->'member') {{route('Member')}}
                            @endif">Welcome back, {{Auth::user()->name}}</a></li>
                        @endif
                        <!--<li class="dropdown">
                          <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown <span class="caret"></span></a>
                          <ul class="dropdown-menu" role="menu">
                            <li><a href="#">Action</a></li>
                            <li><a href="#">Another action</a></li>
                            <li><a href="#">Something else here</a></li>
                            <li class="divider"></li>
                            <li><a href="#">Separated link</a></li>
                            <li class="divider"></li>
                            <li><a href="#">One more separated link</a></li>
                          </ul>
                        </li>-->
                    </ul>
                    {{--<form class="navbar-form navbar-left" role="search">--}}
                        {{--<div class="form-group">--}}
                            {{--<input type="text" class="form-control" id="navbar-search-input" placeholder="Search">--}}
                        {{--</div>--}}
                    {{--</form>--}}
                </div>
                <!-- /.navbar-collapse -->
                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">
                        <!-- Messages: style can be found in dropdown.less-->
                        <li class="dropdown messages-menu">
                            <!-- Menu toggle button -->
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-shopping-cart"></i>
                                <span class="label label-success">{{$countCart}}</span>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="header">You have {{$countCart}} product/s in your cart</li>
                                <li>
                                    <!-- inner menu: contains the messages -->
                                    <ul class="menu">
                                        @php $total=0; @endphp
                                        @foreach((array) $cart as $item)
                                        <li><!-- start message -->
                                            <a href="#">
                                                <div class="pull-left">
                                                    <!-- User Image -->
                                                    <img src="{{($item['prodimg']==null||!file_exists($item['prodimg']))?asset('uPackage.png'):asset($item['prodimg'])}}" class="img-circle" alt="User Image">
                                                </div>
                                                <!-- Message title and timestamp -->
                                                <h4>
                                                    {{$item['prodname']}}
                                                    <small><strong><i class="fa fa-money"></i> {{($item['qty'])*($item['prodprice'])}}</strong></small>
                                                </h4>
                                                <!-- The message -->
                                                <p>Quantity: {{$item['qty']}} pc/s</p>
                                            </a>
                                        </li>
                                        <!-- end message -->
                                        @php $total+= ($item['qty'])*($item['prodprice']); @endphp
                                        @endforeach
                                    </ul>
                                    <!-- /.menu -->
                                </li>
                                <li class="footer"><center>Total: {{$total}}</center></li>
                                <li class="footer col-md-6"><a href="{{route('Cart')}}">View Cart</a></li>
                                <li class="footer col-md-6"><a href="#">Checkout</a></li>
                            </ul>
                        </li>
                        <!-- /.messages-menu -->


                        </li>

                        <!-- User Account Menu -->
                        {{--<li class="dropdown user user-menu">--}}
                            {{--<!-- Menu Toggle Button -->--}}
                            {{--<a href="#" class="dropdown-toggle" data-toggle="dropdown">--}}
                                {{--<!-- The user image in the navbar-->--}}
                                {{--<img src="../../dist/img/user2-160x160.jpg" class="user-image" alt="User Image">--}}
                                {{--<!-- hidden-xs hides the username on small devices so only the image appears. -->--}}
                                {{--<span class="hidden-xs">Alexander Pierce</span>--}}
                            {{--</a>--}}
                            {{--<ul class="dropdown-menu">--}}
                                {{--<!-- The user image in the menu -->--}}
                                {{--<li class="user-header">--}}
                                    {{--<img src="../../dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">--}}

                                    {{--<p>--}}
                                        {{--Alexander Pierce - Web Developer--}}
                                        {{--<small>Member since Nov. 2012</small>--}}
                                    {{--</p>--}}
                                {{--</li>--}}
                                {{--<!-- Menu Body -->--}}
                                {{--<li class="user-body">--}}
                                    {{--<div class="row">--}}
                                        {{--<div class="col-xs-4 text-center">--}}
                                            {{--<a href="#">Followers</a>--}}
                                        {{--</div>--}}
                                        {{--<div class="col-xs-4 text-center">--}}
                                            {{--<a href="#">Sales</a>--}}
                                        {{--</div>--}}
                                        {{--<div class="col-xs-4 text-center">--}}
                                            {{--<a href="#">Friends</a>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                    {{--<!-- /.row -->--}}
                                {{--</li>--}}
                                {{--<!-- Menu Footer-->--}}
                                {{--<li class="user-footer">--}}
                                    {{--<div class="pull-left">--}}
                                        {{--<a href="#" class="btn btn-default btn-flat">Profile</a>--}}
                                    {{--</div>--}}
                                    {{--<div class="pull-right">--}}
                                        {{--<a href="#" class="btn btn-default btn-flat">Sign out</a>--}}
                                    {{--</div>--}}
                                {{--</li>--}}
                            {{--</ul>--}}
                        {{--</li>--}}
                    </ul>
                </div>
            </div>
            <!-- /.container-fluid -->
        </nav>
    </header>
    <!-- Full Width Column -->

    <div class="content-wrapper">
        <div class="container">
            @yield('content')
        </div>
    </div>
    <footer class="main-footer">
        <div class="pull-right hidden-xs">
            <b>Version</b> 1.0.0
        </div>
        <strong>Copyright &copy; 2018 Sympies.</strong> All rights
        reserved.
    </footer>
</div>
<!-- ./wrapper -->
@include('includes.js')
@extends('magpie.indexjs')
@yield('extrajs')
</body>
</html>
