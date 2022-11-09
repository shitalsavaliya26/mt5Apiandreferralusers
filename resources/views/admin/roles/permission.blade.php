@extends('layouts.admin_app')
@section('title', 'Create Role')
@section('content')

    <div class="main-panel">
        <div class="content-wrapper">
            <h4 class="font-weight-bold mt-3">Add/Edit Permission</h4>
            <br/>
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

            @if(session()->has('message'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    {{ session()->get('message') }}
                </div>
            @endif
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            {{ Form::open(array('url' => route('assign-permission',['id' => $role->id]), 'id' => 'add-role','method' => 'post'))}}
                            <strong>Permission:</strong>
                                    <br/><br/>
                            <div class="row">                                    
                                    @foreach($permission as $value)
                                        @if($value->parent_id)
                                            <div class="col-md-3 row">
                                                <div class="form-group ml-auto col-md-10">
                                                    <div class="custom-control custom-checkbox">
                                                        {{ Form::checkbox('permissions[]', $value->id,  in_array($value->id, $rolePermissions) ? true : false, array('data-data_id' =>$value->id,'class' => 'custom-control-input selected-'.$value->parent_id,'id' => 'check-'.$value->id))}}
                                                        <label class="custom-control-label"
                                                               for="check-{{$value->id}}">{!! str_replace('_', ' ', $value->name) !!}</label>
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                        <div class="form-group mr-auto col-md-12">
                                                <div class="custom-control custom-checkbox">
                                                    {{ Form::checkbox('permissions[]', $value->id,  in_array($value->id, $rolePermissions) ? true : false, array('class' => 'custom-control-input check-all','id' => 'check-'.$value->id))}}
                                                    <label class="custom-control-label"
                                                           for="check-{{$value->id}}">{!! str_replace('_',' ',$value->name)!!}</label>
                                                </div>
                                        </div>
                                        <hr>
                                        @endif
                                    @endforeach
                            </div>
                            <div class="row mt-2">
                                <div class="form-group offset-md-4 col-md-2">
                                    <button type="submit" name="submit" class="col-md-12 btn btn-primary mr-2">Submit
                                    </button>
                                </div>
                                <div class="form-group col-md-2">
                                    <a class="col-md-12 btn btn-light" href="{{route('roles.index')}}">Back</a>
                                    {{Form::close()}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    
@endsection

@section('page_js')
    <script>
        $(document).ready(function () {
            // Check or Uncheck All checkboxes
            $(".check-all").change(function () {
                var checked = $(this).is(':checked');
                var id = $(this).val();
                if (checked) {
                    $(".selected-" + id).each(function () {
                        $(this).prop("checked", true);
                    });
                } else {
                    $(".selected-" + id).each(function () {
                        $(this).prop("checked", false);
                    });
                }
            });
        });
    </script>
@endsection
