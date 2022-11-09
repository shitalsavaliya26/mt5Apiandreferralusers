@extends('layouts.admin_app')
@section('title', 'ShareHolder List')
<style>
    .error {
        color: red;
    }
</style>
@section('content')
    <div class="main-panel">
        <div class="content-wrapper">
            @if(session()->has('message'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    {{ session()->get('message') }}
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            <h4 class="font-weight-bold">Create New ShareHolder</h4>
           
            <div id="response_message"></div>

            <div class="card">
                <div class="card-body">
                    {!! Form::open(['route' => 'share-holder.store','autocomplete'=>'false','files'=>true,'id'=>'share-form','method'=>'post']) !!}
                    <div class="row">
                        <div class="col-12">
                            <h4 class="card-title">ShareHolder details</h4>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group row  mb-0">
                                        <label class="col-sm-3 col-form-label mb-0">Full Name</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" value="{{old('full_name')}}" name="full_name"
                                                   placeholder="ShareHolder Name"/>
                                            <span class="help-block text-danger">{{ $errors->first('full_name') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group row  mb-0">
                                        <label class="col-sm-3 col-form-label  mb-0">Percent</label>
                                        <div class="col-sm-10">
                                            <input type="number" class="form-control" value="{{old('percent')}}" name="percent"
                                                   placeholder="ShareHolder Percent" step="0.1" max="{{$sharePercent}}" min="0" />
                                            <span class="help-block text-danger">{{ $errors->first('percent') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    </div>                    
                    <br>
                    <button type="submit" name="submit" class="btn btn-primary mr-2">Submit</button>
                    <a class="btn btn-light" href="{{route('share-holder.index')}}">Back</a>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    @endsection
    <!-- plugins:js -->
        @section('page_js')
            <script src="{{asset('/js/jquery-1.7.1.min.js')}}" type="text/javascript"></script>
            <script src="{{asset('/js/jquery.validate.min.js')}}"></script>
            <script src="{{asset('/js/bootstrap4-toggle.min.js')}}"></script>
            <script>
                 $('#share-form').validate({
                        // initialize the plugin
                        ignore: "",
                        rules: {
                            full_name: {
                                required: true
                            },
                            percent: {
                                required: true,
                                digits: true
                            },
                        },
                        messages:{
                            full_name: {
                                required: "Full name is required"
                            },
                            percent: {
                                required: "Percent value must be required",
                                digits: "Only digit value is allowed"
                            },
                        }
                    });
                $(function () {
                    $('.toggle-class').change(function () {
                        var status = $(this).prop('checked') == true ? 'active' : 'in-active';
                        var user_id = $(this).data('id');

                        $.ajax({
                            type: "GET",
                            dataType: "json",
                            url: '{{route('update-user-status')}}',
                            data: {'status': status, 'user_id': user_id},
                            success: function (data) {
                                if (data.status == 'success') {
                                    $('#response_message').html("<div class='alert alert-success alert-dismissible fade show' role='alert'>" +
                                        "<button type='button' class='close' data-dismiss='alert' aria-label='Close'>" +
                                        "<span aria-hidden='true'>&times;</span> </button> Status updated </div>");
                                }
                            }
                        });
                    })
                })
            </script>
@endsection
