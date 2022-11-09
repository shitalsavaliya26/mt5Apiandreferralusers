<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Avanaya</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="{{ asset('/vendors/ti-icons/css/themify-icons.css') }}">

    <link rel="stylesheet" href="{{ asset('/vendors/css/vendor.bundle.base.css')}}">
    <!-- endinject -->
    <!-- inject:css -->
    <link rel="stylesheet" href="{{ asset('/css/vertical-layout-dark/style.css')}}">
    <link rel="stylesheet" href="{{asset('/css/frontend-custom.css')}}">
    <!-- endinject -->
    <link rel="shortcut icon" href="{{asset('/images/favicon.png')}}" />
</head>
<style>
    .error{
        color: red;
    }
</style>
<body>
<div class="container-scroller" style="height: auto">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="content-wrapper d-flex align-items-center auth px-0 auth-img-bg cus-full-vh">
            <div class="row w-100 mx-0">
                <div class="col-lg-4 mx-auto">
                    <div class="auth-form-dark text-left py-5 px-lg-4  px-md-4">
                        <div class="brand-logo">
                            <img src="{{asset('/images/logo.png')}}" alt="logo">
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-12">
                                @if($errors->any())
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        {!! implode('', $errors->all('<div>:message</div>')) !!}
                                    </div>
                                @endif
                            </div>
                            @if (session('status'))
                                <p class="alert alert-success">{{ session('status') }}</p>
                            @endif
                        </div>
                        <h4>@lang('login.forgot_password')</h4>
                        <h6 class="font-weight-light">@lang('login.reset_link')</h6>
                        <br/>
                        <form method="POST" action="{{ route('password.email') }}" id="forgot">
                            @csrf
                            <div class="form-group">
                                <input type="email" name="email" class="form-control form-control-lg" id="exampleInputEmail1" placeholder="@lang('login.enter_email')">
                                <span id="error-password"></span>
                            </div>
                           
                            <div class="mt-3">
                                <button type="submit" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">@lang('login.send_link')</button>
                            </div>
                            <br/>
                            <a href="{{route('login') }}" class="auth-link text-black"><i class="ti ti-power-off"></i> @lang('login.login')</a>
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

<!-- endinject -->
</body>

</html>
<script src="{{asset('/js/jquery-1.7.1.min.js')}}" type="text/javascript"></script>
<script src="{{asset('/js/jquery.validate.min.js')}}"></script>
<script>
    $('#forgot').validate({
        // initialize the plugin
        rules: {
            email: {
                required: true,
                email: false
            },
        },
    });

</script>
