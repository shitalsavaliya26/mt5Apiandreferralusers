@extends('layouts.admin_app')
@section('title', 'Rank')
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
            <h4 class="font-weight-bold">All Ranks</h4>

            <div class="row">
                <div class="col-sm-8 ml-auto text-right">
                    <!-- <a class="btn btn-outline-primary" href="{{route('ranks.create')}}">Add</a> -->
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
                                        <th>Name</th>
                                        <th>Trading Profit</th>
                                        <th>Direct Sale</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        @if(isset($ranks))
					    @php $x = $ranks->firstItem() @endphp
                                            @foreach($ranks as $i => $rank)
                                                <th>{{$x++}}</th>
                                                <td>{{$rank->name}}</td>
                                                <td>{{$rank->trading_profit}}</td>
                                                <td>{{$rank->direct_sale}}</td>
                                                <form method="POST" id="delete-{{$rank->id}}"
                                                      action="{{route('ranks.destroy',['id' => $rank->id])}}">
                                                    @csrf
                                                    @method('DELETE')

                                                </form>
                                                <td>
                                                    <a class="btn btn-outline-info"
                                                       href="{{route('ranks.show',['id' => $rank->id])}}">View</a>
                                                    <a class="btn btn-outline-warning"
                                                       href="{{route('ranks.edit',['id' => $rank->id])}}">Edit</a>

                                                    <!-- <a class="btn btn-outline-danger" style="cursor: pointer"
                                                       onclick="if (confirm('Are you sure want to delete this rank?')) {
                                                           event.preventDefault();
                                                           document.getElementById('delete-{{$rank->id}}').submit();
                                                           }else{
                                                           event.preventDefault();
                                                           }">Delete</a> -->
                                                </td>
                                    </tr>
                                    @endforeach
                                    @else
                                        No Ranks available
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                            <div class="d-block d-md-flex row justify-content-between mt-4 align-items-center">
                                @if($ranks->total() > 0)
                                    <div class="col grid-margin grid-margin-md-0">Showing {{ $ranks->firstItem() }}
                                        to {{ $ranks->lastItem() }} of {{ $ranks->total() }} entries
                                    </div>
                                @else
                                    <div style="padding-left: 450px;">
                                        No records found
                                    </div>
                                @endif
                                <div class="col">
                                    <ul class="pagination flex-wrap justify-content-md-end mb-0">
                                        {{$ranks->links()}}
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection
