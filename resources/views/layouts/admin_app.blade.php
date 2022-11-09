<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{csrf_token()}}">
  <title>@yield('title')</title>
  <link rel="stylesheet" href="{{asset('/vendors/font-awesome/css/font-awesome.min.css')}}" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
  <link rel="stylesheet" href="{{ asset('/vendors/ti-icons/css/themify-icons.css')}}">
  <link rel="stylesheet" href="{{ asset('/vendors/css/vendor.bundle.base.css')}}">
  <link rel="stylesheet" href="{{asset('/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css')}}">
  <link rel="stylesheet" href="{{asset('/vendors/daterangepicker/daterangepicker.css')}}">
  <!-- endinject -->
  <!-- Plugin css for this page -->
  <link rel="stylesheet" href="{{ asset('/vendors/datatables.net-bs4/dataTables.bootstrap4.css')}}">
  <!-- inject:css -->
  <link rel="stylesheet" href="{{ asset('/css/vertical-layout-dark/style.css')}}">
  <link rel="stylesheet" href="{{ asset('/css/vertical-layout-dark/custom-style.css')}}">
  <!-- endinject -->
  <link rel="shortcut icon" href="{{ asset('images/favicon.png')}}"/>
  <link href="{{asset('/css/bootstrap4-toggle.min.css')}}" rel="stylesheet">
  <link href="{{asset('/css/admin_custom.css')}}" rel="stylesheet">
  
  @yield('page_css')
  <style type="text/css">
    .notification {
      color: white;
      text-decoration: none;
      padding: 15px 26px;
      position: relative;
      display: inline-block;
      border-radius: 2px;
    }

    .notification .badge {
      position: absolute;
      top: -10px;
      right: -5px;
      padding: 2px 5px;
      border-radius: 50%;
      background: red;
      color: white;
    }
    .main-panel{
      /*margin-top:-20px;*/
    }
    .page-body-wrapper{
     margin-top:-20px;
   }
   .text-danger {
    color: red !important;
    font-size: 0.875rem;
    line-height: 1.4rem;
    vertical-align: top;
    margin-bottom: .5rem;
  }
  h3.mb-0.mb-md-2.mb-xl-0.order-md-1.order-xl-0 {
    width: 83%;
    font-size: 20px;
}
</style>
</head>
<body>
  <div class="container-scroller">
    @include('admin_includes.admin_navbar')
    <div class="container-fluid page-body-wrapper">
      
      @include('admin_includes.admin_sidebar')
      @yield('content')
      <footer class="footer">
        <div class="float-sm-right  d-sm-flex justify-content-center justify-content-sm-between">
          <span class="text-muted text-right text-sm-left d-block d-sm-inline-block">
            Copyright © 2020 Avanya. All rights reserved.
          </span>
        </div>
      </footer>
      <!-- partial -->
    </div>
    <!-- main-panel ends -->
  </div>
  <!-- page-body-wrapper ends -->
</body>

<script src="{{ asset('/vendors/js/vendor.bundle.base.js')}}"></script>
<!-- endinject -->
<!-- Plugin js for this page -->
<script src="{{ asset('/vendors/chart.js/Chart.min.js')}}"></script>
<!-- End plugin js for this page -->
<script src=" {{ asset('/js/off-canvas.js')}}"></script>
<script src="{{asset('/vendors/moment/moment.min.js')}}"></script>
<script src="{{ asset('/js/hoverable-collapse.js')}}"></script>
<script src="{{ asset('/js/template.js') }}"></script>
<script src="{{asset('/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js')}}"></script>
<script src="{{asset('/vendors/daterangepicker/daterangepicker.min.js')}}"></script>
<script src="{{ asset('/js/settings.js') }}"></script>
<script src="{{ asset('/js/todolist.js')}}"></script>
<script src="{{ asset('/js/file-upload.js')}}"></script>
<!-- Custom js for this page-->
<script src="{{ asset('/js/dashboard.js')}}"></script>

@yield('scripts')

@yield('page_js')
<script>
  $(".alert-dismissible").fadeTo(2000, 500).slideUp(500, function () {
    $(".alert-dismissible").alert('close');
  });
</script>


</html>

