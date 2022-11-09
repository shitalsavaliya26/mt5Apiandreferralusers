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
    .text-wrap{
    max-width: 250px;
    word-break: break-all;
    white-space: initial;
    }
</style>
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="col-12 col-xl-9 mt-4 mt-xl-0">
                <header class="section-title titlebottomline mt-4">
                    <h3 class="hrowheading">View All Tickets</h3>
                </header>

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
            </div>
            <div class="card">
                <div >
                    <div class="card-body">
                        <div class="d-block d-md-flex mb-3">
                        </div>
                        <div class="table-responsive">
                            <table class="text-black table">
                                <thead>
                                <tr>
                                    <th>Username</th>
                                    <th>Subject</th>
                                    <th>Message</th>
                                    <th>Attachments</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                @if($supports)
                                    @foreach($supports as $i => $support)
                                        <tr>
                                            <td>{{$support->users['user_name']}}</td>
                                            <td>{{$support->titles['title']}}</td>
                                            <td> @if(isset($support->supportMessage))
                                                    @foreach($support->supportMessage as $m)
                                                        <br/>
                                                        <div class="text-wrap" style="border: 3px solid #24c6c8;padding: 5px;border-radius: 10px;">
                                                           {{$m->messages}}  <br/>
                                                        </div>

                                                    @endforeach
                                                @endif</td>
                                            <td>
                                                @if($support->supportMessage)
                                                    @foreach($support->supportMessage as $ticketMessage)
                                                        @foreach($ticketMessage->ticketAttachments as $a)

                                                            <a style="font-size: large; text-decoration:none;"
                                                               href="{{asset('uploads/supports_attachments')}}/{{$a->attachment}}"
                                                               target="_blank" class="ti-link"></a>
                                                        @endforeach

                                                    @endforeach
                                                @else
                                                @endif
                                            </td>
                                            <td>
                                                <label
                                                    class="badge badge-{{$support->status == 0 ? 'success': 'danger'}}">{{$support->status == 0 ? 'Open' : 'Close'}}
                                                </label>
                                            </td>
                                            @if($support->status == 0)
                                                <form method="POST" id="delete-{{$support->id}}"
                                                      action="{{route('admin-update-ticket-status',['id' => $support->id])}}">
                                                    @csrf
                                                    <td>
                                                        <button type="submit" data-id="{{$support->id}}" id="close_ticket" class="close_ticket btn btn-outline-success btn-xs">
                                                            <i class="fa fa-times"></i>Close
                                                        </button>
                                                    </td>
                                                </form>
                                            @else
                                                <td></td>
                                            @endif
                                            <td><a class="btn btn-outline-warning btn-xs" href="{{url('avanya-vip-portal/reply-tickets')}}/{{$support->id}}">Reply</a></td>
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
                        <div class="modal fade" id="addSupport" tabindex="-1" aria-labelledby="myModalLabel"
                             aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title inline" id="exampleModalLabel">Create New Ticket</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                    </div>
                                    {{ Form::open(array('route' => 'add-support' ,'id'=>'support-ticket', 'method' => 'POST' ,'files' => true))}}
                                    <div class="modal-body">
                                        <div class="form-group row">
                                            <div class="col-lg-12 form-group-sub">
                                                <div class="form-group">
                                                    <div class="from-inner">
                                                        <label class="mb-2 bmd-label-static">Title:<span
                                                                class="text-red">*</span></label>
                                                        {{  Form::select('title_id',$ticketTitles, null, ['class' => 'form-control','placeholder' => 'Select']) }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-lg-12 form-group-sub">
                                                <div class="form-group">
                                                    <div class="from-inner">
                                                        <label class="mb-2 bmd-label-static">Attachment:</label>
                                                        {{ Form::file('attachments') }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-lg-12 form-group-sub">
                                                <div class="form-group">
                                                    <div class="from-inner">
                                                        <label class="mb-2 bmd-label-static">Message:<span
                                                                class="text-red">*</span></label>
                                                        {!! Form::textarea('messages',null,['class'=>'form-control', 'rows' => 2, 'cols' => 54]) !!}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row text-right" style="margin-right:10px;">
                                        <div class="col-lg-12 form-group-sub">
                                            <button type="submit"
                                                    class="cus-width-auto cus-btn cus-btnbg-red btn btn-primary">save
                                            </button>
                                        </div>
                                    </div>
                                    {{ Form::close() }}
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
                                        str += `<td></td><td>General Enquery</td>`
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
