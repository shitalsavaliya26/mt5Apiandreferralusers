@extends('layouts.admin_app')
@section('title', 'Traders')
<style>
    .error {
        color: red;
    }
</style>
@section('content')
<div class="main-panel">
    <div class="content-wrapper">

        @if(session()->has('trader-error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            {{ session()->get('trader-error') }}
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
        <h4 class="font-weight-bold">All Traders</h4>

        <div class="row">
            <div class="col-sm-8 ml-auto text-right">
                <a class="btn btn-outline-primary" href="{{route('traders.create')}}">Add</a>
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
                                        <th>Subtitle</th>
                                        <th>Profile</th>
                                        <th>Graph</th>
                                        <th>Best Trader</th>
                                        <th>Description</th>
                                        <th>Total Investment</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(isset($traders))
                                    @php 
                                    $x = $traders->firstItem() 
                                    @endphp
                                    @foreach($traders as $i => $trader)
                                    <tr id="{{$trader->id}}">
                                        <th>{{$x++}}</th>
                                        <td>{{$trader->name}}</td>
                                        <td> {!!str_limit(strip_tags($trader->subtitle),'20')!!}</td>
                                        <td><img src="{{asset('/traders/'.$trader->profile_picture)}}" height="50" width="50"></td>
                                        <td><img src="{{asset('/traders/graphs/'.$trader->graph_picture)}}" height="50" width="50"></td>
                                        <td>

                                            @if(file_exists(public_path('/traders/besttrader/'.$trader->best_trader_image)) && $trader->best_trader_image)<img src="{{asset('/traders/besttrader/'.$trader->best_trader_image)}}" height="50" width="50">@else N/A @endif</td>
                                            <td>
                                                {!!str_limit(strip_tags($trader->description),'50')!!}
                                            </td>
                                            <td>
                                                {{number_format($trader->history()->sum('amount'),2)}}
                                            </td>
                                            <td>
                                                <label class="font-weight-medium text-{{$trader->status == '0' ? 'success':'danger'}}">
                                                    {{$trader->status == '0' ? 'Enable' : 'Disable'}}
                                                </label>
                                            </td>
                                            <form method="POST" id="delete-{{$trader->id}}"
                                              action="{{route('traders.destroy',['id' => $trader->id])}}">
                                              @csrf
                                              @method('DELETE')
                                          </form>
                                          <td>

                                            <a class="btn btn-outline-warning"
                                            href="{{route('traders.edit',['id' => $trader->id])}}">Edit</a>

                                            <a class="btn btn-outline-danger" style="cursor: pointer"
                                            onclick="if (confirm('Are you sure want to delete this trader?')) {
                                               event.preventDefault();
                                               document.getElementById('delete-{{$trader->id}}').submit();
                                           }else{
                                               event.preventDefault();
                                           }">Delete</a>

                                       </td>
                                   </tr>
                                   @endforeach
                                   @else
                                   No Traders available
                                   @endif
                               </tbody>
                           </table>
                       </div>
                       <div class="d-block d-md-flex row justify-content-between mt-4 align-items-center">
                         @if($traders->total() > 0)
                         <div class="col grid-margin grid-margin-md-0">Showing {{ $traders->firstItem() }}
                            to {{ $traders->lastItem() }} of {{ $traders->total() }} entries
                        </div>
                        @endif
                        <div class="col">
                            <ul class="pagination flex-wrap justify-content-md-end mb-0">
                                {{$traders->links()}}
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="debugArea"></div>
@endsection
@section('page_js')
<script src="{{ asset('/js/jquery.tablednd.0.8.min.js')}}"></script>

<script type="text/javascript">
    $(document).ready(function() {
    // Initialise the table
    var xhr = null;

    $("#order-listing").tableDnD({
        onDragClass: "myDragClass",
        onDragStart: function(table, row) {
            console.log("start drag");
        },
        onDrop: function(table, row) {
            var rows = table.tBodies[0].rows;
            var traderOrder = '';
            for (var i=0; i<rows.length; i++) {
                traderOrder += rows[i].id+",";
            }
            if( xhr != null ) {
                xhr.abort();
                xhr = null;
            }
            xhr = $.ajax({
                url: "{{ route('traders.admin-reorder-traders') }}",
                type:'POST',
                data: {
                    '_token'   : '{{csrf_token()}}',
                    'traderOrder': traderOrder,
                },
                dataType: 'json',
                success: function (data) {

                },
                errors: function (message) {

                }
            });
        }
    });
});
</script>
@endsection
