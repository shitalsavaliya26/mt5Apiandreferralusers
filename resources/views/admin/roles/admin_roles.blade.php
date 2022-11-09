@extends('layouts.admin_app')
@section('title', 'Admin Roles')
@section('content')
    <div class="main-panel">
        <div class="content-wrapper">

            <h4 class="font-weight-bold">All Roles</h4>

            <div class="row">
                <div class="col-sm-8 ml-auto text-right" style="float: right;">
                    <a class="btn btn-outline-primary" href="{{route('roles.create')}}">Add</a>
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
                                        <th>Name</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        @if(isset($roles))
						@php $x = $roles->firstItem() @endphp
                                            @foreach($roles as $i => $n)
                                                <th>{{$x++}}</th>
                                                <td>{{$n->name}}</td>
                                                <form method="POST" id="delete-{{$n->id}}"
                                                      action="{{route('roles.destroy',['id' => $n->id])}}">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                                <td>
                                                    <a class="btn btn-outline-warning"
                                                       href="{{route('roles.edit',['id' => $n->id])}}">Edit</a>

                                                    <a class="btn btn-outline-danger" style="cursor: pointer"
                                                       onclick="if (confirm('Are you sure want to delete this roles?')) {
                                                           event.preventDefault();
                                                           document.getElementById('delete-{{$n->id}}').submit();
                                                           }else{
                                                           event.preventDefault();
                                                           }">Delete</a>

                                                    <a class="btn btn-outline-light"
                                                       href="{{route('assign-permission',['id' => $n->id])}}">Permission</a>
                                                </td>
                                    </tr>
                                    @endforeach
                                    @else
                                        No Roles available
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                            <div class="d-block d-md-flex row justify-content-between mt-4 align-items-center">
                                @if($roles->total() > 0)
                                    <div class="col grid-margin grid-margin-md-0">Showing {{ $roles->firstItem() }}
                                        to {{ $roles->lastItem() }} of {{ $roles->total() }} entries
                                    </div>
                                @else
                                    <div style="padding-left: 450px;">
                                        No records found
                                    </div>
                                @endif
                                <div class="col">
                                    <ul class="pagination flex-wrap justify-content-md-end mb-0">
                                        {{$roles->links()}}
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection

