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
    <link rel="stylesheet" href="{{asset('/css/vertical-layout-dark/style.css')}}">
    <link rel="stylesheet" href="{{asset('/css/frontend-custom.css')}}">
    <!-- endinject -->
    <link rel="stylesheet" href="{{asset('/vendors/flag-icon-css/css/flag-icon.min.css')}}"/>
    <link rel="shortcut icon" href="{{'/images/favicon.png'}}" />
    <style>
        .error{
            color: red;
        }
        @media (max-width: 799px) and (min-width: 768px){
        .forget-pass{
          margin-top: -20px !important;
        }
    }
    </style>
</head>
<body>

<div class="container-scroller login-scrn" style="height: auto">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="content-wrapper align-items-stretch auth auth-img-bg">
            <ul class="navbar-nav ml-auto">
                <!-- Authentication Links -->
                <li class="nav-item dropdown">
                    @php $locale = session()->get('locale'); @endphp
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        <span class="caret">
                         @switch($locale)
                                @case('id')
                                <i class="flag-icon flag-icon-id" title="id" id="id"></i> Indonesian
                                @break
                                @default
                                <i class="flag-icon flag-icon-us" title="us" id="us"></i> English
                            @endswitch
                        </span>
                    </a>
                    <div class="dropdown-menu dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{url('lang/en')}}"><i
                                class="flag-icon flag-icon-us" title="us" id="us"></i> &nbspEnglish</a>
                        <a class="dropdown-item" href="{{url('lang/id')}}">
                            <i class="flag-icon flag-icon-id" title="od" id="id"></i> &nbsp;Indonesian</a>
                    </div>
                </li>
            </ul>

            <div class="row flex-grow bggray">
                <div class="login-content col-lg-6 d-flex align-items-center justify-content-center pt-4 pb-4">
                    <div class="auth-form-transparent text-left">
                        <div class="brand-logo">
                            <img src="{{ asset('images/logo.png')}}" alt="logo">
                        </div>

                        @if(session()->has('warning'))
                            <div class="alert alert-danger">
                                {{ session()->get('warning') }}
                            </div>
                        @endif
                        
                        @if($errors->any())
                            <div class="form-group row">
                                <div class="col-lg-12" style="display: contents">
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        {!! implode('', $errors->all('<div>:message</div>')) !!}
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endif
                        <h4>@lang('login.welcome')!</h4>
                        <h6 class="font-weight-light">@lang('login.back_msg')</h6>
                         @if(session()->has('success'))
                         <br>
                            <div class="alert alert-danger">
                                {{ session()->get('success') }}
                            </div>
                        @endif
                        <form class="pt-3" id="login" method="post" action="{{ route('login') }}">
                            @csrf
                            <div class="loglescroller form-group">
                                <div class="form-group">
                                    <label for="exampleInputEmail">@lang('login.uname')</label>
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
                                    <label for="exampleInputPassword">@lang('login.password')</label>
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
                            <div class="row d-flex justify-content-between align-items-center login-action-bar">
                                <div class="form-check col-sm-12 col-lg-6 col-md-6">
                                    <label class="form-check-label text-muted">
                                        <input type="checkbox" class="form-check-input">
                                        @lang('login.keep_signin')
                                    </label>
                                </div>
								<div class="col-sm-12 col-lg-6 col-md-6 forget-pass">
                                <a href="{{route('password.request') }}" class="auth-link text-black">@lang('login.forgot')</a>
								</div>
                            </div>
                            <div class="my-2">
                                <button class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn" type="submit">@lang('login.login')</button>
                                <!-- <a  href="../../index.html">LOGIN</a> -->
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-6 login-half-bg d-flex flex-row">
                </div>
            </div>
        </div>
        <!-- content-wrapper ends -->
    </div>
    <!-- page-body-wrapper ends -->
</div>
<!-- container-scroller -->
<script src="{{asset('/js/jquery-1.7.1.min.js')}}" type="text/javascript"></script>
<script src="{{asset('/js/jquery.validate.min.js')}}"></script>
<script>

    $('#login').validate({
        // initialize the plugin
        rules: {
            email: {
                required: true,
                email: false
            },
            password: {
                required: true
            },
        },
        messages:{
            email :{
                required: "@lang('app.required')",
            },
            password :{
                required: "@lang('app.required')",
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

<!-- plugins:js -->
<script src="{{asset('/vendors/js/vendor.bundle.base.js')}}"></script>
<!-- endinject -->
<!-- inject:js -->
<script src="{{asset('/js/off-canvas.js')}}"></script>
<script src="{{asset('/js/hoverable-collapse.js')}}"></script>
<script src="{{asset('/js/template.js')}}"></script>
<script src="{{asset('/js/settings.js')}}"></script>
<script src="{{asset('/js/todolist.js')}}"></script>
<!-- endinject -->

<!-- Custom js for this page-->
</body>

</html>
