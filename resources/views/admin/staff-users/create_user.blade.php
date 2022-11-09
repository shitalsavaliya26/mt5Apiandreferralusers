@extends('layouts.admin_app')
@section('title', 'Create User')
@section('content')

<style>
    .error {
        color: red;
    }
    .select2-container--default .select2-selection--single {
        background-color: #2b2e4c!important;
        height: auto!important;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 14px!important;    
        color: #e9e6e6!important;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        top: 10px!important;
    }
</style>
<link rel="stylesheet" href="{{asset('vendors/select2/select2.min.css')}}">
<link rel="stylesheet" href="{{asset('vendors/select2-bootstrap-theme/select2-bootstrap.min.css')}}">
    <div class="main-panel">
        <div class="content-wrapper" style="padding: inherit">
            <div class="row">
                <div class="col-6 mt-5 mx-auto grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body ml-5">
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
                            <h4 class="card-title">Add Staff User</h4>
                            {{ Form::open(array('route' => 'staff-users.store', 'id' => 'add-user','method' => 'post'))}}
                            <div class="row">
                                <div class="form-group col-md-10">
                                    {{ Form::label('user_name', 'User Name')}}
                                    {{Form::text('user_name',null,['class' => 'form-control','id' => 'title', 'placeholder'=>'Name'])}}
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-10">
                                    {{ Form::label('email', 'Email')}}

                                    {{ Form::email('email', null,array('id' => 'email', "class" => "form-control")) }}
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-10">
                                    {{ Form::label('password', 'Password')}}

                                    {{ Form::password('password', array('id' => 'password', "class" => "form-control", "autocomplete" => "off")) }}
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-10">
                                    {{ Form::label('confirm_password', ' Confirm Password')}}

                                    {{ Form::password('password_confirmation', array('id' => 'confirm-password', "class" => "form-control", "autocomplete" => "off")) }}
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-10">
                                    {{Form::label('Roles', 'Roles')}}
                                    {{Form::select('roles[]',$roles,null,['class' => 'form-control roles-select','id' => 'roles'])}}
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="form-group col-md-6">
                                    <button type="submit" name="submit" class="col-md-6 btn btn-primary mr-2">Submit
                                    </button>
                                </div>
                                <div class="form-group col-md-6">
                                    <a class="col-md-6 btn btn-light" href="{{route('staff-users.index')}}">Back</a>
                                    {{Form::close()}}
                                </div>
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
    <script src="{{asset('/js/jquery-1.7.1.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('/js/jquery.validate.min.js')}}"></script>
    <script src="{{asset('/vendors/select2/select2.min.js')}}"></script>

    <script>
        $('#add-user').validate({
            // initialize the plugin
            rules: {
                name: {
                    required: true
                },
                password: {
                    required: true
                },
                email: {
                    required: true,
                    email: true
                },
                password_confirmation: {
                    required: true
                },
            }
        });
        $(".roles-select").select2();
    </script>

@endsection
