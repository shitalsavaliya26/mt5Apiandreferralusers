@extends('layouts.admin_app')
@section('title', 'Create Role')

@section('content')
    <div class="main-panel">
        <div class="content-wrapper" style="padding: inherit">
            <div class="row">
                <div class="col-6 mt-5 mx-auto grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
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
                            <h4 class="card-title">Add Role</h4>
                            {{ Form::open(array('route' => 'roles.store', 'id' => 'add-role','method' => 'post'))}}
                            <div class="row">
                                <div class="form-group col-md-10">
                                    {{ Form::label('name', 'Name')}}
                                    {{Form::text('name',null,['class' => 'form-control','id' => 'title', 'placeholder'=>'Name'])}}
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="form-group col-md-6">
                                    <button type="submit" name="submit" class="col-md-6 btn btn-primary mr-2">Submit</button>
                                </div>
                                <div class="form-group col-md-6">
                                    <a class="col-md-6 btn btn-light" href="{{route('roles.index')}}">Back</a>
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
    <script>
        $('#add-role').validate({
            // initialize the plugin
            rules: {
                name: {
                    required: true
                },
            }
        });

    </script>
@endsection
