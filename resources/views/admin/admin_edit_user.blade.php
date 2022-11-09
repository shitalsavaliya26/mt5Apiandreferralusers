@extends('layouts.admin_app')
@section('title', 'Edit User')
<style>
    .error {
        color: red;
    }
</style>
@section('content')
    <form class="form-sample" method="POST" id="form" action="{{ route('update.user',['id' => $user->id])}}">
        @csrf
        @method('PUT')
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
                
                <div style="">
                    <a class="btn btn-outline-primary" href="{{route('admin.users')}}">Back</a>
                </div>
                <br>
                <div class="row">
                    <div class="col-12 grid-margin">
                        <h4>Edit User</h4>
                    </div>
                </div>
                @if(Session::has('error') )
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        {{Session::get('error')}}
                    </div>
                @endif
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
                                            <label class="col-sm-3 col-form-label">Sponser</label>
                                            <div class="col-sm-9">
                                                <input type="text" placeholder="Sponser Username" id="sponser"
                                                       name="sponsor" value="{{isset($sponsor->user_name) ? $sponsor->user_name : ''}}" class="form-control" onblur="checkSponser();" />
                                                <div id="response_message"></div>
						                        <input type="hidden" name="sponsorUser" value="{{isset($sponsor->id) ? $sponsor->id : 0}}" id="username_sponser">
                                            </div>
                                        </div>
                                    </div>  
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Full Name</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control"
                                                       value="{{old('full_name',$user->full_name)}}" name="full_name"
                                                       placeholder="full name"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Username</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control"
                                                       value="{{old('user_name',$user->user_name)}}" name="user_name"
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
                                                <input type="text" class="form-control"
                                                       name="identification_number"
                                                       value="{{old('identification_number',$user->identification_number)}}"
                                                       placeholder="identification number"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Phone Number</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control"
                                                       value="{{old('phone_number',$user->phone_number)}}"
                                                       name="phone_number"
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
                                                <input type="text" class="form-control"
                                                       value="{{old('address',$user->address)}}"
                                                       name="address"
                                                       placeholder="address"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Country</label>
                                            <div class="col-sm-9">
                                                <select class="form-control" name="country_id">
                                                    <option>Select</option>
                                                    @foreach($countries as $country)
                                                        <option value="{{$country->id}}" {{$country->id == $user->country_id ? 'selected' : ''}}>{{$country->name}}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">State</label>
                                            <div class="col-sm-9">
                                                <input type="text"value="{{old('state',$user->state)}}" name="state" class="form-control"placeholder="state"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">City</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" name="city"
                                                       value="{{old('state',$user->state)}}"
                                                       value="{{old('city',$user->city)}}"

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
                                                    <input type="email"
                                                           value="{{old('email',$user->email)}}"
                                                           class="form-control" placeholder="email"
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
                <div class="row">
                    <div class="col-12 grid-margin">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">MT5 Member Details</h4>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">MT5 Id</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" name="mt4_username"
                                                       placeholder="MT5 id"
                                                       value="{{old('mt4_username',$user->mt4_username)}}" readonly="" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">MT5 Password</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" name="mt4_password"
                                                       placeholder="MT5 password" value="{{old('mt4_password',$user->mt4_password)}}" readonly />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Rank</label>
                                            <div class="col-sm-9">
                                                {!! Form::select('rank_id',$ranks,old('rank_id',@$user->rank_id),['class'=>'form-control']) !!}
                                                 <span class="help-block text-danger">{{ $errors->first('rank_id') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-form-label" style="margin-left: 30px;">Fixed Rank</label>
                                        <div class="col m-2">
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input type="radio" class="form-check-input" name="fixed_rank"
                                                           id="inactive"
                                                           value="1" {{(old('status',$user->fixed_rank) == '1') ? 'checked' : ''}}>
                                                    Yes
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col m-2">
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input type="radio" class="form-check-input" name="fixed_rank"
                                                           id="active"
                                                           value="0" {{(old('status',$user->fixed_rank) == '0') ? 'checked' : ''}}>
                                                    No
                                                </label>
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
                                                <input type="text" class="form-control"
                                                       value="{{old('name',$userBank->name)}}"
                                                       name="name"
                                                       placeholder="bank name"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Account Holder</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control"
                                                       value="{{old('account_holder',$userBank->account_holder)}}"
                                                       name="account_holder"
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
                                                <input type="text"
                                                       value="{{old('account_number',$userBank->account_number)}}"
                                                       class="form-control" name="account_number"
                                                       placeholder="account number"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Swift Code</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control"
                                                       value="{{old('swift_code',$userBank->swift_code)}}"
                                                       name="swift_code"
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
                                                <input type="text"
                                                       value="{{old('branch',$userBank->branch)}}"
                                                       class="form-control" name="branch"
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
                                                        <option
                                                            value="{{$country->id}}" {{$country->id == $userBank->bank_country_id ? 'selected' : ''}}>{{$country->name}}</option>
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
                                                Update User
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

            @section('page_js')
                <script type="text/javascript">
                    function checkSponser() {
                        $(function () {
                            var val = $("#sponser").val();
                        if (val != '') {
                            $(function () {
                                $.ajax({
                                    url: '{{ route('admin-check-sponsor-user-exists') }}',
                                    data: {
                                       user_name: $("#sponser").val(),
					                   user_id : "{{$user->id}}"
                                    },
                                    dataType: 'json',
                                    success: function (data) {

                                        if (data.status == 'success') {
                                            $('#response_message').html("<span style='color:#3CB371;font-weight:bold;'>" +
                                                data.message + "</span></div>");
                                            $('#username_sponser').val(data.user_id);
                                        } else {
                                            $("#sponser").val('');
                        $("#sponser").focus();  
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
                        });
                    }
                </script>
                <script src="{{asset('/js/jquery-1.7.1.min.js')}}" type="text/javascript"></script>
                <script src="{{asset('/js/jquery.validate.min.js')}}"></script>
                <script>
                    $('#form').validate({
                        // initialize the plugin
                        rules: {
                            full_name: {
                                required: true
                            },
                            user_name: {
                                required: true
                            },
                            sponsor: {
                                // required: true
                            },
                            phone_number: {
                                required: true
                            },
                            identification_number: {
                                required: true,
                                digits:true
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
                        }
                    });
                </script>
@endsection
