<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Avanya</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="{{ asset('/vendors/ti-icons/css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('/vendors/css/vendor.bundle.base.css') }}">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="{{ asset('/vendors/select2/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/vendors/select2-bootstrap-theme/select2-bootstrap.min.css') }}">
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="{{ asset('/css/horizontal-layout-dark/style.css')}}">
    <!-- endinject -->
    <link rel="shortcut icon" href="{{ asset('/images/favicon.png')}}"/>
<style>
    .error{
        color:red;
    }
</style>
</head>

<body>
<div class="container-scroller">
    <!-- partial:../../partials/_horizontal-navbar.html -->
    <div class="horizontal-menu">
        <nav class="bottom-navbar">
            <div class="container">
                <ul class="nav page-navigation">
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="ti-home menu-icon"></i>
                            <span class="menu-title"><h3>Avanya</h3></span>
                            <h5>&nbsp;&nbsp;Sign up </h5>
                            <h6>&nbsp;: Enter your details to create your account</h6>
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>

    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
        <form class="form-sample" method="POST" id="form" action="{{ route('register') }}">
            @csrf
            <div class="main-panel">
                @if(session()->has('message'))
                    <div class="alert alert-success">
                        {{ session()->get('message') }}
                    </div>
                @endif
                <div class="content-wrapper">
                    <div class="row">
                        <div class="col-12 grid-margin">
                            @if(count($errors) > 0 )
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    <ul class="p-0 m-0" style="list-style: none;">
                                        @foreach($errors->all() as $error)
                                            <li>{{$error}}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Verify Sponsor Username</h4>
                                    <div class="row">
                                        <div class="col-md-7">
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Sponser</label>
                                                <div class="col-sm-9">
                                                    <input type="text" placeholder="Sponser Username" id="sponser" name="" class="form-control"/>
                                                    <input type="hidden" name="sponser_name" value="" id="username_sponser">
                                                    <div id="response_message"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group row">
                                                <button type="button" onclick='checkSponser()'
                                                        class="btn btn-primary btn-lg btn-block"
                                                        style="height: 20px;padding:22px;float: right;">
                                                    VERIFY SPONSER USERNAME
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 grid-margin">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Enter your personal details</h4>

                                    <p class="card-description">
                                        Personal info
                                    </p>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label full_name">Full Name</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="full_name"
                                                           placeholder="full name"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">User Name</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="user_name"
                                                           placeholder="user name"/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Identification Number</label>
                                                <div class="col-sm-9">
                                                    <input type="number" class="form-control"
                                                           name="identification_number"
                                                           placeholder="identification number"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Phone Number</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="phone_number"
                                                           placeholder="phone number"/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <p class="card-description">
                                        Address
                                    </p>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Address </label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="address"
                                                           placeholder="address"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Country</label>
                                                <div class="col-sm-9">
                                                    <select class="form-control" name="country_id">
                                                        <option value="">Select</option>
                                                    @foreach($countries as $country)
                                                            <option value="{{$country->id}}">{{$country->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">State</label>
                                                <div class="col-sm-9">
                                                    <input type="text" name="state" class="form-control"
                                                           placeholder="state"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">City</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="city"
                                                           placeholder="city"/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 grid-margin">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Enter your account details</h4>
                                    <form class="form-sample">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-sm-3 col-form-label">Email</label>
                                                    <div class="col-sm-9">
                                                        <input type="email" class="form-control" placeholder="email"
                                                               name="email"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-sm-3 col-form-label">Login Password</label>
                                                    <div class="col-sm-9">
                                                        <input type="password" class="form-control" name="password"
                                                               placeholder="password"/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-sm-3 col-form-label">Repeat Password</label>
                                                    <div class="col-sm-9">
                                                        <input type="password" name="password_confirmation"
                                                               class="form-control" placeholder="repeat password"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-sm-3 col-form-label">Security Password</label>
                                                    <div class="col-sm-9">
                                                        <input type="password" name="secure_password"
                                                               class="form-control" placeholder="security password"/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-sm-3 col-form-label">Repeat Secutity
                                                        Password </label>
                                                    <div class="col-sm-9">
                                                        <input type="password" name="secure_password_confirmation"
                                                               class="form-control"
                                                               placeholder="repeat security password"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 grid-margin">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">MT4 Member Details</h4>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">MT4 Id</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="mt4_username"
                                                   placeholder="mt 4 id"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">MT4 Password</label>
                                        <div class="col-sm-9">
                                            <input type="password" class="form-control" name="mt4_password"
                                                   placeholder="mt 4 password"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 grid-margin">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Enter your bank details</h4>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Bank Name</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="name"
                                                           placeholder="bank name"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Account Holder</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="account_holder"
                                                           placeholder="account holder"/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Account Number</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="account_number"
                                                           placeholder="account number"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Swift Code</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="swift_code"
                                                           placeholder="swift code"/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Bank Branch</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="branch"
                                                           placeholder="branch name"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Bank Country</label>
                                                <div class="col-sm-9">
                                                    <select class="form-control" name="bank_country_id">
                                                        <option>Select</option>
                                                        @foreach($countries as $country)
                                                            <option value="{{$country->id}}">{{$country->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4 mx-auto">
                                            <div class="form-group row">
                                                <button type="submit" class="btn btn-primary btn-lg btn-block" id="register">
                                                    Register
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>

                </div>
                <!-- content-wrapper ends -->
                <!-- partial:../../partials/_footer.html -->
                <footer class="footer">
                    <div class="w-100 clearfix">
                        <span class="text-muted d-block text-center text-sm-left d-sm-inline-block">Copyright © 2018 <a
                                href="#" target="_blank">Urbanui</a>. All rights reserved.</span>
                        <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Hand-crafted & made with <i
                                class="ti-heart text-danger ml-1"></i></span>
                    </div>
                </footer>
                <!-- partial -->
            </div>
            <!-- main-panel ends -->
        </form>
    </div>

    <!-- page-body-wrapper ends -->
</div>
<!-- container-scroller -->
<!-- plugins:js -->
<script type="text/javascript">
    function checkSponser() {
        $(function () {
            $.ajax({
                url: '{{ route('check-secure-password') }}',
                data: {
                    user_name: $("#sponser").val(),
                },
                dataType: 'json',
                success: function (data) {
                    if (data.status == 'success') {
                        $('#response_message').html("<span style='color:#3CB371;font-weight:bold;'>" +
                            data.message + "</span></div>");
                        $('#username_sponser').val(data.user_id);
                    } else {
                        $('#response_message').html("<span style='color:#8B0000;font-weight:bold;'>" +
                            data.message + "</span></div>");
                    }
                },

                errors: function (message) {
                    ('#response_message').html("<span style='color:#8B0000;font-weight:bold;'> Something went wrong </span></div>");
                }
            });
        });
    }
</script>
<script src="{{asset('/js/jquery-1.7.1.min.js')}}" type="text/javascript"></script>
<script src="{{asset('/js/jquery.validate.min.js')}}"></script>
<script>
    $('#form').validate({
        // initialize the plugin
        ignore: "",
        rules: {
            full_name: {
                required: true
            },
            user_name: {
                required: true
            },
            sponser_name: {
                required: true
            },
            phone_number: {
                required: true
            },
            identification_number: {
                required: true
            },
            address: {
                required: true
            },
            city: {
                required: true
            },

            state: {
                required: true
            },
            country_id: {
                required: true
            },
            email: {
                required: true
            },
            password: {
                required: true
            },
            secure_password: {
                required: true
            },

            branch: {
                required: true
            },
            name: {
                required: true
            },
            account_number: {
                required: true
            },
            account_holder: {
                required: true
            },
            swift_code: {
                required: true
            },
            bank_country_id: {
                required: true
            },
            mt4_username: {
                required: true
            },
            mt4_password: {
                required: true
            },
        }
    });
</script>
<script src=" {{ asset('/vendors/js/vendor.bundle.base.js') }}"></script>
<!-- endinject -->
<!-- Plugin js for this page -->
<script src="{{ asset('/vendors/typeahead.js/typeahead.bundle.min.js')}}"></script>
<script src="{{ asset('/vendors/select2/select2.min.js') }}"></script>
<!-- End plugin js for this page -->
<!-- inject:js -->
<script src="{{ asset('/js/off-canvas.js') }}"></script>
<script src="{{asset('/js/hoverable-collapse.js')}}"></script>
<script src="{{ asset('/js/template.js') }}"></script>
<script src="{{ asset('/js/settings.js')}}"></script>
<script src="{{ asset('/js/todolist.js') }}"></script>
<!-- endinject -->
<!-- Custom js for this page-->
<script src=" {{ asset('/js/file-upload.js')}}"></script>
<script src="{{ asset('/js/typeahead.js') }}"></script>
<script src="{{ asset('/js/select2.js') }}"></script>
<!-- End custom js for this page-->
</body>
</html>
