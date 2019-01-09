@extends('layouts.admin')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Dashboard
                <small>Overview</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">

                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-aqua"><i class="fa fa-shopping-cart"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Total Transactions</span>
                            <span class="info-box-number">1,410</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>

                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-green"><i class="fa fa-users"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Total Customers</span>
                            <span class="info-box-number">10</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>

            </div>

            <!-- Default box -->
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Gross Volume</h3>
                </div>
                <div class="box-body">

                    <!-- Gross Volume -->
                    <div class="box-body chart-responsive">
                        <div class="chart" id="grossVolume" style="height: 300px;"></div>
                    </div>
                    <!-- End of Gross Volume -->

                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                </div>
                <!-- /.box-footer-->
            </div>
            <!-- /.box -->

            <!-- Successful Charges box -->
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Successful Charges</h3>
                </div>
                <div class="box-body">

                    <!-- Gross Volume -->
                    <div class="box-body chart-responsive">
                        <div class="chart" id="Charges" style="height: 300px;"></div>
                    </div>
                    <!-- End of Gross Volume -->

                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                </div>
                <!-- /.box-footer-->
            </div>
            <!-- /.box -->

            <!-- Successful Charges box -->
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Customers</h3>
                </div>
                <div class="box-body">

                    <!-- Gross Volume -->
                    <div class="box-body chart-responsive">
                        <div class="chart" id="Customers" style="height: 300px;"></div>
                    </div>
                    <!-- End of Gross Volume -->

                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                </div>
                <!-- /.box-footer-->
            </div>
            <!-- /.box -->

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

@endsection

@section('extrajs')
    <script>
        $(function () {
            "use strict";

            // Gross volume CHART
            var area = new Morris.Area({
                element: 'grossVolume',
                resize: true,
                data: [
                    {y: '2011 Q1', item1: 2666, item2: 2666},
                    {y: '2011 Q2', item1: 2778, item2: 2294},
                    {y: '2011 Q3', item1: 4912, item2: 1969},
                    {y: '2011 Q4', item1: 3767, item2: 3597},
                    {y: '2012 Q1', item1: 6810, item2: 1914},
                    {y: '2012 Q2', item1: 5670, item2: 4293},
                    {y: '2012 Q3', item1: 4820, item2: 3795},
                    {y: '2012 Q4', item1: 15073, item2: 5967},
                    {y: '2013 Q1', item1: 10687, item2: 4460},
                    {y: '2013 Q2', item1: 8432, item2: 5713}
                ],
                xkey: 'y',
                ykeys: ['item1', 'item2'],
                labels: ['Item 1', 'Item 2'],
                lineColors: ['#a0d0e0', '#3c8dbc'],
                hideHover: 'auto'
            });
            //

            // Successful Charges CHART
            var area = new Morris.Area({
                element: 'Charges',
                resize: true,
                data: [
                    {y: '2011 Q1', item1: 2666, item2: 2666},
                    {y: '2011 Q2', item1: 2778, item2: 2294},
                    {y: '2011 Q3', item1: 4912, item2: 1969},
                    {y: '2011 Q4', item1: 3767, item2: 3597},
                    {y: '2012 Q1', item1: 6810, item2: 1914},
                    {y: '2012 Q2', item1: 5670, item2: 4293},
                    {y: '2012 Q3', item1: 4820, item2: 3795},
                    {y: '2012 Q4', item1: 15073, item2: 5967},
                    {y: '2013 Q1', item1: 10687, item2: 4460},
                    {y: '2013 Q2', item1: 8432, item2: 5713}
                ],
                xkey: 'y',
                ykeys: ['item1', 'item2'],
                labels: ['Item 1', 'Item 2'],
                lineColors: ['#a0d0e0', '#3c8dbc'],
                hideHover: 'auto'
            });
            //

            // Successful Charges CHART
            var area = new Morris.Area({
                element: 'Customers',
                resize: true,
                data: [
                    {y: '2011 Q1', item1: 2666, item2: 2666},
                    {y: '2011 Q2', item1: 2778, item2: 2294},
                    {y: '2011 Q3', item1: 4912, item2: 1969},
                    {y: '2011 Q4', item1: 3767, item2: 3597},
                    {y: '2012 Q1', item1: 6810, item2: 1914},
                    {y: '2012 Q2', item1: 5670, item2: 4293},
                    {y: '2012 Q3', item1: 4820, item2: 3795},
                    {y: '2012 Q4', item1: 15073, item2: 5967},
                    {y: '2013 Q1', item1: 10687, item2: 4460},
                    {y: '2013 Q2', item1: 8432, item2: 5713}
                ],
                xkey: 'y',
                ykeys: ['item1', 'item2'],
                labels: ['Item 1', 'Item 2'],
                lineColors: ['#a0d0e0', '#3c8dbc'],
                hideHover: 'auto'
            });
            //
        });
        $(document).ready(function () {
            $('.sidebar-menu').tree()

            iziToast.show({
                theme: 'dark',
                icon: 'icon-person',
                title: 'Hey',
                message: 'Welcome {{Auth::user()->name}}!',
                position: 'topRight', // bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter
                progressBarColor: 'rgb(0, 255, 184)',
                buttons: [
                    // ['<button>Ok</button>', function (instance, toast) {
                    //     // alert("Hello world!");
                    // }, true], // true to focus
                    ['<button>Close</button>', function (instance, toast) {
                        instance.hide({
                            transitionOut: 'fadeOutUp',
                            onClosing: function(instance, toast, closedBy){
                                // console.info('closedBy: ' + closedBy); // The return will be: 'closedBy: buttonName'
                            }
                        }, toast, 'buttonName');
                    }]
                ],
                onOpening: function(instance, toast){
                    // console.info('callback abriu!');
                },
                onClosing: function(instance, toast, closedBy){
                    // console.info('closedBy: ' + closedBy); // tells if it was closed by 'drag' or 'button'
                }
            });

        })

    </script>

@endsection

