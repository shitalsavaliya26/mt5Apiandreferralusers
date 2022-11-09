
<script src="{{ asset('/vendors/js/vendor.bundle.base.js')}}"></script>
<!-- endinject -->
<!-- Plugin js for this page -->
<script src="{{ asset('/vendors/chart.js/Chart.min.js')}}"></script>
<!-- End plugin js for this page -->
<!-- inject:js -->
<script src=" {{ asset('/js/off-canvas.js')}}"></script>
<script src="{{ asset('/js/hoverable-collapse.js')}}"></script>
<script src="{{ asset('/js/template.js') }}"></script>
<script src="{{ asset('/js/settings.js') }}"></script>
<script src="{{ asset('/js/todolist.js')}}"></script>
<script src="{{ asset('/js/file-upload.js')}}"></script>

<!-- Custom js for this page-->
<script src="{{ asset('/js/dashboard.js')}}"></script>

<script src="{{ asset('/vendors/datatables.net/jquery.dataTables.js')}}"></script>
<script src="{{ asset('/vendors/datatables.net-bs4/dataTables.bootstrap4.js')}}"></script>

<script>
    $(".alert-dismissible").fadeTo(2000, 500).slideUp(500, function(){
        $(".alert-dismissible").alert('close');
    });

</script>
