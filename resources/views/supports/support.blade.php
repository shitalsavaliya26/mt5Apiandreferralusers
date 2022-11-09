@extends('layouts.app')
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
    <div class="d-block mt-30"></div>

    <div class="text-white text-center w-100 medimagebgdiv" style="background-image: url(./images/support.png)">
        <h3 class="m-0 boldbultertext">@lang('support.support_page')</h3>
    </div>

    <div class="d-block mt-5"></div>

    <div class="row">
        <div class="col-12 col-xl-3">
            <div class="card p-3">
                <a href="#"
                   class="d-block btn btn-primary text-uppercase create-ticket">@lang('support.create_ticket')</a>
                <div class="pt-4">
                    <div class="row mb-3">
                        <a class="col medbultertext text-white"
                           href="{{route('supports')}}">@lang('support.all_tickets')</a>
                        <div class="col text-right"><span class="counter">{{$totalTickets->total()}}</span></div>
                    </div>
                    <div class="hrlinedark mb-3"></div>
                    <div class="row mb-3">
                        <!-- {{route('supports')}}?tickets_status=0 -->
                        <a class="col medbultertext text-white" href="#" data-status="0"
                           onclick="getTicket(0)">@lang('support.opened')</a>
                        <div class="col text-right"><span class="counter">{{$openTicket}}</span></div>
                    </div>
                    <div class="hrlinedark mb-3"></div>
                    <div class="row">
                        <!-- {{route('supports')}}?tickets_status=1 -->
                        <a class="col medbultertext text-white" href="#"
                           onclick="getTicket(1)">@lang('support.closed')</a>
                        <div class="col text-right"><span class="counter">{{$closeTicket}}</span></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-xl-9 mt-4 mt-xl-0">
            <header class="section-title titlebottomline mt-4">
                <h2 class="hrowheading">
                @if(isset($ticketStatus) && $ticketStatus == 0 )
                	Opened Tickets
            	@elseif(isset($ticketStatus) && $ticketStatus == 1 )
                	Closed Tickets
            	@else
                	@lang('support.recent_ticket')
            	@endif
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
            <div class="card text-white support">
                <div class="card-body">
                    <div class="d-block d-md-flex row justify-content-between mb-3">
                        <div class="col grid-margin grid-margin-md-0">
                            <form action="{{route('supports')}}">
                                <div class="d-flex flex-wrap align-items-center">
                                    <div>@lang('general.show')</div>
                                    <select id="pagination" class="form-control form-control-sm showperpage">
                                        <option value="5" @if($items == 5) selected @endif >5</option>
                                        <option value="10" @if($items == 10) selected @endif >10</option>
                                        <option value="25" @if($items == 25) selected @endif >25</option>
                                        <option value="50" @if($items == 50) selected @endif >50</option>
                                        <option value="100" @if($items == 100) selected @endif >100</option>
                                    </select>
                                    <div>@lang('general.entries')</div>
                                </div>
                            </form>
                        </div>

                        <form method="get" id="functionalURL" action="{{url()->full()}}">
                            <div class="row mr-auto">
                                <div id="" class="input-group col-sm-6">
                                    <input type="text" id="date-range-my" placeholder="@lang('general.search_date')"
                                           id="date-range"
                                           value="{{@$data['start_date']? @$data['start_date'].'-'.@$data['end_date']:""}}" class="form-control readonly-text" readonly>
                                    <input type="hidden" name="start_date" id="startdate" value="{{@$data['start_date']}}" class="form-control">
                                    <input type="hidden" name="end_date" id="enddate"  value="{{@$data['end_date']}}" class="form-control">
                                    <input type="hidden" name="status" value="{{@$ticketStatus}}" class="form-control">
                                    <span class="input-group-addon input-group-append border-left">
                                        <i  class="ti-calendar input-group-text"></i>
                                        <!-- <button type="submit" name="date-range" class="ti-calendar input-group-text"></button> -->
                                    </span>
                                </div>
                                <div class="input-group col-sm-3">
                                    <button type="submit"   class="form-control">Search</button>
                                </div>
                                <div class="input-group col-sm-3">
                                    <a href="{{route('supports')}}" class="form-control btn-reset">@lang('general.reset')</a>
                                    <!-- <button type="submit" name="submit" class="btn-outline-twitter input-group-text btn-reset">@lang('general.reset')</button> -->
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="d-block mt-30 d-md-none text-white"><i class="fa fa-hand-o-right"></i> Scroll right to
                        see data in
                        table.
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>No.</th>
                                <th>@lang('support.subject')</th>
                                <th>@lang('support.posted')</th>
                                <th>@lang('general.status')</th>
                                <th class="hideAction">@lang('support.action')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if($supports)
                @php $x = $supports->firstItem() @endphp
                                @foreach($supports as $i => $support)
                                    <tr>
                                        <td>{{$x++}}</td>
                                        <td>{{$support->titles['title']}}</td>
                                        <td>{{$support->created_at->format('m/d/Y')}}</td>
                                        <td>
                                            <label
                                                class="label label-{{$support->status == 0 ? 'success': 'danger'}}">{{$support->status == 0 ? 'Open' : 'Close'}}</label>
                                        </td>

                                        @if($support->status == 0)
                                            <td>
                                                <button type="button" data-dismiss="modal"
                                                        data-id="{{$support->id}}" id="close_ticket"
                                                        class="close_ticket_class btn btn-xs btn-danger">@lang('support.close')

                                                </button>
                                            </td>
                                        @else
                                            <td>N/A</td>
                                        @endif
                                        @php $supportId = encrypt($support->id) @endphp
                            			@if($support->status == 0)
                                            <td>
                                                <a class="btn btn-xs btn-success" href="{{url('reply-tickets')}}/{{$supportId}}">@lang('support.reply')</a>
                                            </td>
                                        @else
                    					    <td></td>
                    					@endif  
                    
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                        No result found
                    @endif

                    <div id="confirm" class="bootbox modal fade bootbox-confirm in" style="padding: 10px" tabindex="-1"
                         aria-labelledby="myModalLabel"
                         aria-hidden="true" role="dialog" role="document">
                        <div class="modal-dialog">
                            <div class="modal-content" style="padding: 22px;">
                                <div class="modal-body" style="border: none;">
                                    @lang('support.sure')
                                </div>
                                <div class="modal-footer mt-2">
                                    <div class="mt-4">
                                        <button type="button" data-dismiss="modal" class="btn btn-danger"
                                            id="delete">@lang('support.close')
                                        </button>
                                        <button type="button" data-dismiss="modal"
                                            class="btn">@lang('support.cancel')</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="addSupport" tabindex="-1" aria-labelledby="myModalLabel"
                         aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title inline"
                                        id="exampleModalLabel">@lang('support.create_new')</h4>
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
                                                    <label class="mb-2 bmd-label-static">@lang('support.title'):<span
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
                                                    <label class="mb-2 bmd-label-static">@lang('support.attachment')
                                                        :</label>
                                                    {{ Form::file('attachments[]',['multiple' => true]) }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-lg-12 form-group-sub">
                                            <div class="form-group">
                                                <div class="from-inner">
                                                    <label class="mb-2 bmd-label-static">@lang('support.message'):<span
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
                                                class="cus-width-auto cus-btn cus-btnbg-red btn btn-primary">@lang('support.save')
                                        </button>
                                    </div>
                                </div>
                                {{ Form::close() }}
                            </div>
                        </div>
                    </div>
                    <div class="d-block d-md-flex row justify-content-between mt-4 align-items-center">
                        @if($supports->total() > 0)
                            <div class="col grid-margin grid-margin-md-0">@lang('general.showing') {{ $supports->firstItem() }}
                                to {{ $supports->lastItem() }} of {{ $supports->total() }} @lang('general.entries')
                            </div>
                        @else
                            <div class="col-12 d-block text-center">
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
    <input type="hidden" name="current_url" value="{{ url()->full() }}" />
@endsection

@section('page_js')

    <script src="{{asset('/js/jquery-1.7.1.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('/js/jquery.validate.min.js')}}"></script>
    <script>

        var current_url = $('input[name="current_url"]').val();
        
        document.getElementById('pagination').onchange = function () {
       
        };
        $(document).on('change','#pagination',function(){
            if(current_url.indexOf("?") >= 0){
                    current_url = current_url+"&items=" + this.value;
                    // window.location = current_url+"&items=" + this.value;
            }else{
                current_url = current_url+"?items=" + this.value;
            }
                window.location = current_url;
        })

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

            var formData = $('#functionalURL').serialize();
            console.log(formData);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'GET',
                data: {'status': value},
                url: '{{route('supports')}}?status='+value+'&'+formData,
                success: function (response) {
                    var cnt = 1;
                    if (response.status == true) {
                        // if (response.data.length > 0) {

                           

                        //     var str = "<tr>";
                        //     for (var i = response.data.length - 1; i >= 0; i--) {
                        //         str += `<td>${cnt}</td><td>${response.data[i].titles.title}</td>`
                        //             + `<td>${response.data[i].created_at}</td> <td> <label class="badge badge-${response.data[i].status == "0" ? "success" : "danger"}">${response.data[i].status == 0 ? 'Open' : 'Close'}</label> </td>`;

                        //         if (response.data[i].status == '0') {
                        //             str += `<td><button type="button" data-dismiss="modal" data-id="${response.data[i].id}" id="close_ticket" class="close_ticket_class btn btn-xs btn-danger">@lang('general.close')`;
                        //         } else {
                        //             //str += `<td>@lang('general.close')</td>`;
                        //             $('.hideAction').css('display','none');
                        //         }
                        //         str += `</tr>`;
                        //         cnt++;
                        //     }
                        // }
                        if (value == 0) {
                            $(".hrowheading").html('Opened Tickets');
                        } 
                        if (value == 1) {
                            $(".hrowheading").html('Closed Tickets');  
                        }
                        // console.log($(response.html).find('.support').html())
                        $('.support').html($(response.html).find('.support').html());
                        current_url = $(response.html).find('input[name="current_url"]').val();
                        $('input[name="current_url"]').val(current_url);
                        $('#functionalURL').attr('action',current_url);
                        console.log("current_url ::"+current_url);
                        $('#date-range-my').daterangepicker({
                            opens: 'left',
                            autoUpdateInput: false,
                            locale: {
                                cancelLabel: 'Clear'
                            }
                        }, function (start, end, label) {
                            var startdate = start.format('YYYY-MM-DD');
                            var enddate = end.format('YYYY-MM-DD');

                            $('#startdate').val(startdate);
                            $('#enddate').val(enddate);
                        });
                        $('#date-range-my').on('apply.daterangepicker' ,function (ev, picker) {
                            $(this).val(picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format('YYYY-MM-DD'));
                        });
                    }
                }
            })
            return false;
        }

        $(function () {
            $('#date-range-my').daterangepicker({
                opens: 'left',
                autoUpdateInput: false,
                locale: {
                    cancelLabel: 'Clear'
                }
            }, function (start, end, label) {
                var startdate = start.format('YYYY-MM-DD');
                var enddate = end.format('YYYY-MM-DD');

                $('#startdate').val(startdate);
                $('#enddate').val(enddate);
            });

            $('.ti-calendar').click(function () {
                $('input[name="date-range-my"]').focus();
            });

            $('#date-range-my').on('apply.daterangepicker' ,function (ev, picker) {
                $(this).val(picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format('YYYY-MM-DD'));
            });
        });
    </script>
@endsection
