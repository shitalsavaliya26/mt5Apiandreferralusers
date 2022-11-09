@extends('layouts.admin_app')
@section('title', 'ShareHolder List')
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
            <h4 class="font-weight-bold">ShareHolder List</h4>
            <div class="row">
                <div class="col-lg-9 col-sm-12 ml-auto text-right user-act-btn" >
                    <a class="btn btn-outline-primary" href="{{route('share-holder.create')}}">Create ShareHolder</a>
                </div>
            </div>
            <br>
            <div id="response_message"></div>

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
                                        <th>Percent</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        @if(isset($shareHolders))
					                       @php $x = $shareHolders->firstItem() @endphp
                                            @foreach($shareHolders as $i => $row)
                                                <th>{{$x++}}</th>
                                                <td>{{$row->name}}</td>
                                                <td>{{$row->percent}}%</td>
                                                <td>
                                                    <a class="btn btn-outline-warning"
                                                       href="{{route('share-holder.edit',['id' => $row->id])}}">Edit</a>

                                                    <a class="btn btn-outline-danger"
                                                       onclick="return confirm('Are you sure you want to delete this shareholder')"
                                                       href="{{route('share-holder.destroy',['id' => $row->id])}}">Delete</a>
                                                </td>
                                    </tr>
                                    @endforeach
                                    @else
                                        No Users available
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                            <div class="d-block d-md-flex row justify-content-between mt-4 align-items-center">
                                
                                @if($shareHolders->total() > 0)
                                    <div class="col grid-margin grid-margin-md-0">Showing {{ $shareHolders->firstItem() }}
                                        to {{ $shareHolders->lastItem() }} of {{ $shareHolders->total() }} entries
                                    </div>
                                @else
                                    <div style="padding-left: 450px;">
                                        No records found
                                    </div>
                                @endif
                                <div class="col">
                                    <ul class="pagination flex-wrap justify-content-md-end mb-0">
                                        {{$shareHolders->links()}}
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    @endsection
    <!-- plugins:js -->
        @section('page_js')
            <script src="{{asset('/js/jquery-1.7.1.min.js')}}" type="text/javascript"></script>
            <script src="{{asset('/js/bootstrap4-toggle.min.js')}}"></script>
            <script>
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
