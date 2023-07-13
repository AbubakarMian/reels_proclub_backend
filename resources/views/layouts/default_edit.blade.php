  <style>
      .medinputs input {
          height: 40px;
          border-radius: 0px;
          border: 1px solid #e6e6e6;
          padding: 7px;
      }
      .medinputs .selection span {
          height: 42px;
          border-radius: 0px;
          border: 1px solid #e6e6e6;
      }

      .medinputs select {
          height: 40px;
          border-radius: 0px;
          padding: 7px;
          border: 1px solid #e6e6e6;
      }

      .medinputs label {
          font-size: 15px;
          font-weight: 500;
          color: gray;
          margin-bottom: 1px;
      }

      .medsaveclick {
          width: 60% !important;
          font-size: 17px !important;
          font-weight: 500 !important;
          height: 42px !important;
          padding-bottom: 30px !important;
          border-radius: 4px !important;
          background: #da3e16 !important;
          border-color: #da3e16 !important;
          margin-top: 20px !important
      }
  </style>



  <?php
  $admin_common = session()->get('admin_common');
  if (!isset($back_btn_link)) {
      $back_btn_link = url()->previous();
  }
  ?>

  @extends('layouts.default_header', ['back_btn_link' => $back_btn_link])

  @section('content')
  @section('Admin')
      Welcome {!! $admin_common->name !!}
  @stop
  </head>
  <!-- body -->

  <body>
      <div class="app">
          <section class="layout">
              <!-- main content -->
              <section class="main-content">
                  <!-- content wrapper -->
                  <div class="content-wrap">
                      <!-- inner content wrapper -->
                      <div class="wrapper">
                          <section class="panel">
                              <header class="panel-heading no-b">
                                  <a href="{!! $back_btn_link !!}"
                                      class="btn btn-default btn-block btn-lg btn-parsley permiback"><i
                                          class="fa fa-arrow-circle-left" aria-hidden="true"></i> Back</a>
                                  <h2>@yield('heading')</h2>
                              </header>
                              <div class="panel-body medinputs">

                                  @yield('completeform')
                                  <div class="row">
                                      <!-- left side -->
                                      <?php
                                      if (empty($col_size)) {
                                          $col_size = '6';
                                      }
                                      ?>
                                      <div class="col-md-{!! $col_size !!}">
                                          @yield('leftsideform')
                                      </div>
                                      <!-- Lef side end -->
                                      <!-- Right side start -->
                                      <div class="col-md-6">
                                          @yield('rightsideform')
                                      </div>
                                      <div class="col-md-5 pull-left">
                                          <div class="form-group text-center">
                                              <label></label>
                                              <div>
                                                  @yield('save')
                                              </div>
                                          </div>
                                      </div>
                                      <div class="col-md-5 pull-left">
                                          <div class="form-group text-center">
                                              <label></label>
                                              <div>
                                                  @yield('cancel')
                                              </div>
                                          </div>
                                      </div>
                                      <!-- Right side end -->
                                  </div>
                              </div>
                          </section>
                      </div>
                      <!-- /inner content wrapper -->

                  </div>
                  <!-- /content wrapper -->
                  <a class="exit-offscreen"></a>
              </section>
              <!-- /main content -->
          </section>
      </div>
      <div class="form-group">

      </div>

      <!-- cropper open -->
      -
      <!-- build:js({.tmp,app}) scripts/app.min.js -->
      <script src="{{ asset('theme/vendor/jquery/dist/jquery.js') }}"></script>
      <!-- endbuild -->
      <script src="{{ asset('theme/vendor/parsleyjs/dist/parsley.min.js') }}"></script>

      <!-- open=====uncmment kiya tha bd mai cropeer na chlne ki waja se -->
      <link rel="stylesheet" href="https://unpkg.com/dropzone/dist/dropzone.css" />
      <link href="https://unpkg.com/cropperjs/dist/cropper.css" rel="stylesheet" />

      <!--end   -->
      <script src="https://unpkg.com/dropzone"></script>
      <script src="https://unpkg.com/cropperjs"></script>
      <!-- build:js({.tmp,app}) scripts/app.min.js -->

      <!-- cropper close -->
      <script src="{{ asset('theme/vendor/jquery/dist/jquery.js') }}"></script>
      <!-- endbuild -->
      <script src="{{ asset('theme/vendor/parsleyjs/dist/parsley.min.js') }}"></script>
  @stop
