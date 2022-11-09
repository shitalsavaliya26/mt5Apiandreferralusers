
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Login - Avanya</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="{{asset('/vendors/ti-icons/css/themify-icons.css')}}">
    <link rel="stylesheet" href="{{asset('/vendors/css/vendor.bundle.base.css')}}">
    <!-- inject:css -->
    <link rel="stylesheet" href="{{asset('/css/vertical-layout-light/style.css')}}">
    <link rel="stylesheet" href="{{asset('/css/frontend-custom.css')}}">
    <!-- endinject -->
    <link rel="shortcut icon" href="{{asset('images/favicon.png')}}" />
    <style>
        .error{
            color: red;
        }
    </style>
</head>

<body>
<div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="content-wrapper d-flex align-items-center auth px-0 bggray">
            <div class="row flex-grow bggray">
                <div class="col-lg-6 d-flex align-items-center justify-content-center mx-auto pt-4 pb-4">
                    <div class="auth-form-light text-left py-3 px-4 px-sm-5">
                        <div class="brand-logo">
                            <img src="{{ asset('images/logo.png')}}" alt="logo">
                        </div>
                        @if($errors->any())
                            <div class="form-group row">
                                <div class="col-lg-12">
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        {!! implode('', $errors->all('<div>:message</div>')) !!}
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endif
                        <h4>Welcome back! Admin Login</h4>
                        <form class="pt-3" id="login" method="post" action="{{ route('admin.login') }}">
                            @csrf
                            <div class=" form-group">
                                <div class="form-group">
                                    <label for="exampleInputEmail">Username</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend bg-transparent">
                        <span class="input-group-text bg-transparent border-right-0">
                          <i class="ti-user text-primary"></i>
                        </span>
                                        </div>
                                        <input type="email" class="form-control form-control-md border-left-0" id="exampleInputEmail" placeholder="Username" name="email">
                                    </div>
                                    <span id="error-display"></span>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword">Password</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend bg-transparent">
                        <span class="input-group-text bg-transparent border-right-0">
                          <i class="ti-lock text-primary"></i>
                        </span>
                                        </div>
                                            <input type="password" class="form-control form-control-md border-left-0" id="exampleInputPassword" placeholder="Password" name="password">
                                    </div>
                                    <span id="error-password"></span>

                                </div>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="form-check">
                                    <label class="form-check-label text-muted">
                                        <input type="checkbox" class="form-check-input">
                                        Keep me signed in
                                    </label>
                                </div>
                            </div>
                            <div class="my-2">
                                <button class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn" type="submit">LOGIN</button>
                                <!-- <a  href="../../index.html">LOGIN</a> -->
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- content-wrapper ends -->
    </div>
    <!-- page-body-wrapper ends -->
</div>
<!-- container-scroller -->


<!-- plugins:js -->
<script src="{{asset('/vendors/js/vendor.bundle.base.js')}}"></script>
<!-- endinject -->
<!-- Plugin js for this page -->
<!-- End plugin js for this page -->
<!-- inject:js -->
<script src="{{asset('/js/off-canvas.js')}}"></script>
<script src="{{asset('/js/hoverable-collapse.js')}}"></script>
<script src="{{asset('/js/template.js')}}"></script>
<script src="{{asset('/js/settings.js')}}"></script>
<script src="{{asset('/js/todolist.js')}}"></script>
<script src="{{asset('/js/jquery-1.7.1.min.js')}}" type="text/javascript"></script>
<script src="{{asset('/js/jquery.validate.min.js')}}"></script>
<script>
    $('#login').validate({
        // initialize the plugin
        rules: {
            email: {
                required: true,
                email:false
            },
            password: {
                required: true
            },
        },
        messages:{
          email :{
              required: "This field is required",
          },
            password :{
                required: "This field is required",
            }
    },
        errorPlacement: function(error, element){
            if(element.attr("name") == "email"){
                error.appendTo($('#error-display'));
            }else if(element.attr("name") == "password"){
                error.appendTo($('#error-password'));
            }
        }
    });

</script>
<!-- endinject -->

<!-- Custom js for this page-->
</body>

</html>
