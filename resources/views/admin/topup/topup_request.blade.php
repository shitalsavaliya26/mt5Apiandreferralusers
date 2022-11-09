@extends('layouts.admin_app')
@section('title', 'Topup Request')


@section('content')

<style>
    .error {
        color: red;
    }
    .pagination {
        margin-left: auto !important;
    }
</style>
    <div class="main-panel topup-fund-request">
        <div class="content-wrapper">
            <h4 class="font-weight-bold">Topup Fund Request</h4>
            
            <div class="row">
                <div class="col-sm-8 ml-auto" style="float: right;">
                    <a class="btn text-black btn-outline-success" href="{{route('topup-import-view')}}">Imports</a>
                    <a class="btn text-black btn-outline-dark download-report" href="{{route('topup-exports',$ext = 'xls')}}">Exports
                        XLS</a>
                    <a class="btn text-black btn-outline-dark download-report" href="{{route('topup-exports',$ext = 'xlsx')}}">Exports
                        XLSX</a>
                    <a class="btn text-black btn-outline-dark download-report" href="{{route('topup-exports',$ext = 'csv')}}">Exports
                        CSV</a>
                </div>
            </div>
            
            <br/>
            
            <div class="row">
                <label class="col-form-label ml-3">Bulk Action </label>
                <div class="col-sm-3">
                    <select class="form-control" name="status" id="status">
                        <option value="">Select</option>
                        <option value="1">Approve</option>
                        <option value="2">Reject</option>
                    </select>
                </div>
                <div class="form-group">
                    <button class="btn btn-warning update_all">Apply</button>
                </div>
                <div class="col">
                    <form method="get" action="{{route('get-topup-request')}}" id="report-all">
                        <div class="ml-1 row">
                            <div id="" class="input-group">
                                <input type="text" id="date-range-my" autocomplete="off" placeholder="Select Date"
                                       value="{{$searchedDate}}"
                                       class="form-control">
                                <input type="hidden" name="start_date" value="{{@$data['start_date']}}" id="startdate" class="form-control">
                                <input type="hidden" name="end_date" value="{{@$data['end_date']}}" id="enddate" class="form-control">
                                <span class="input-group-addon input-group-append border-left"></span>
                                <input type="text" name="username" placeholder="Search by username" value="{{$name}}"
                                       class="mx-1 form-control">
                                <button type="submit"  
                                        class="btn-outline-twitter input-group-text">Search
                                </button>
				<a class="btn-outline-twitter input-group-text mx-1" onmouseout = "$(this).css('color','#2caae1');" 
                                        onmouseover = "$(this).css('color','white');" id="reset_link" style="color:#2caae1;text-decoration: none;" href="{{route('get-topup-request')}}">@lang('general.reset')
                                        </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            
            @if(session()->has('message'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    {{ session()->get('message') }}
                </div>
            @endif

            @if(session()->has('statusUpdate'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                     Bulk status updated successfully.
                     <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    {{ session()->get('message') }}
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="table-responsive" id="tag_container">
                                @include('admin.topup.table')
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="updateTopUp" tabindex="-1" aria-labelledby="myModalLabel"
                     aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title inline" id="exampleModalLabel">Update Topup request</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form class="forms-sample" id="updateRequest" method="post">
                                    @csrf
                                    @method('POST')
                                    <div class="form-group row">
                                        <label for="details_en">Remarks</label>
                                        <input type="hidden" id="user_id" name="user_id">
                                        <input type="hidden" id="amount" name="amount">
                                        <textarea type="text" rows="6" class="form-control" id="remarks" name="remarks"
                                                  placeholder="Remarks"></textarea>
                                        <div id="error-remarks"></div>
                                    </div>
                                    <div class="form-group row vertical-align-center">
                                        <label class="col-sm-3 pt-2 col-form-label">Status</label>
                                        <div class="col-sm-5">
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input type="radio" class="form-check-input" name="status"
                                                           id="status" value="1">
                                                    Approve
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input type="radio" class="form-check-input" name="status"
                                                           id="status" value="2">
                                                    Reject
                                                </label>
                                            </div>
                                        </div>
                                        <div id="error-display"></div>
                                    </div>
                                    <br>
                                    <button type="submit" name="submit" class="btn btn-primary mr-2">Submit</button>
                                    <a class="btn btn-light" href="{{route('get-topup-request')}}">Back</a>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="updateBulkTopUp" tabindex="-1" aria-labelledby="myModalLabel"
                     aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title inline" id="exampleModalLabel">Update Bulk Topup request</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                    <div class="form-group row">
                                        <label for="details_en">Remarks</label>
                                        <textarea type="text" class="form-control" id="bulk_remarks" name="bulk_remarks"
                                                  placeholder="Remarks"></textarea>
                                        <div id="error-bulk-remarks"></div>
                                    </div>
                                    <br>
                                    <button type="submit" name="submit"  id="bulk-submit" class="btn btn-primary mr-2">Submit</button>
                                    <a class="btn btn-light" href="{{route('get-topup-request')}}">Back</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="view-remarks" tabindex="-1" aria-labelledby="myModalLabel"
                     aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title inline" id="exampleModalLabel">Remarks</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="modal-body" style=" overflow-x:auto;">
                                <div class="form-group row vertical-align-center remarks">
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
        $('.download-report').click(function(e){
            var URL = $(this).attr('href').split("?");
            var reportAll = $("#report-all").serialize();
            $(this).attr('href',URL[0]+'?'+reportAll);
            // e.preventDefault();
            console.log("reportAll:::",reportAll);
            window.location.href = URL[0]+'?'+reportAll;

        })
	 function f1(){
            $("#reset_link").css('color','white');
        }
        function f2(){
            $("#reset_link").css('color','#2caae1');
        }

        $('#updateRequest').validate({
            rules: {
                remarks: {
                    required: true
                },
                status: {
                    required: true
                },
            },
            errorPlacement: function (error, element) {
                if (element.attr("name") == "status") {
                    error.appendTo($('#error-display'));
                } else if (element.attr("name") == "remarks") {
                    error.appendTo($('#error-remarks'));
                }
            }
        });
    </script>

    <script type="text/javascript">
        jQuery.noConflict();

        $('.update-topup').on('click', function () {
            var id = $(this).data('id');
            var user_id = $(this).data('user_id');
            var amount = $(this).data('amount');
            var newsrc = "{{url('avanya-vip-portal/update-topup-status')}}";

            $('input#user_id').val(user_id);
            $('input#amount').val(amount);
            $('#updateRequest').attr('action', newsrc + "/".concat(id));
            $('#updateTopUp').modal('show');
        });

        $('.view-remarks').on('click', function () {
            var remarks = $(this).data('remarks');
            $('.remarks').html(remarks);
            $('#view-remarks').modal('show');
        });

        $(document).ready(function () {

            $('#master').on('click', function (e) {
                if ($(this).is(':checked', true)) {
                    $(".sub_chk").prop('checked', true);
                } else {
                    $(".sub_chk").prop('checked', false);
                }
            });

            $('.sub_chk').click(function(){
                if (!$(this).is(':checked')) {
                    $('#master').prop('checked', false);
                }
            });

            $('.update_all').on('click', function (e) {
                var allVals = [];
                var allUserIds = [];

                $(".sub_chk:checked").each(function () {
                    allVals.push($(this).attr('data-id'));
                    allUserIds.push($(this).attr('data-user_id'));
                });

                var status = $('#status').val();
                if (status.length <= 0) {
                    alert('please select action');
                    return true;
                }
                if (allVals.length <= 0) {
                    alert("Please select request.");
                } else {

                    $('#updateBulkTopUp').modal('show');
                   
                    $("#bulk-submit").click(function(){                              
                       var remarks = $('#bulk_remarks').val();
                       var join_selected_values = allVals.join(",");
                       var join_User_ids = allUserIds.join(",");

                       if (remarks != '') {
                            $.ajax({
                                url: '{{route('bulk-topup-request-update')}}',
                                type: 'POST',
                                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                                data: {
                                    'ids': join_selected_values,
                                    'userIds': join_User_ids,
                                    'status': status,
                                    'remarks' : remarks
                                },
                                success: function (data) {
                                    if (data.status == true) {
                                        window.location.href = "{{route('get-topup-request-redirect')}}";
                                    }
                                },
                                error: function (data) {
                                    alert(data.responseText);
                                }
                            });  
                       } else {
                            $("#error-bulk-remarks").html("<span style='color:red;'>Please enter remark</span>");
                            return false;
                       }
                    });                            
                }
            });
        });
    </script>

    <script>
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

        $('#date-range-my').on('apply.daterangepicker', function (ev, picker) {
            $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
        });
    </script>
@endsection