@extends('layouts.admin_app')
@section('title', 'Admin CMS')
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
            <h4 class="font-weight-bold">All CMS</h4>

            <div class="row">
                <div class="col-sm-8 ml-auto text-right" style="float: right;">
                    <a class="btn btn-outline-primary" href="{{route('cms.create')}}">Add</a>
                </div>
            </div>
            <br/>
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
                                        <th>Title</th>
                                        <th>Language</th>
                                        <th>Image</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        @if(isset($cms))
					    @php $x = $cms->firstItem() @endphp
                                            @foreach($cms as $i => $n)
                                                <th>{{$x++}}</th>
                                                <td>{{$n->title}}</td>
                                                <td>{{$n->language}}</td>
                                                <td><img src="{{url('uploads/cms_images/'.$n->image)}}" height="50" width="50">
                                                </td>
                                                <td>
                                                    <label class="font-weight-medium text-{{$n->status == '0' ? 'success':'danger'}}">
                                                        {{$n->status == '0' ? 'Active' : 'Inactive'}}
                                                    </label>
                                                </td>
                                                <form method="POST" id="delete-{{$n->id}}"
                                                      action="{{route('cms.destroy',['id' => $n->id])}}">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                                <td>
                                                    <a class="btn btn-outline-warning"
                                                       href="{{route('cms.edit',['id' => $n->id])}}">Edit</a>

                                                    <a class="btn btn-outline-danger" style="cursor: pointer"
                                                       onclick="if (confirm('Are you sure want to delete this cms?')) {
                                                           event.preventDefault();
                                                           document.getElementById('delete-{{$n->id}}').submit();
                                                           }else{
                                                           event.preventDefault();
                                                           }">Delete</a>
                                                </td>
                                    </tr>
                                    @endforeach
                                    @else
                                        No CMS available
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                            <div class="d-block d-md-flex row justify-content-between mt-4 align-items-center">
                                @if($cms->total() > 0)
                                    <div class="col grid-margin grid-margin-md-0">Showing {{ $cms->firstItem() }}
                                        to {{ $cms->lastItem() }} of {{ $cms->total() }} entries
                                    </div>
                                @else
                                    <div style="padding-left: 450px;">
                                        No records found
                                    </div>
                                @endif
                                <div class="col">
                                    <ul class="pagination flex-wrap justify-content-md-end mb-0">
                                        {{$cms->links()}}
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection

