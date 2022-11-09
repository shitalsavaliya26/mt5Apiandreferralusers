@extends('layouts.admin_app')
@section('title', 'Admin Users')

@section('content')
<style>
    .error {
        color: red;
    }
    .table th, .jsgrid .jsgrid-table th, .table td, .jsgrid .jsgrid-table td,.toggle-on.btn,td >.btn{
        font-size: 14px !important;/*

        white-space: normal;
        word-break: break-all;*/
    }
</style>
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
            <h4 class="font-weight-bold">All Users</h4>
            <div class="row">
                <div class="col-lg-9 col-sm-12 ml-auto text-right user-act-btn" >
                    <a class="btn btn-outline-success" href="{{route('user-import-view')}}">Imports</a>
                    <a class="btn btn-outline-warning download-report" href="{{route('users-exports',$ext = 'xls')}}">Exports XLS</a>
                    <a class="btn btn-outline-warning download-report" href="{{route('users-exports',$ext = 'xlsx')}}">Exports XLSX</a>
                    <a class="btn btn-outline-warning download-report" href="{{route('users-exports',$ext = 'csv')}}">Exports CSV</a>
                    <a class="btn btn-outline-primary" href="{{route('create.user')}}">Add</a>
                </div>
            </div>

            <br/>
            <div id="response_message"></div>

            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col ">
                            <form method="get" class="" id="report-all" action="{{route('admin.users')}}">
                                <div class="ml-1 ">
                                    <div id="" class="input-group ">                                        
                                        <div class="col-sm-5 pl-0 ">
                                            <input type="text" name="global_search" placeholder="Search by name,username and MT5 ID" value="{{@$data['global_search']}}"class="form-control">
                                        </div>  
                                        <div class="col-md-3 search-inpt">
                                            <input type="text" id="date-range-my" placeholder="Select Date"
                                                   value="{{@$data['start_date']?$data['start_date'].'-'.$data['end_date']:''}}" class="form-control">
                                            <input type="hidden" name="start_date" value="{{@$data['start_date']}}" id="startdate" class="form-control">
                                            <input type="hidden" name="end_date"  value="{{@$data['end_date']}}" id="enddate" class="form-control">
                                            <span class="input-group-addon input-group-append border-left"></span>
                                        </div>                              
                                        <button type="submit" name="submit" class="btn-outline-twitter input-group-text">Search
                                        </button>
                                        <a class="btn-outline-twitter input-group-text mx-1" id="reset_link"  href="{{route('admin.users')}}">@lang('general.reset')
                                        </a>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-12">
                            <div class="table-responsive">
                                <table id="order-listing" class="table text-muted">
                                    <thead>
                                    <!------------------------changes-->
                                    <tr class="text-black">
                                        <!-- <th>No.</th> -->
                                        <th >Sponsor</th>
                                        <th >MT5 ID</th>
                                        <th >Username</th>
                                        <th >Full name</th>
                                        <th >Email</th>
                                        <th >City</th>
                                        <th >Rank</th> 
                                        <th >Email<br> Verification</th>
                                        <th >Register<br> Date</th>
                                        <th >Status</th>
                                        <th >Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        @if(isset($users))
					                   @php $x = $users->firstItem() @endphp
                                            @foreach($users as $i => $user)
                                                <!-- <th>{{$x++}}</th> -->
                                                <td  >{{$user->sponsor_detail!=null ? $user->sponsor_detail->user_name:"N/A"}}</td>
                                                <td  >{{$user->mt4_username!=null ? $user->mt4_username:"N/A"}}</td>
                                                <td >{{$user->user_name}}</td>
                                                <td >{{$user->full_name}}</td>
                                                <td >{{$user->email}}</td>
                                                <td >{{$user->city}}</td>
                                                <td >{{$user->rank['name'] ? $user->rank['name'] : ''}}</td>
                                                <td >
                                                    {!! $user->email_verified_at!=null?"<span class='text-success'>Verified</span>":'<a data-id="'.$user->id.'" class="verify-user btn-link" href="" title="Verify Email by admin">Not-verified</a>' !!}
                                                </td>
                                                <td >{{$user->created_at->format('Y-m-d')}}</td>
                                                <td >
                                                    <input data-id="{{$user->id}}" class="toggle-class" type="checkbox"
                                                           data-onstyle="success" data-offstyle="danger"
                                                           data-toggle="toggle" data-on="Active"
                                                           data-off="In-Active" {{ $user->status == 'active' ? 'checked' : '' }}>
                                                </td>
                                                <td >
                                                    <a class="btn btn-outline-primary"
                                                       href="{{route('view.user',['id' => $user->id])}}">View</a>

                                                    <a class="btn btn-outline-warning"
                                                       href="{{route('edit.user',['id' => $user->id])}}">Edit</a>

                                                    <a class="btn btn-outline-danger"
                                                       onclick="return confirm('Are you sure you want to delete this user')"
                                                       href="{{route('delete.user',['id' => $user->id])}}">Delete</a>
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
                                
                                @if($users->total() > 0)
                                    <div class="col grid-margin grid-margin-md-0">Showing {{ $users->firstItem() }}
                                        to {{ $users->lastItem() }} of {{ $users->total() }} entries
                                    </div>
                                @else
                                    <div style="padding-left: 450px;">
                                        No records found
                                    </div>
                                @endif
                                <div class="col">
                                    <ul class="pagination flex-wrap justify-content-md-end mb-0">
                                        {{$users->links()}}
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
            <!-- <script src="{{asset('/js/jquery-1.7.1.min.js')}}" type="text/javascript"></script> -->
            <script src="{{asset('/js/bootstrap4-toggle.min.js')}}"></script>
            <script type="text/javascript">
                $('.download-report').click(function(e){
                    var URL = $(this).attr('href').split("?");
                    var reportAll = $("#report-all").serialize();
                    $(this).attr('href',URL[0]+'?'+reportAll);
                    // e.preventDefault();
                    console.log("reportAll:::",reportAll);
                    window.location.href = URL[0]+'?'+reportAll;

                })
                $('.verify-user').on('click',function(e){
                    e.preventDefault();
                    if(confirm("Are you sure want to by pass email verification ?")){
                        var id = $(this).data('id');
                        // alert("id ::"+id);
                        $.post("{{route('admin.verify-user-email')}}",{"collection":id,"_token":"{{csrf_token()}}"},function(data){
                            if(data.status=='success'){
                                $('a[data-id="'+id+'"]').before('<span class="text-success">Verified</span>').remove();
                                $('a[data-id="'+id+'"]').remove();
                            }
                        });
                    }
                });
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
                        alert
                        $(this).val(picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format('YYYY-MM-DD'));
                    });
                });
            </script>
@endsection
