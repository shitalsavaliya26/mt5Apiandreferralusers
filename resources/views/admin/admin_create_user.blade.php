@extends('layouts.admin_app')
@section('title', 'Create User')
<style>
    .error {
        color: red;
    }
</style>
@section('content')

    <form class="form-sample" method="POST" id="form" action="{{ route('store.user') }}">
        @csrf
        <div class="main-panel" style="width: 100%">
            <div class="content-wrapper">
                @if(count($errors) > 0 )
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <ul class="p-0 m-0" style="list-style: none;">
                            @foreach($errors->all() as $error)
                                {{$error}}<br/><br/>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="row">
                    <div class="col-12 grid-margin">
                        <h4>Create User</h4>
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Verify Sponsor Username</h4>
                                <div class="row">
                                    <div class="col-md-7">
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Sponser</label>
                                            <div class="col-sm-9">
                                                <input type="text" placeholder="Sponser Username" id="sponser"
                                                       name="" class="form-control"/>
                                                <input type="hidden" name="sponsor" value="{{old('sponsor')}}" id="username_sponser">
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
                                            <label class="col-sm-3 col-form-label">Full Name</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" value="{{old('full_name')}}" name="full_name"
                                                       placeholder="full name"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">User name</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" value="{{old('user_name')}}" name="user_name"
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
                                                       name="identification_number" value="{{old('identification_number')}}"
                                                       placeholder="identification number"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Phone Number</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" value="{{old('phone_number')}}" name="phone_number"
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
                                                <input type="text" class="form-control" value="{{old('address')}}" name="address"
                                                       placeholder="address"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Country</label>
                                            <div class="col-sm-9">
                                                <select class="form-control" name="country_id" value="{{old('country_id')}}">
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
                                                <input type="text" name="state" value="{{old('state')}}" class="form-control"
                                                       placeholder="state"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">City</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" value="{{old('city')}}" name="city"
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
                                                    <input type="email" value="{{old('email')}}" class="form-control" placeholder="email"
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
                                                <label class="col-sm-3 col-form-label">Repeat Security
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
                <!-- <div class="row">
                    <div class="col-12 grid-margin">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">MT5 Member Details</h4>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">MT5 Id</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" value="{{old('mt4_username')}}" name="mt4_username"
                                                       placeholder="MT5 id"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">MT5 Password</label>
                                            <div class="col-sm-9">
                                                <input type="password" class="form-control" value="{{old('mt4_password')}}" name="mt4_password"
                                                       placeholder="MT5 password"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> -->
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
                                                <input type="text" class="form-control" value="{{old('name')}}" name="name"
                                                       placeholder="bank name"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Account Holder</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" value="{{old('account_holder')}}" name="account_holder"
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
                                                <input type="text" class="form-control" value="{{old('account_number')}}" name="account_number"
                                                       placeholder="account number"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Swift Code</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" value="{{old('swift_code')}}" name="swift_code"
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
                                                <input type="text" class="form-control" value="{{old('branch')}}" name="branch"
                                                       placeholder="branch name"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Bank Country</label>
                                            <div class="col-sm-9">
                                                <select class="form-control" name="bank_country_id" value="{{old('bank_country_id')}}">
                                                    <option value="">Select</option>
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
                                            <button type="submit" class="btn btn-primary btn-lg btn-block">
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
        @endsection

        <!-- container-scroller -->
            <!-- plugins:js -->
            @section('page_js')
                <script type="text/javascript">
                    function checkSponser() {
                        $(function () {
                            $.ajax({
                                url: '{{ route('admin-check-sponsor-user') }}',
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
     $.validator.addMethod('minStrict', function (value, el, param) {
                        return value >= param;
                    },'Please enter valid digits.');               $('#form').validate({
                        // initialize the plugin
                        ignore: "",
                        rules: {
                            full_name: {
                                required: true
                            },
                            user_name: {
                                required: true
                            },
                            sponsor: {
                                required: true
                            },
                            phone_number: {
                                required: true
                            },
                            identification_number: {
                                required: true,minStrict: 1,
                                digits: true
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
                            }
                        }
                    });
                </script>
@endsection
