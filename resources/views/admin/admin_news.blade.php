@extends('layouts.admin_app')
@section('title', 'Admin News')
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
            <div class="row">
                <div class="col-sm-4 ml-auto">
                    <h4 class="font-weight-bold">All News</h4>
                </div>
                <div class="col-sm-8 ml-auto text-right" style="float: right;">
                    <a class="btn btn-outline-primary" href="{{route('news.create')}}">Add</a>
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
                                        @if(isset($news))
					                        @php $x = $news->firstItem() @endphp
                                            @foreach($news as $i => $n)
                                                <th>{{$x++}}</th>
                                                <td>{{$n->title}}</td>
                                                <td>
                                                @if($n->language == 'en')
                                                    English
                                                @elseif($n->language == 'es')
                                                    N\A
                                                @elseif($n->language == 'id')
                                                    Indonesian
                                                @else
                                                    N\A
                                                @endif
                                                </td>
                                                <td><img src="{{url('news_images/'.$n->image)}}" height="50" width="50">
                                                </td>
                                                <td>
                                                    <label class="font-weight-medium text-{{$n->status == '0' ? 'success':'danger'}}">
                                                        {{$n->status == '0' ? 'Active' : 'Inactive'}}
                                                    </label>
                                                </td>
                                                <form method="POST" id="delete-{{$n->id}}"
                                                      action="{{route('news.destroy',['id' => $n->id])}}">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                                <td>
                                                    <a class="btn btn-outline-warning"
                                                       href="{{route('news.edit',['id' => $n->id])}}">Edit</a>

                                                    <a class="btn btn-outline-danger"
                                                       onclick="if (confirm('Are you sure want to delete this news?')) {
                                                           event.preventDefault();
                                                           document.getElementById('delete-{{$n->id}}').submit();
                                                           }else{
                                                           event.preventDefault();
                                                           }">Delete</a>

                                                </td>
                                    </tr>
                                    @endforeach
                                    @else
                                        No News available
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                            <div class="d-block d-md-flex row justify-content-between mt-4 align-items-center">
                                @if($news->total() > 0)
                                    <div class="col grid-margin grid-margin-md-0">Showing {{ $news->firstItem() }}
                                        to {{ $news->lastItem() }} of {{ $news->total() }} entries
                                    </div>
                                @else
                                    <div style="padding-left: 450px;">
                                        No records found
                                    </div>
                                @endif
                                <div class="col">
                                    <ul class="pagination flex-wrap justify-content-md-end mb-0">
                                        {{$news->links()}}
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
@endsection

