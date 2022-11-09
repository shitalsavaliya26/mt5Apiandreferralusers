@extends('layouts.admin_app')
@section('title', 'Support')

@section('content')
<style>
    .error {
        color: red;
    }

    .message {
        border-radius: 25px;
        /*background: linear-gradient(180deg, rgba(176, 128, 44, 1), rgba(232, 205, 88, 1));*/
        padding: 20px;
        width: auto;
        height: auto;
    }

    .scroll {
        height: 400px;
        overflow-y: scroll;
    }

    .card-red {
        border-radius: 25px;
    }
</style>
    <div class="main-panel">
        <div class="content-wrapper">

		 <div style="">
                <a class="btn btn-outline-primary" href="{{route('view-all-tickets')}}">Back</a>
            </div>
             <br> 
            <h4>Help & Supports</h4>

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
            <div class="card">
                <div class="row">
                    <div class="card-body">
                        {{$ticketTitle->titles['title']}}
                    </div>
                </div>
            </div>
            <br/>
	    @if(session()->has('reply_success'))
               <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button> Successfully send
                </div>
            @endif

            <div id="response_message"></div>
            <div class="message scroll">
                @if($ticketMessage)
                    @foreach($ticketMessage as $message)
                        <div class="mt-3 {{$message->user_id == 'admin' ? 'mr-3 ml-auto' :''}}" style="width:90%">
                            <div class="card card-red" style="border-radius: 15px">
                                <div class="card" style="background-color: #FFFFFF;border-radius: 15px">
                                    <div class="toast-header" style="border-radius: 15px">
                                        <strong class="mr-auto" style="color:#696969;">
                                            {{ $message->user_id== 'admin' ?'admin' :$message->user['user_name']}}</strong>
                                        <!-- <small class="text-muted">1 week ago</small> -->
                                    </div>
                                    <div class="toast-body" style="border-radius: 15px"><pre style="background:white;">{{$message->messages}}</div>
                                </div>
                            </div>
                        </div>

                        @if(isset($message->ticketAttachments))
                            @foreach($message->ticketAttachments as $ticket)
                                <br/>
                                <div class="mt-3 {{$message->user_id == 'admin' ? 'mr-3 ml-auto' :''}}"
                                     style="width:90%">
                                    <div class="card card-red" style="border-radius: 15px">
                                        <div class="card" style="background-color: #FFFFFF;border-radius: 15px">
                                            <div class="toast-header" style="border-radius: 15px">
                                                <strong class="mr-auto" style="color:#696969;">
                                                    {{ $message->user_id== 'admin' ?'admin' :$message->user['user_name']}}</strong>
                                                <!-- <small class="text-muted">1 week ago</small> -->
                                            </div>
                                            <div class="toast-body text-black" style="border-radius: 15px;">
                                            	@php
                                                    $ext = explode('.',$ticket->attachment);
                                                    $extensions = ['jpg','jpeg','png'];
                                                @endphp    
                                                @if(in_array($ext[1],$extensions))
                                                    <img src="{{asset('supports_attachments')}}/{{$ticket->attachment}}"
                                                         height="250" width="500">
                                                @else
                                                     <a style="font-size: large; text-decoration:none;"
                                                               href="{{asset('supports_attachments')}}/{{$ticket->attachment}}"
                                                               target="_blank" class="ti-download" download></a>        
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                        @endif

                        <br/>
                    @endforeach
            </div>
            @endif
		 <form id="support-ticket" enctype="multipart/form-data">
            <div class="modal-body">
                <div class="form-group row mt-4">
                    <div class="col-lg-12 form-group-sub">
                        <div class="form-group">
                            <div class="from-inner">
                                <label class="mb-2 bmd-label-static">Attachment:</label>
                                {{ Form::file('attachments[]',['id'=> 'image-upload','class'=>'form-control','multiple' => true]) }}
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 form-group-sub">
                        <div class="form-group">
                            <input type="hidden" value="{{$ticketTitle->id}}" id="support_id" name="support_id">
                            <div class="from-inner">
                                <label class="mb-2 bmd-label-static">Message:<span class="text-red">*</span></label>
                                {!! Form::textarea('messages',null,['id' => 'message','class'=>'form-control', 'rows' => 2, 'cols' => 54]) !!}
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
	</form>
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
                    },
                    submitHandler: function (form,e) {
                        e.preventDefault();

                        $.ajax({
                            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                            url: '{{ route('admin-ticket-reply') }}',
                            type: 'POST',
                            data: new FormData($("#support-ticket")[0]),
                            contentType: false,
                            processData: false,
			    success: function (data) {
                                if (data.success == true) {
                                    window.location.href = "{{route('reply-tickets2',['id1'=>$ticketTitle->id])}}";
                                } else {
                                    $('#response_message').html(`<span style='color:#8B0000;font-weight:bold;'>" +
                                        something went wrong  </span></div>`);
                                }
                            },
                            errors: function () {
                                alert('something went wrong');
                            }
                        });
                        return false;
                    }
                });
            </script>
@endsection
