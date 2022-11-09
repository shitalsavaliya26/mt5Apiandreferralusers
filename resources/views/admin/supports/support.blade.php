@extends('layouts.admin_app')
@section('title', 'Support')

@section('content')
<style>
    .error {
        color: red;
    }

    .modal .modal-dialog .modal-content .modal-body {
        padding: 0px 26px !important;
    }

    .modal .modal-dialog .modal-content .modal-footer {
        padding: 0px 15px !important;
    }

</style>
    <div class="main-panel">
        <div class="content-wrapper">
            @if(session()->has('message'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session()->get('message') }}
                </div>
            @endif
            @if(count($errors) > 0 )
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <ul class="p-0 m-0" style="list-style: none;">
                        @foreach($errors->all() as $error)
                            {{$error}}<br/><br/>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="card support">
                <div class="row">
                    <div class="col-12 col-xl-3">
                        <div class="card pl-1">
                            <div class="pt-4 ml-5">
                                <div class="row">
                                    <a class="col-9  text-black btn-outline-primary link1 btn"
                                       href="{{route('admin-supports')}}">All Tickets</a>
                                </div>
                                <div class="hrlinedark"></div>
                                <div class="row">
                                    <a class="col-9  text-black btn-outline-success link2 btn"
                                       href="{{url('avanya-vip-portal/supports/3')}}">Opened</a>
                                </div>
                                <div class="hrlinedark"></div>
                                <div class="row">
                                    <a class="col-9 text-black btn-outline-warning link3 btn"
                                       href="{{url('avanya-vip-portal/supports/1')}}">Closed</a>
                                </div>
                                <div class="hrlinedark mb-3"></div>
                                <div class="row">
                                    <a href="{{route('view-all-tickets')}}"
                                       class="col-9 d-block btn btn-warning text-white">View All
                                        Tickets</a>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-12 col-xl-9 mt-4 mt-xl-0">
                        <header class="section-title titlebottomline mt-4">
                            <h3 class="hrowheading">Recent Tickets</h3>
                        </header>

                        <div class="card-body">
                            <div class="d-block d-md-flex row justify-content-between mb-3">
                                <div class="col grid-margin grid-margin-md-0">
                                </div>
                            </div>
                            <div class="d-block mt-30 d-md-none"><i class="fa fa-hand-o-right"></i> Scroll right to see
                                data
                                in
                                table.
                            </div>
                            <div class="table-responsive" style="width: auto">
                                <table class="text-black table">
                                    <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Username</th>
                                        <th>Subject</th>
                                        <th>Posted</th>
                                        <th>Status</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if($supports)
					@php $x = $supports->firstItem() @endphp
                                        @foreach($supports as $i => $support)
                                            <tr>
                                                <td>{{$x++}}</td>
                                                <td>{{$support->users['user_name']}}</td>
                                                <td>{{$support->titles['title']}}</td>
                                                <td>{{$support->created_at->format('m/d/Y')}}</td>
                                                <td>
                                                    <label
                                                        class="badge badge-{{$support->status == 0 ? 'success': 'danger'}}">{{$support->status == 0 ? 'Open' : 'Close'}}</label>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @else
                                No result found
                            @endif
                            <div class="d-block d-md-flex row justify-content-between mt-4 align-items-center">
                                
                                @if($supports->total() > 0)
                                    <div class="col grid-margin grid-margin-md-0">Showing {{ $supports->firstItem() }}
                                        to {{ $supports->lastItem() }} of {{ $supports->total() }} entries
                                    </div>
                                @else
                                    <div style="padding-left: 450px;">
                                        No records found
                                    </div>
                                @endif
                                <div class="col">
                                    <ul class="pagination flex-wrap justify-content-md-end mb-0">
                                        {{$supports->links()}}
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
                $('#support-ticket').validate({
                    // initialize the plugin
                    rules: {
                        title_id: {
                            required: true
                        },
                        messages: {
                            required: true
                        },
                    }
                });
            </script>
            <script type="text/javascript">
                jQuery.noConflict();
                $('.create-ticket').on('click', function () {
                    $('#addSupport').modal('show');
                });

                $('tbody').on('click', ".close_ticket_class", function (e) {
                    var id = $(this).data('id');
                    e.preventDefault();
                    $('#confirm').modal({
                        backdrop: 'static',
                        keyboard: false
                    })
                        .on('click', '#delete', function (e) {
                            $.ajax({
                                type: 'POST',
                                url: '{{ route('update-ticket-status') }}',
                                data: {
                                    "_token": "{{ csrf_token() }}",
                                    "support_id": id
                                },
                                dataType: 'json',
                                success: function (data) {
                                    if (data['success']) {
                                        window.location.reload();
                                    }
                                },
                                errors: function () {
                                    alert('something went wrong');
                                }
                            });
                        });
                });

                function getTicket(value) {
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: 'GET',
                        data: {'status': value},
                        url: '{{route('supports')}}',
                        success: function (response) {
                            if (response.status == true) {
                                if (response.data.length > 0) {
                                    var str = "<tr>";
                                    for (var i = response.data.length - 1; i >= 0; i--) {
                                        str += `<td></td><td>${response.data[i].titles.title}</td>`
                                            + `<td>${response.data[i].created_at}</td> <td> <label class="badge badge-${response.data[i].status == "0" ? "success" : "danger"}">${response.data[i].status == 0 ? 'Open' : 'Close'}</label> </td>`;

                                        if (response.data[i].status == '0') {
                                            str += `<td><i class="fa fa-times"> <button type="button" data-dismiss="modal" data-id="${response.data[i].id}" id="close_ticket" class="close_ticket_class">Close`;
                                        } else {
                                            str += `<td></td>`;
                                        }
                                        str += `</tr>`;
                                    }
                                    $('tbody').html(str);
                                }
                            }
                        }
                    })
                }
            </script>
@endsection
