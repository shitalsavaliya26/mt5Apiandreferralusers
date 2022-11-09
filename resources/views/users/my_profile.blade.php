@extends('layouts.app')
@section('title', 'My Profile')

@section('content')
<style>
    .error {
        color: red;
    }

    .img-wrap {
        position: relative;
        ...
    }
    .img-wrap .close {
        position: absolute;
        top: 18px;
        right: 77px;
        z-index: 1100;
        color:red;                                                                          
    }
</style>
    <div class="d-block mt-30"></div>

    <div class="text-white text-center w-100 medimagebgdiv" style="background-image: url(./images/my-profile.png)">
        <h3 class="m-0 boldbultertext">@lang('my_profile.my_profile')</h3>
    </div>

    <div class="d-block mt-30"></div>

    <div class="row">
        <div class="col-12 col-xl-4">
	 
	   @if(isset($user->profile_picture) && $user->profile_picture!="")
                <div class="img-wrap">
                    <a href="" class="delete_profile"><i class="close fa fa-trash" aria-hidden="true" data-id="{{$user->id}}"></i></a>
                    <img src="{{asset('/userProfile')}}/{{$user->profile_picture}}" alt="profile" class="bigprofilepic rounded-circle">
                </div>
            @else
                
                <!-- <img src="{{asset('supports_attachments')}}/demo_profile.png" alt="profile" class="bigprofilepic rounded-circle"> -->
            @endif 

            <div class=" @if(isset($user->profile_picture) && $user->profile_picture!="" ) piccarddiv @endif card p-3" @if(isset($user->profile_picture)  && $user->profile_picture!="") @else style="margin-top:28%;" @endif>
                <div class="border-bottom text-center pb-3">
                    <h3 class="medbultertext text-white">{{$user->full_name}}</h3>
                </div>

                <div class="pt-4">
                    <p class="clearfix">
                        <span class="float-left medbultertext text-white">@lang('my_profile.mt5_id'):</span>
                        <span class="float-right regbultertext text-muted">{{$user->mt4_username!=null ? $user->mt4_username : "N/A"}}</span>
                    </p>
                    <p class="clearfix">
                        <span class="float-left medbultertext text-white">@lang('my_profile.mt5_password'):</span>
                        <span class="float-right regbultertext">{{$user->mt4_password!=null ? str_limit($user->mt4_password,12) : "N/A"}}</span>
                    </p>
                    <p class="clearfix">
                        <span class="float-left medbultertext text-white">@lang('my_profile.ranking'):</span>
                        <span
                            class="float-right regbultertext text-muted">{{$user->rank ? $user->rank->name : '-'}}</span>
                    </p>
                    <p class="clearfix">
                        <span class="float-left medbultertext text-white">@lang('dashboard.personal_investment'):</span>
                        <span class="float-right regbultertext text-muted">{{$user->total ? $user->total : '-'}}</span>
                    </p>
                    <p class="clearfix">
                        <span class="float-left medbultertext text-white">@lang('my_profile.date_joined'):</span>
                        <span class="float-right regbultertext text-muted">{{$user->created_at->format('m/d/Y')}}</span>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-12 col-xl-8 mt-4 mt-xl-0">
            <form class="forms-sample" method="post" id="form"
                  action="{{route('update-my-profile',['id' => $user->id])}}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <header class="section-title titlebottomline mt-4">
                    <h2 class="hrowheading">@lang('my_profile.p_details')</h2>
                </header>
                
                @if(session()->has('delete-image'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        {{ session()->get('delete-image') }}
                    </div>
                @endif

                @if(session()->has('message'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        {{ session()->get('message') }}
                    </div>
                @endif

                @if(count($errors) > 0 )
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <ul class="p-0 m-0" style="list-style: none;">
                            @foreach($errors->all() as $error)
                                {{$error}} <br/><br/>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInput1" class="medbultertext text-white">@lang('my_profile.full_name')</label>
                                        <input type="text" class="form-control form-control-sm" id="exampleInput1"
                                               placeholder="name" name="full_name"
                                               value="{{old('full_name',$user->full_name)}}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInput2" class="medbultertext text-white">@lang('my_profile.id_no')</label>
                                        <input type="text" class="form-control form-control-sm" id="exampleInput2"
                                               name="identification_number"
                                               value="{{old('identification_number',$user->identification_number)}}"
                                               placeholder="identification number">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInput3" class="medbultertext text-white">@lang('my_profile.email')</label>
                                        <input type="email" class="form-control form-control-sm" id="exampleInput3"
                                               placeholder="email" name="email" value="{{old('email',$user->email)}}"
                                               style="pointer-events: none;">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInput4" class="medbultertext text-white">@lang('my_profile.phone')</label>
                                        <input type="text" class="form-control form-control-sm" id="exampleInput4"
                                               placeholder="phone number" name="phone_number"
                                               value="{{old('phone_number',$user->phone_number)}}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="exampleInput20" class="medbultertext text-white">Profile</label>
                                        <input type="file" class="form-control form-control-sm" id="exampleInput20"
                                               placeholder="profile" name="profile_picture" accept=".jpg,.png.gif">
                                        <span>
                                            @if(isset($user->profile_picture) && $user->profile_picture!="" )
                                                <img src="{{asset('userProfile')}}/{{$user->profile_picture}}"height="50" width="50">
                                            @endif
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="exampleInput5" class="medbultertext text-white">@lang('my_profile.address')</label>
                                        <input type="text" class="form-control form-control-sm" id="exampleInput5"
                                               placeholder="address" name="address"
                                               value="{{old('address',$user->address)}}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="exampleInput6" class="medbultertext text-white">@lang('my_profile.city')</label>
                                        <input type="text" class="form-control form-control-sm" id="exampleInput6"
                                               placeholder="city" name="city" value="{{old('city',$user->city)}}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="exampleInput7" class="medbultertext text-white">@lang('my_profile.state')</label>
                                        <input type="text" class="form-control form-control-sm" id="exampleInput7"
                                               placeholder="state" name="state" value="{{old('state',$user->state)}}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="exampleInput8" class="medbultertext text-white">@lang('my_profile.country')</label>
                                        <select class="form-control form-control-sm" id="exampleInput8"
                                                name="country_id">
                                            <option>@lang('my_profile.country')</option>
                                            @foreach($countries as $country)
                                                <option
                                                    value="{{$country->id}}" {{$country->id == $user->country_id ? 'selected' : ''}}>{{$country->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <header class="section-title titlebottomline mt-5">
                    <h2 class="hrowheading">@lang('my_profile.bank_details')</h2>
                </header>
                <div class="grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInput9" class="medbultertext text-white">@lang('my_profile.bank_name')</label>
                                        <input type="text" class="form-control form-control-sm" id="exampleInput9"
                                               placeholder="bank name" name="name"
                                               value="{{old('name',$userBank->name)}}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInput10" class="medbultertext text-white">@lang('my_profile.acc_holder')</label>
                                        <input type="text" class="form-control form-control-sm" id="exampleInput10"
                                               placeholder="account holder name" name="account_holder"
                                               value="{{old('account_holder',$userBank->account_holder)}}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInput11" class="medbultertext text-white">@lang('my_profile.acc_no')</label>
                                        <input type="text" class="form-control form-control-sm" id="exampleInput11"
                                               placeholder="account number" name="account_number"
                                               value="{{old('account_number',$userBank->account_number)}}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInput12" class="medbultertext text-white">@lang('my_profile.swift_code')</label>
                                        <input type="text" class="form-control form-control-sm" id="exampleInput12"
                                               placeholder="swift code" name="swift_code"
                                               value="{{old('swift_code',$userBank->swift_code)}}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInput13" class="medbultertext text-white">@lang('my_profile.branch')</label>
                                        <input type="text" class="form-control form-control-sm" id="exampleInput13"
                                               placeholder="branch" name="branch"
                                               value="{{old('branch',$userBank->branch)}}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInput14" class="medbultertext text-white">@lang('my_profile.bank_country')</label>
                                        <select class="form-control form-control-sm" id="exampleInput8"
                                                name="bank_country_id">
                                            <option>@lang('my_profile.bank_country')</option>
                                            @foreach($countries as $country)
                                                <option
                                                    value="{{$country->id}}" {{$country->id == $userBank->bank_country_id ? 'selected' : ''}}>{{$country->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <header class="section-title titlebottomline mt-5">
                    <h2 class="hrowheading">@lang('my_profile.acc_details')</h2>
                </header>
                <div class="grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInput15" class="medbultertext text-white">@lang('my_profile.username')</label>
                                        <input type="text" class="form-control form-control-sm"
                                               style="pointer-events: none;" id="exampleInput15" placeholder="user name"
                                               name="user_name" value="{{old('user_name',$user->user_name)}}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInput16" class="medbultertext text-white">@lang('my_profile.login_password')</label>
                                        <input type="password" class="form-control form-control-sm" id="exampleInput16"
                                               placeholder="password" name="password">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInput17" class="medbultertext text-white">@lang('my_profile.repeat_password')</label>
                                        <input type="password" class="form-control form-control-sm" id="exampleInput17"
                                               placeholder="repeat password" name="password_confirmation">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInput18" class="medbultertext text-white">@lang('my_profile.security_password')</label>
                                        <input type="password" class="form-control form-control-sm" id="exampleInput18"
                                               placeholder="security password" name="secure_password">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInput19" class="medbultertext text-white">@lang('my_profile.repeat_security_password')</label>
                                        <input type="password" class="form-control form-control-sm" id="exampleInput19"
                                               placeholder="repeat security password"
                                               name="secure_password_confirmation">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-md-12 text-right">
                        <button type="submit" class="btn btn-primary text-uppercase">@lang('my_profile.update_profile')</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('page_js')
    <script src="{{asset('/js/jquery-1.7.1.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('/js/jquery.validate.min.js')}}"></script>
    <script src="http://jqueryvalidation.org/files/dist/additional-methods.min.js"></script>
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

                phone_number: {
                    required: true
                },
                identification_number: {
                    required: true,
                    digits: true
                },
                address: {
                    required: true
                },
                profile_picture: {
                    // required: true,
                    extension: "jpg|jpeg|png"
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
            },
            messages:{
                profile_picture : {
                    extension : "Please upload only image file"
                }   
            }
        });

        $('.delete_profile').click(function(){
            if (confirm('Are you sure you want to delete profile image?')) {
                var newsrc = "{{route('delete-profile-image')}}";
                $(this).attr('href', newsrc);
            }
        });
    </script>
@endsection



