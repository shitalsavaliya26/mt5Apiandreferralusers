@extends('layouts.admin_app')
@section('title', 'Admin Staff Users')
@section('content')
    <div class="main-panel">
        <div class="content-wrapper">
            <h4 class="font-weight-bold">All Staff Users</h4>
            <div class="row">
                <div class="col-sm-8 ml-auto text-right" style="float: right;">
                    <a class="btn btn-outline-primary" href="{{route('staff-users.create')}}">Add</a>
                </div>
            </div>
            <br/>
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
                            <div class="table-responsive">
                                <table id="order-listing" class="table text-muted">
                                    <thead>
                                    <!------------------------changes-->
                                    <tr class="text-black">
                                        <th>No.</th>
                                        <th>Username</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        @if(isset($staffUsers))
						@php $x = $staffUsers->firstItem() @endphp
                                            @foreach($staffUsers as $i => $n)
                                                <th>{{$x++}}</th>
                                                <td>{{$n->user_name}}</td>
                                                <form method="POST" id="delete-{{$n->id}}"
                                                      action="{{route('staff-users.destroy',['id' => $n->id])}}">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>

                                                <td>
                                                    <a class="btn btn-outline-warning" href="{{route('staff-users.edit',['id' => $n->id])}}">Edit</a>
                                                    @if($n->hasRole('admin'))
                                                    @else
                                                    <a class="btn btn-outline-danger" style="cursor: pointer"
                                                       onclick="if (confirm('Are you sure want to delete this user?')) {
                                                           event.preventDefault();
                                                           document.getElementById('delete-{{$n->id}}').submit();
                                                           }else{
                                                           event.preventDefault();
                                                           }">Delete</a>
                                                           @endif
                                                    <a href="#" data-id="{{$n->id}}"
                                                       class="btn btn-outline-primary change-pwd">Change Password</a>
                                                </td>
                                    </tr>
                                    @endforeach
                                    @else
                                        No Users available
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                            <div class="modal fade" id="change-password" tabindex="-1" aria-labelledby="myModalLabel"
                                 aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title inline"
                                                id="exampleModalLabel">Change Password</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                            </button>
                                        </div>
                                        {{ Form::open(array('id'=>'change-password-form', 'method' => 'POST'))}}
                                        <div class="modal-body">
                                            <div class="form-group row">
                                                <div class="col-lg-12 form-group-sub">
                                                    <div class="row">
                                                        <div class="form-group col-md-10">
                                                            {{ Form::label('password', 'Password')}}

                                                            {{ Form::password('password', array('id' => 'password', "class" => "form-control", "autocomplete" => "off")) }}
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="form-group col-md-10">
                                                            {{ Form::label('confirm_password', ' Confirm Password')}}

                                                            {{ Form::password('password_confirmation', array('id' => 'password-confirm', "class" => "form-control", "autocomplete" => "off")) }}
                                                        </div>
                                                    </div>
                                                    <div class="row mt-2">
                                                        <div class="form-group col-md-6">
                                                            <button type="submit" name="submit"
                                                                    class="col-md-6 btn btn-primary mr-2">Submit
                                                            </button>
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <a class="col-md-6 btn btn-light"
                                                               href="{{route('staff-users.index')}}">Back</a>
                                                            {{Form::close()}}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="d-block d-md-flex row justify-content-between mt-4 align-items-center">
                                @if($staffUsers->total() > 0)
                                    <div class="col grid-margin grid-margin-md-0">Showing {{ $staffUsers->firstItem() }}
                                        to {{ $staffUsers->lastItem() }} of {{ $staffUsers->total() }} entries
                                    </div>
                                @else
                                    <div style="padding-left: 450px;">
                                        No records found
                                    </div>
                                @endif
                                <div class="col">
                                    <ul class="pagination flex-wrap justify-content-md-end mb-0">
                                        {{$staffUsers->links()}}
                                    </ul>
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
                $('#change-password-form').validate({
                    // initialize the plugin
                    rules: {
                        password: {
                            required: true
                        },
                        password_confirmation: {
                            required: true,
                            equalTo: '#password'
                        },

                    }
                });

                $.noConflict();

                $('.change-pwd').on('click', function () {
                    var id = $(this).data('id');
                    var url = '{{ route("update-staff-password","id")}}';
                    url = url.replace('id', id);
                    $('#change-password-form').prop('action', url);
                    $('#change-password').modal('show');
                });
            </script>
@endsection
