@extends('layouts.default_header')

@section('css')
    <link rel="stylesheet" href="{{ asset('theme/vendor/chosen_v1.4.0/chosen.min.css') }}">
    <link rel="stylesheet" href="{{ asset('theme/vendor/datatables/media/css/jquery.dataTables.css') }}">
    <link rel="stylesheet" href="{{ asset('theme/vendor/bootstrap-daterangepicker/daterangepicker-bs3.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.0.1/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="{{ asset('theme/vendor/datatables/media/css/jquery.dataTables.css') }}">

    <script>
        window.jQuery || document.write('<script src="https://code.jquery.com/jquery-3.5.1.js"><\/script>');
    </script>
{{-- <script type="text/javascript" language="javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script> --}}
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.html5.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.print.min.js"></script>

@stop

@section('content')

    <ol class="breadcrumb">
        <a href="{!! route('dashboard') !!}" class="btn btn-default btn-block btn-lg btn-parsley permiback"><i
            class="fa fa-arrow-circle-left" aria-hidden="true"></i> Back</a>
        <li>
            <a href="{{route('dashboard')}}"><i class="ti-home mr5"></i>
                Dashboard</a>
        </li>
        <li>
            <a href=""><i class="ti-window mr5"></i>Modules</a>
        </li>
        <li class="active">@yield('module_name')</li>
    </ol>
    @yield('module_search_top')
    <h3>@yield('module_name')</h3>
    <br>
    <section class="panel panel-default">
        <div class="panel-body">
            <div class="table-responsive no-border">
            @yield('single_file_use')
                <table @yield('table-properties') id="index-table" class="table table-bordered table-striped mg-t editable-datatable">
                    <div class="demo-button margin-bottom">
                        @yield('add_btn')
                        @yield('module_search_left')
                    </div>
                    @yield('table')
                </table>
                @yield('images')
                @yield('pagination')
            </div>
        </div>
    </section>

    <div class="modal fade delete in" tabindex="-1" role="dialog" aria-hidden="false">
        <div class="modal-dialog">
            <div class="modal-content" id="confirm">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title" id="modal-heading">
                        Delete
                    </h4>
                </div>
                <div class="modal-body">

                    <div class="row">
                        <div class="col-xs-12">
                            <label id="modal_msg">
                                Do You Want to Delete?
                            </label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="delete" class="btn btn-primary" data-dismiss="modal">Yes</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- build:js({.tmp,app}) scripts/app.min.js -->
    <script src="{{ asset('theme/vendor/jquery/dist/jquery.js') }}"></script>
    <!-- endbuild -->

    <!-- page level scripts -->
    <script src="{{ asset('theme/vendor/chosen_v1.4.0/chosen.jquery.min.js') }}"></script>
    <script src="{{ asset('theme/vendor/datatables/media/js/jquery.dataTables.js') }}"></script>
    <!-- /page level scripts -->

    <!-- page level scripts -->
    <script src="{{ asset('theme/vendor/moment/moment.js') }}"></script>
    <script src="{{ asset('theme/vendor/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ asset('theme/vendor/bootstrap-datepicker/dist/js/bootstrap-datepicker.js') }}"></script>
    <script src="{{ asset('theme/vendor/jt.timepicker/jquery.timepicker.min.js') }}"></script>
    <script src="{{ asset('theme/vendor/mjolnic-bootstrap-colorpicker/dist/js/bootstrap-colorpicker.js') }}"></script>
    <script src="{{ asset('theme/vendor/bootstrap-colorpalette/js/bootstrap-colorpalette.js') }}"></script>
    <!-- /page level scripts -->

    <!-- page script -->
    {{-- <script src="{{ asset('theme/scripts/pickers.js') }}"></script> --}}

    <!-- page script -->
    <script src="{{ asset('theme/scripts/bootstrap-datatables.js') }}"></script>
    <script src="{{ asset('theme/scripts/table-edit.js') }}"></script>
    <!-- /page script -->

@stop
