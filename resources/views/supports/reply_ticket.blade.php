@extends('layouts.app')
@section('title', 'Support')
<style>
    .error {
        color: red;
    }

    .message {
        border-radius: 25px;
        /*background:linear-gradient(180deg, rgba(176,128,44,1), rgba(232,205,88,1));*/
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
@section('content')
    <div class="main-panel">
        <div class="content-wrapper">
            <div style="">
                <a class="btn btn-outline-primary" href="{{route('supports')}}">Back</a>
            </div>
             <br> 

	   <h4>@lang('support.help_support')</h4>
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
                        {{$ticketTitle->titles!=null?$ticketTitle->titles['title']:""}}
                    </div>

                </div>
            </div>
            <br/>
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
                                    <div class="toast-body text-black" style="border-radius: 15px;">
<pre style="background: white;">{{$message->messages}}
</div>
                                </div>
                            </div>

                            @if(isset($message->ticketAttachments))
                                @foreach($message->ticketAttachments as $ticket)
                                    <br/>
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
                                            <img src="{{asset('supports_attachments')}}/{{$ticket->attachment}}" style="max-height:150px;max-width:200px;">
                                        @else
                                             <a style="font-size: large; text-decoration:none;"
                                                       href="{{asset('supports_attachments')}}/{{$ticket->attachment}}"target="_blank" 
                                                       class="ti-link"></a>        
                                        @endif
                                    </div>
                                </div>
                            </div>
                                @endforeach
                                @else
                                @endif
                        </div>

                        <br/>
                    @endforeach
            </div>
            @endif
            {{ Form::open(array('route' => 'ticket-reply' ,'id'=>'support-ticket', 'method' => 'POST','files' => true))}}
            <div class="modal-body">
                <div class="form-group row mt-4">
                    <div class="form-group">
                        <div class="col-lg-12 form-group-sub">
                            <div class="form-group">
                                <div class="from-inner">
                                    <label class="mb-2 bmd-label-static">@lang('support.attachment'):</label>
                                    {{ Form::file('attachments[]',['multiple' => true]) }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 form-group-sub">
                        <div class="form-group">
                            <input type="hidden" value="{{$ticketTitle->id}}" name="support_id">
                            <div class="from-inner">
                                <label class="mb-2 bmd-label-static">@lang('support.message'):<span class="text-red">*</span></label>
                                {!! Form::textarea('messages',null,['class'=>'form-control', 'rows' => 2, 'cols' => 54]) !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group row text-right" style="margin-right:10px;">
                <div class="col-lg-12 form-group-sub">
                    <button type="submit"
                            class="cus-width-auto cus-btn cus-btnbg-red btn btn-primary">@lang('support.save')
                    </button>
                </div>
            </div>
            {{ Form::close() }}
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
@endsection
