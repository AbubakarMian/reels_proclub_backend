<?php
$admin_common = session()->get('admin_common');
?>
<!doctype html>
<html class="no-js" lang="">
<html xmlns="http://www.w3.org/1999/xhtml" dir="rtl" xml:lang="ar" lang="ar">

<head>
    <!-- meta -->
    <meta charset="utf-8">
    <meta name="description" content="Flat, Clean, Responsive, application admin template built with bootstrap 3">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1, maximum-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <!-- /meta -->

    <title>Admin Panel</title>

    <!-- page level plugin styles -->
    <!-- /page level plugin styles -->

    <!-- build:css({.tmp,app}) styles/app.min.css -->
    <link rel="stylesheet" href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css">
    <link rel="stylesheet" href="{{ asset('theme/vendor/bootstrap/dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('theme/styles/font-awesome.css') }}">
    <link rel="stylesheet" href="{{ asset('theme/styles/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('theme/styles/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('theme/styles/sublime.css') }}">
    <link rel="stylesheet" href="{{ asset('cssjs/myapp.css') }}">
    <link rel="stylesheet" href="{{ asset('cssjs/jquery.timeentry.css') }}">
    <!-- mobiscroll -->
    <link rel="stylesheet" href="{{ asset('css/mobi/mobiscroll.jquery.min.css') }}">
    <!--  -->
    {{-- Data Tables CSS --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.1.0/css/buttons.dataTables.min.css">
    {{-- Data Tables CSS end --}}

    @yield('css')
    @yield('extra_css')
    <!-- endbuild -->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- load modernizer -->
    <script src="{{ asset('theme/vendor/modernizr.js') }}"></script>
    <script src="https://cdn.plot.ly/plotly-latest.min.js"></script>

    <!-- css multiselect  -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />


    <!--end multiselect  -->
</head>

<!-- body -->

<style>
    .fbsda {
        background: #15db81;
        border-color: #15db81;
    }
    .medsaveclick {
    padding-top: 15px !important;
}
section.dash-tile.bg-warning.modules {
    background-color: midnightblue;
    max-height: 105px;
    display: none;
}
button.btn.btn-success.ddd.ccc {
    display: none;
}

</style>

<body>

    <div class="app">
        <!-- top header -->
        <header class="header header-fixed navbar">

            <div class="brand">
                <!-- toggle offscreen menu -->
                <a href="javascript:;" class="ti-menu off-left visible-xs" data-toggle="offscreen" data-move="ltr"></a>
                <!-- /toggle offscreen menu -->

                <!-- logo -->
                <a href="{{ asset('index.php/admin/dashboard') }}" class="navbar-brand">
                    <img src="{{ asset('images/logo.png') }}" alt="">
                    <span class="heading-font"></span>
                </a>
                <!-- /logo -->
            </div>

            <ul class="nav navbar-nav">
                <li class="hidden-xs">
                    <!-- toggle small menu -->
                    <a href="javascript:;" class="toggle-sidebar">
                        <i class="ti-menu"></i>
                    </a>
                    <!-- /toggle small menu -->
                </li>
                <li class="header-search">
                </li>
            </ul>

            <ul class="nav navbar-nav navbar-right">

                <li class="off-right hidden-xs">
                    <a href="javascript:;" data-toggle="dropdown" class="no-hover">
                        <img src="{{ asset('theme/images/avatar.jpg') }} " class="header-avatar img-circle"
                            alt="user" title="user">
                        {{--                    <span class="hidden-xs ml10">Welcome {!! $admin_common->name !!}</span> --}}
                        {{--                    <span class="hidden-xs ml10">Welcome {!! $admin_common->name !!}</span> --}}
                        <!-- <i class="ti-angle-down ti-caret hidden-xs"></i> -->
                    </a>
                </li>

                <li class="off-right">
                    <form action="{{ asset('admin/logout') }}">
                        <input type="submit" class="btn btn-danger btn-rounded margin-top fbsda" value="LogOut">
                    </form>
                    <!--           <button type="button" class="btn btn-danger btn-rounded margin-top">LogOut</button> -->
                </li>

            </ul>
        </header>
        <!-- /top header -->

        <section class="layout">
            <!-- sidebar menu -->
            <aside class="sidebar offscreen-left">
                <!-- main navigation -->
                <nav style="overflow: hidden;" class="main-navigation" data-height="auto" data-size="6px"
                    data-distance="0" data-rail-visible="true" data-wheel-step="10">
                    <p class="nav-title">MENU</p>
                    <ul class="nav">
                        <!-- dashboard -->
                        <li>
                            <a href="{{ asset('admin/dashboard') }}">
                                <i class="ti-home"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>
                        <!-- /dashboard -->


                        <!-- Modules -->
                        <li>
                            <a href="javascript:;">
                                <i class="toggle-accordion"></i>
                                <!-- <i class="ti-settings"></i> -->
                                <i class="fa fa-table" aria-hidden="true"></i>
                                <span>Modules</span>
                            </a>
                            <ul class="sub-menu">

                                @foreach ($admin_common->modules as $key => $module)
                                    <li>
                                        <a href="{!! asset('index.php/' . $module['url']) !!}">
                                            <span>{!! $module['title'] !!}</span>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                        <!-- /Modules -->


                        <!-- Reports -->
                        <li>
                            <a href="javascript:;">
                                <i class="toggle-accordion"></i>
                                <!-- <i class="ti-support"></i> -->
                                <i class="fa fa-line-chart"></i>
                                <span>Reports</span>
                            </a>
                            <ul class="sub-menu">

                                @foreach ($admin_common->reports as $key => $report)
                                    <li>
                                    <li>
                                        <a href="{{ asset('index.php/' . $report['url']) }}">
                                            <span>{!! $report['title'] !!}</span>
                                        </a>

                                    </li>
                                @endforeach
                            </ul>
                        </li>
                        <!-- /Reports -->
                    </ul>
                </nav>
            </aside>
            <!-- /sidebar menu -->

            <!-- main content -->
            <section class="main-content">
                <!-- content wrapper -->
                <div class="content-wrap">
                    <!-- inner content wrapper -->
                    <div class="wrapper no-p">



                        <div class="app">
                            <section class="layout">
                                <!-- main content -->
                                <section class="main-content">
                                    <!-- content wrapper -->
                                    <div class="content-wrap">
                                        <!-- inner content wrapper -->
                                        <div class="wrapper">
                                            <div id="add_custom_modals"></div>

                                            @yield('content')
                                        </div>
                                        <!-- /inner content wrapper -->
                                    </div>
                                    <!-- /footer -->
                                    @yield('footer')
                                    <!-- /content wrapper -->
                                    <a class="exit-offscreen"></a>
                                </section>
                                <!-- /main content -->
                            </section>

                        </div>


                    </div>
                    <!-- /inner content wrapper -->
                </div>
                <!-- /content wrapper -->
                <a class="exit-offscreen"></a>
            </section>
            <!-- /main content -->
        </section>
    </div>
    <!-- build:js({.tmp,app}) scripts/app.min.js -->
    <!--   this file will be loaded individually for all files to avoide conficts  -->
    <!--   <script src="{{ asset('theme/vendor/jquery/dist/jquery.js') }}"></script> -->
    {{-- <script src="{{ asset('cssjs/jQuery-2.1.4.min.js')  }}"></script> --}}
    <script src="{{ asset('cssjs/jquery.plugin.js') }}"></script>
    {{-- <script src="{{ asset('cssjs/jquery.timeentry.js')}}"></script> --}}
    <script src="{{ asset('theme/vendor/bootstrap/dist/js/bootstrap.js') }}"></script>
    <script src="{{ asset('theme/vendor/slimScroll/jquery.slimscroll.js') }}"></script>
    <script src="{{ asset('theme/vendor/jquery.easing/jquery.easing.js') }}"></script>
    <script src="{{ asset('theme/vendor/jquery_appear/jquery.appear.js') }}"></script>
    <script src="{{ asset('theme/vendor/jquery.placeholder.js') }}"></script>
    <script src="{{ asset('theme/vendor/fastclick/lib/fastclick.js') }}"></script>
    <script src="{{ asset('cssjs/jquery.timeentry.js') }}"></script>

    {{-- Data Table Jquery & Ajax --}}
    {{-- <script src="https://code.jquery.com/jquery-3.5.1.js"></script> --}}
    <script>
        window.jQuery || document.write('<script src="https://code.jquery.com/jquery-3.5.1.js"><\/script>');
    </script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.1.0/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.1.0/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.1.0/js/buttons.print.min.js"></script>
    {{-- Data Table Jquery & Ajax end --}}

    <!--multiselect js  -->

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.js"></script>

    <!-- end multiselect -->

    <!-- mobiscroll  -->

    {{-- <script src="{{asset('mobi_js/mobiscroll.jquery.min.js')}}"></script> --}}



    <!-- end mobiscroll -->



    <!-- endbuild -->

    <!-- page level scripts -->
    <!-- /page level scripts -->



    <!-- /template scripts -->
    {{-- <script src="{{ asset('cssjs/map.js') }}"></script> --}}
    {
    {{-- <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAMwD9jQSMyeJhuZfpMtlD6idB499MbMNI&libraries=places&callback=initAutocomplete"
        async defer></script> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.2.6/jquery.inputmask.bundle.min.js"></script>

    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
    @yield('app_jquery')

    <!-- page script -->
    <!-- /page script -->

    <!-- template scripts -->
    <script src="{{ asset('theme/scripts/main.js') }}"></script>
    <script src="{{ asset('theme/scripts/offscreen.js') }}"></script>
    @include('layouts.myapp_js')

    <!-- /template scripts -->
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>

</body>
<!-- /body -->

</html>
