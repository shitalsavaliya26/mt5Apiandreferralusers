<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Avanya</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="{{ asset('/vendors/ti-icons/css/themify-icons.css') }}">

    <link rel="stylesheet" href="{{ asset('/vendors/css/vendor.bundle.base.css')}}">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="{{ asset('/css/vertical-layout-dark/style.css')}}">
    <!-- endinject -->
    <link rel="shortcut icon" href="{{asset('/images/favicon.png')}}" />
    <style type="text/css">
        .error{
            border-color: #dc3545!important;
            padding-right: calc(1.5em + .75rem)!important;
            background-size: calc(.75em + .375rem) calc(.75em + .375rem)!important;
            color: red!important;

        }
        .valid{
            border-color: #28a745!important;
            padding-right: calc(1.5em + .75rem);
            background-repeat: no-repeat;
            background-position: center right calc(.375em + .1875rem);
            background-size: calc(.75em + .375rem) calc(.75em + .375rem);
        }
    </style>
</head>

<body>
<div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="content-wrapper d-flex align-items-center auth px-0">
            <div class="row w-100 mx-0">
                <div class="col-lg-4 mx-auto">
                    <div class="auth-form-dark text-left py-5 px-4 px-sm-5">
                        <div class="brand-logo">
                            <img src="{{asset('/images/logo.png')}}" alt="logo">
                        </div>

                        <h4>Reset password</h4>
                        <div class="form-group row">
                            <div class="col-lg-12">
                                @if($errors->any())
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    {!! implode('', $errors->all('<div>:message</div>')) !!}
                                    </div>
                                @endif
                            </div>
                        </div>
                        <form method="POST" action="{{ route('password.update') }}" id="resetForm">
                            @csrf
                            <input type="hidden" name="token" value="{{ $token }}">
                            <div class="form-group">
                                <input type="email" style="color:black;" name="email" class="form-control text-white form-control-lg @error('email') is-invalid @enderror"  value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus id="exampleInputEmail1" placeholder="Email address">
                            </div>
                            <div class="form-group">
                                <input type="password" style="color:black;" name="password" class="form-control text-white form-control-lg @error('password') is-invalid @enderror" required autocomplete="new-password" id="password" placeholder="Password">
                            </div>
                            <div class="form-group">
                                <input type="password" style="color:black;" name="password_confirmation" class="form-control text-white form-control-lg" required autocomplete="new-password" id="exampleInputPassword1" placeholder="Confirm Password">

                            </div>
                            <div class="mt-3">
                                <button  type="submit" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">Reset</button>
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

<!-- endinject -->
</body>
<script src="{{asset('/js/jquery-1.7.1.min.js')}}" type="text/javascript"></script>
<script src="{{asset('/js/jquery.validate.min.js')}}"></script>
<script>
    $('#resetForm').validate({
        rules: {
            email: {
                required: true,
                email: true
            },
            password: {
                required: true
            },
            password_confirmation: {
                required: true,
                equalTo: "#password"
            },
        },
        messages : {
            password_confirmation: {
                equalTo: "Password and confirm password does not match"
            }
        }
    });
</script>
</html>
