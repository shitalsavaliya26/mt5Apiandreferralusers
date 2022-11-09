<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
  {{-- <meta http-equiv="refresh" content = "600; url={{route('auto-logout')}}">--}}
  <title>@yield('title')</title>
  <link href="https://fonts.googleapis.com/css2?family=Sawarabi+Mincho&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{asset('/vendors/ti-icons/css/themify-icons.css')}}">
  <link rel="stylesheet" href="{{asset('/vendors/css/vendor.bundle.base.css')}}">
  <!-- endinject -->
  <link rel="stylesheet" href="{{asset('/vendors/dropzone/dropzone.css')}}">
  <link rel="stylesheet" href="{{asset('/vendors/font-awesome/css/font-awesome.min.css')}}"/>
  <link rel="stylesheet" href="{{asset('/vendors/owl-carousel-2/owl.carousel.min.css')}}">
  <link rel="stylesheet" href="{{asset('/vendors/owl-carousel-2/owl.theme.default.min.css')}}">
  <link rel="stylesheet" href="{{asset('/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css')}}">
  <link rel="stylesheet" href="{{asset('/vendors/daterangepicker/daterangepicker.css')}}">
  <link rel="stylesheet" href="{{asset('/vendors/jstree/style.min.css')}}"/>
  <link rel="stylesheet" href="{{asset('/vendors/flag-icon-css/css/flag-icon.min.css')}}"/>
  <!-- End plugin css for this page -->
  <link rel="stylesheet" href="{{asset('/css/vertical-layout-dark/style.css')}}">
  <link rel="stylesheet" href="{{asset('/css/frontend-custom.css')}}">
  <!-- endinject -->
  <link rel="shortcut icon" href="{{asset('/images/favicon.png')}}"/>
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
    h3.mb-0.mb-md-2.mb-xl-0.order-md-1.order-xl-0 {
      width: 85%;
    }
  </style>
  @yield('page_css')
</head>
<body>
  <div class="container-fluid page-body-wrapper">
    @include('includes.sidebar')
    <div class="main-panel">
      @include('includes.navbar')
      <div class="col-12 pd-lr-30">
        @yield('content')
        @include('includes.avanya')
      </div>
    </div>
  </div>
</body>
<script src="{{asset('/vendors/js/vendor.bundle.base.js')}}"></script>
<script src="{{asset('/vendors/chart.js/Chart.min.js')}}"></script>
<script src="{{asset('/vendors/clipboard/clipboard.min.js')}}"></script>
<script src="{{asset('/vendors/owl-carousel-2/owl.carousel.min.js')}}"></script>
<script src="{{asset('/vendors/moment/moment.min.js')}}"></script>
<script src="{{asset('/vendors/tempusdominus-bootstrap-4/tempusdominus-bootstrap-4.js')}}"></script>
<script src="{{asset('/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js')}}"></script>
<script src="{{asset('/vendors/daterangepicker/daterangepicker.min.js')}}"></script>
<script src="{{asset('/vendors/dropzone/dropzone.js')}}"></script>
<script src="{{asset('/vendors/jstree/jstree.min.js')}}"></script>
<script src="{{asset('/js/off-canvas.js')}}"></script>
<script src="{{asset('/js/hoverable-collapse.js')}}"></script>
<script src="{{asset('/js/template.js')}}"></script>
<script src="{{asset('/js/formpickers.js')}}"></script>
<script src="{{asset('/js/dashboard.js')}}"></script>
<script src="{{asset('/js/clipboard.js')}}"></script>
<script src="{{asset('/js/owl-carousel.js')}}"></script>
<script src="{{asset('/js/dropzone.js')}}"></script>
<script src="{{asset('/js/demo.js')}}"></script>
<script src="{{ asset('/js/file-upload.js')}}"></script>
@yield('scripts')

@yield('page_js')
<script>
  $(".alert-dismissible").fadeTo(2000, 500).slideUp(500, function () {
    $(".alert-dismissible").alert('close');
  });
  $( document ).ready(function() {
    $(".link-copy-show").click(function() {
      $('.link-copy').toggleClass('active');  
      setTimeout(function(){
            // toggle another class
            $('.link-copy').toggleClass('active');  
          },2000)
    });
  });
</script>
</html>
