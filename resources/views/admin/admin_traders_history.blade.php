@extends('layouts.admin_app')
@section('title', 'Traders History')
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
            @if(session()->has('errorFails'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    {{ session()->get('errorFails') }}
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            <h4 class="font-weight-bold">Traders History</h4>
            

            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="table-responsive">
                                <table id="order-listing" class="table text-muted">
                                    <thead>
                                    <!------------------------changes-->
                                    <tr class="text-black">
                                        <th>User</th>
                                        <th>Trader name</th>
                                        <th>Trader MT5 ID</th>
                                        <th>Amount</th>
                                        <th class="text-center">Total Investers</th>
                                        <th>Requested Date</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(!count($traders_history))
                                 <!--    <tr>
                                    	<th colspan="5" class="text-center">No records found</th>
                                    </tr> -->
                                    @else
                                    	@foreach($traders_history as $row)
                                        @if($row->traders && $row->get_user)
                                    		<tr>
                                    			<td>{{$row->get_user->user_name}}</td>
                                                <td>{{$row->traders->name}}</td>
                                                <td>@if($row->traders->mt5_username) {{$row->traders->mt5_username}} @else N/A @endif</td>
                                                <td>{{$row->amount}}</td>
                                                 <td class="text-center">
                                                    {{$row->traders->history()->where('status',1)->distinct('user_id')->count()}}
                                                </td>  
                                                <td>{{\Carbon\Carbon::parse($row->created_at)->format('m/d/Y')}}</td>
                                    			<td>
                                    				@if($row->status == 1)
                                    					<label class="badge badge-success">Approved</label>
                                    				@elseif($row->status == 2)
                                    					<label class="badge badge-danger">Rejected</label>
                                                    @elseif($row->status == 3)
                                                        <label class="badge badge-info">Expired</label>
                                    				@else
                                    					<label class="badge badge-warning">Pending</label>
                                    				@endif
                                    			</td>
                                    			<td>
                                                    @if($row->status == 1)
                                                         <a href="#" data-remarks="{{ nl2br($row->remarks) }}" class="badge badge-outline-primary pop view-remarks">Remarks</a>
                                                    @elseif($row->status == 2)
                                                         <a href="#" data-remarks="{{ nl2br($row->remarks) }}" class="badge badge-outline-primary pop view-remarks">Remarks</a>
                                                    @elseif($row->status == 3)
                                                         <a href="#" data-remarks="{{ nl2br($row->remarks) }}" class="badge badge-outline-primary pop view-remarks">Remarks</a>
                                                    @else
                                                        <a href="javascript:void(0)" data-id="{{$row->id}}" data-status="1" class="badge badge-outline-primary pop updateStatus">Action</a>       
                                                    @endif         
                                                
                                    		</tr>
                                            @endif
                                   		@endforeach
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                            <div class="d-block d-md-flex row justify-content-between mt-4 align-items-center">
                                 @if($traders_history->total() > 0)
                                    <div class="col grid-margin grid-margin-md-0">Showing {{ $traders_history->firstItem() }}
                                        to {{ $traders_history->lastItem() }} of {{ $traders_history->total() }} entries
                                    </div>
                                @else
                                    <div style="padding-left: 450px;">
                                        No records found
                                    </div>
                                @endif
                                <div class="col">
                                    <ul class="pagination flex-wrap justify-content-md-end mb-0">
                                        {{$traders_history->links()}}
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--Traders status change model-->
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

            <div class="modal fade" id="TradersChangeStatus" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title inline" id="exampleModalLabel">Update Trader Request</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form class="forms-sample" id="updateRequest" method="post" action="{{route('traders-change-status')}}">
                                    @csrf
                                    @method('POST')
                                    <div class="form-group row col-sm-12">
                                        <label for="details_en">Remarks</label>
                                        <input type="hidden" id="history_id" name="history_id">
                                        <textarea type="text" rows="6" class="form-control" id="remarks" name="remarks" placeholder="Remarks"></textarea>
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
                                                    <input type="radio" class="form-check-input" name="status" id="status" value="2">
                                                    Reject
                                                </label>
                                            </div>
                                        </div>
                                        <div id="error-display"></div>
                                    </div>
                                    <br>
                                    <button type="submit" name="submit" class="btn btn-primary mr-2">Submit</button>
                                    <a class="btn btn-light" href="{{route('traders-history')}}">Back</a>
                                </form>
                            </div>
                        </div>
                    </div>
                <!-- <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        {{ Form::open(['route' => 'traders-change-status','id'=>'TradersStatusForm', 'method' => 'POST'])}}
                        <div class="modal-body pt-4 pb-4" style="border: none;">
                            Are you sure?
                        </div>
                        <div class="modal-footer">
                            {!!Form::hidden('id','',['id'=>'traders_id'])!!}
                            {!!Form::hidden('status','',['id'=>'traders_status'])!!}
                            <button type="submit" class="btn btn-primary">
                                <span id="submit_btn">Submit</span>
                            </button>
                            <button type="button" data-dismiss="modal" class="btn">Cancel</button>
                        </div>
                        {!!Form::close()!!}
                    </div>
                </div> -->
            </div>
            <!--End model-->
        </div>
        
@endsection
@section('page_js')
<script src="{{asset('/js/jquery.validate.min.js')}}"></script>

<script type="text/javascript">
    
    $('.updateStatus').on('click',function(){
        var id = $(this).data('id');

        if(status == '1'){
            $('#submit_btn').html('Approve');
        }else{
            $('#submit_btn').html('Reject');
        }

        $('#history_id').val(id);
        $('#TradersChangeStatus').modal('show');
    });

      $('.view-remarks').on('click', function () {
            var remarks = $(this).data('remarks');
            $('.remarks').html(remarks);
            $('#view-remarks').modal('show');
        });
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
@endsection
