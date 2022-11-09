@extends('layouts.admin_app')
@section('title', 'Capital Withdrawal Request')
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
            <h4 class="font-weight-bold">Capital Withdrawal Requests</h4>
            

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
                                        <th>Amount</th>
                                        <th>Request Date</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(!count($capital_withdraw))
                                    <tr>
                                    	<th colspan="5" class="text-center">No records found</th>
                                    </tr>
                                    @else
                                    	@foreach($capital_withdraw as $row)
                                    		<tr>
                                    			<td>{{$row->user_id != 0 ? $row->get_user_details->user_name : '0'}}</td>
                                    			<td>{{$row->amount}}</td>
                                    			<td>{{$row->created_at}}</td>
                                    			<td>
                                    				@if($row->status == 1)
                                    					<label class="badge badge-success">Approved</label>
                                    				@elseif($row->status == 2)
                                    					<label class="badge badge-danger">Rejected</label>
                                    				@else
                                    					<label class="badge badge-warning">Pending</label>
                                    				@endif
                                    			</td>
                                    			<td>
                                    				@if($row->status == 1)
                                    					N/A
                                    				@elseif($row->status == 2)
                                    					N/A
                                    				@else
                                    					<a href="javascript:void(0)" data-id="{{$row->id}}" data-status="1" class="badge badge-outline-primary pop updateStatus">Approve</a>       
                                    					<a href="javascript:void(0)" data-id="{{$row->id}}" data-status="2" class="badge badge-outline-danger pop updateStatus">Reject</a>
                                    				@endif
                                    			</td>
                                    		</tr>
                                   		@endforeach
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                            <div class="d-block d-md-flex row justify-content-between mt-4 align-items-center">
                                 @if($capital_withdraw->total() > 0)
                                    <div class="col grid-margin grid-margin-md-0">Showing {{ $capital_withdraw->firstItem() }}
                                        to {{ $capital_withdraw->lastItem() }} of {{ $capital_withdraw->total() }} entries
                                    </div>
                                @else
                                    <div style="padding-left: 450px;">
                                        No records found
                                    </div>
                                @endif
                                <div class="col">
                                    <ul class="pagination flex-wrap justify-content-md-end mb-0">
                                        {{$capital_withdraw->links()}}
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="updateCapWithdrawReq" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        {{ Form::open(['route' => 'capital-withdraw-change-status','id'=>'WithdrawalStatusForm', 'method' => 'POST'])}}
                        <div class="modal-body pt-4 pb-4" style="border: none;">
                            Are you sure?
                        </div>
                        <div class="modal-footer">
                            {!!Form::hidden('id','',['id'=>'withdraw_request_id'])!!}
                            {!!Form::hidden('status','',['id'=>'withdraw_request_status'])!!}
                            <button type="submit" class="btn btn-primary">
                                <span id="submit_btn">Submit</span>
                            </button>
                            <button type="button" data-dismiss="modal" class="btn">Cancel</button>
                        </div>
                        {!!Form::close()!!}
                    </div>
                </div>
            </div>
        </div>
        
@endsection
@section('page_js')
<script type="text/javascript">
	$('.updateStatus').on('click',function(){
		var id = $(this).data('id');
		var status = $(this).data('status');

		if(status == '1'){
			$('#submit_btn').html('Approve');
		}else{
			$('#submit_btn').html('Reject');
		}

		$('#withdraw_request_id').val(id);
		$('#withdraw_request_status').val(status);
		$('#updateCapWithdrawReq').modal('show');
	});
</script>

@endsection
