
{{--<div class="modal"></div>--}}
<!-- jQuery 3 -->
<script src="/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- Select2 -->
<script src="/bower_components/select2/dist/js/select2.full.min.js"></script>
<!-- InputMask -->
<script src="/plugins/input-mask/jquery.inputmask.js"></script>
<script src="/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
<script src="/plugins/input-mask/jquery.inputmask.extensions.js"></script>
<!-- date-range-picker -->
<script src="/bower_components/moment/min/moment.min.js"></script>
<script src="/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<!-- bootstrap datepicker -->
<script src="/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<!-- bootstrap color picker -->
<script src="/bower_components/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js"></script>
<!-- bootstrap time picker -->
<script src="/plugins/timepicker/bootstrap-timepicker.min.js"></script>
<!-- SlimScroll -->
<script src="/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- iCheck 1.0.1 -->
<script src="/plugins/iCheck/icheck.min.js"></script>
<script src="/izitoast/dist/js/iziToast.min.js" type="text/javascript"></script>
<!-- FastClick -->
<script src="/bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="/dist/js/adminlte.min.js"></script>
<!-- Morris.js charts -->
<script src="/bower_components/raphael/raphael.min.js"></script>
<script src="/bower_components/morris.js/morris.min.js"></script>


<script src="{{asset('plugins/DataTables/media/js/jquery.dataTables.js')}}"></script>
<script src="{{asset('plugins/DataTables/media/js/dataTables.bootstrap.min.js')}}"></script>
<script src="{{asset('plugins/DataTables/extensions/Buttons/js/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('plugins/DataTables/extensions/Buttons/js/buttons.bootstrap.min.js')}}"></script>
<script src="{{asset('plugins/DataTables/extensions/Buttons/js/buttons.flash.min.js')}}"></script>
<script src="{{asset('plugins/DataTables/extensions/Buttons/js/jszip.min.js')}}"></script>
<script src="{{asset('plugins/DataTables/extensions/Buttons/js/pdfmake.min.js')}}"></script>
<script src="{{asset('plugins/DataTables/extensions/Buttons/js/vfs_fonts.min.js')}}"></script>
<script src="{{asset('plugins/DataTables/extensions/Buttons/js/buttons.html5.min.js')}}"></script>
<script src="{{asset('plugins/DataTables/extensions/Buttons/js/buttons.print.min.js')}}"></script>
<script src="{{asset('plugins/DataTables/extensions/Responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('plugins/DataTables/extensions/AutoFill/js/dataTables.autoFill.min.js')}}"></script>
<script src="{{asset('plugins/DataTables/extensions/ColReorder/js/dataTables.colReorder.min.js')}}"></script>
<script src="{{asset('plugins/DataTables/extensions/KeyTable/js/dataTables.keyTable.min.js')}}"></script>
<script src="{{asset('plugins/DataTables/extensions/RowReorder/js/dataTables.rowReorder.min.js')}}"></script>
<script src="{{asset('plugins/DataTables/extensions/Select/js/dataTables.select.min.js')}}"></script>

<script src="{{asset('js/demo/table-manage-combine.demo.min.js')}}"></script>
<script src="{{asset('js/demo/table-manage-buttons.demo.js')}}"></script>

<script src="/bower_components/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js"></script>
<script src="/bower_components/sweetalert/sweetalert.min.js"></script>
<script src="/bower_components/bootstrap-wysihtml5/wysihtml5-0.3.0.js"></script>
<script src="/bower_components/bootstrap-wysihtml5/bootstrap-wysihtml5.js"></script>
<script src="/bower_components/jquery-tags-input/jquery.tagsinput.js"></script>
<script src="{{asset('magpieserver.js')}}"></script>
<!-- AdminLTE for demo purposes -->
<script src="/dist/js/demo.js"></script>
<script src="/bower_components/PACE/pace.min.js"></script>
<script>
    $(document).ajaxStart(function() { Pace.restart();});
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

    Pace.on('start',function(){
        $("div[id='overlay']").show();
    });
    Pace.on('done',function(){
        $("div[id='overlay']").hide();
    });
    $(document).ready(function() {
        TableManageButtons.init();
    });
</script>

