<table id="order-listing" class="table text-muted">
    <thead>
        <tr class="text-black">
            <th width="50px"><input type="checkbox" id="master"></th>
            <th>No.</th>
            <th>Username</th>
            <th class="text-center">Amount </th>
            <th class="text-center">Processing Fees</th>
            <th class="text-center">Processing Percentage</th>
            <th>Proofs</th>
            <th>Status</th>
            <th>Date</th>
            <th>Actions</th>
        </tr>
    </thead>
    
    @if($topupFunds)
        <tbody>
            @php 
                $x = $topupFunds->firstItem(); 
                $TotalAmount = $TotalProcessingFee = $TotalProcessingPercentage = 0;
            @endphp
            
            @foreach($topupFunds as $i => $fund)
                
                <tr id="tr_{{$fund->id}}">
                    
                    @if($fund->status == '0')
                        <td>
                            <input type="checkbox" class="sub_chk" data-id="{{$fund->id}}"  data-user_id="{{$fund->users['id']}}">
                        </td>
                    @else
                        <td></td>
                    @endif

                    <td>{{$x++}}</td>
                    <td>{{$fund->users['user_name']}}</td>
                    <td id="amount" class="text-center">
                        {{$fund->amount}}
                        @if($fund->status == 1)
                        @php 
                            $TotalAmount = $TotalAmount + $fund->amount; 
                        @endphp
                        @endif
                    </td>
                    <td class="text-center">
                        {{number_format($fund->processing_fees,2)}}
                        @if($fund->status == 1)
                        @php 
                            $TotalProcessingFee = $TotalProcessingFee + $fund->processing_fees; 
                        @endphp
                        @endif
                    </td>
                    <td class="text-center">
                        {{($fund->processing_percentage != '') ? $fund->processing_percentage : '0'}}
                        @if($fund->status == 1)
                        @php 
                            $TotalProcessingPercentage = $TotalProcessingPercentage + $fund->processing_percentage; 
                        @endphp
                        @endif
                    </td>
                    <td><a href="{{asset('topup_reciepts/'.$fund->reciept_topup)}}" target="_blank">Topup Receipt</a><br>
                        <a href="{{asset('process_reciepts/'.$fund->reciept_process)}}" target="_blank">Process Receipt</a></td>
                    
                    @if($fund->status == 1)
                        <td><label class="badge badge-success">Approved</label></td>
                    @elseif($fund->status == 2)
                        <td><label class="badge badge-danger">Rejected</label></td>
                    @else
                        <td><label class="badge badge-warning">Pending</label></td>
                    @endif
                    
                    <td>{{$fund->created_at->format('m/d/Y')}}</td>

                    @if($fund->status == '0')
                        <td>
                            <a class="btn btn-outline-dark update-topup" data-id="{{$fund->id}}" data-amount="{{$fund->amount}}" data-user_id="{{$fund->users['id']}}">Action</a>
                        </td>
                    @else
                        <td>
                            <a href="#" data-remarks="{{nl2br($fund->remarks)}}" class="badge badge-outline-primary pop view-remarks">Remarks</a>
                        </td>
                    @endif

                </tr>
                <input type="hidden" id="user_id" value="{{$fund->users['id']}}">
            @endforeach
                <tr>
                    <td colspan="3" class="text-right">{{__('Total')}}</td>
                    <td class="text-center">{{number_format($TotalAmount,2)}}</td>
                    <td class="text-center">{{number_format($TotalProcessingFee,2)}}</td>
                    <td></td>
                    <td ></td>
                    <td ></td>
                    <td ></td>
                </tr>
        </tbody>
    @else
        No Request found
    @endif
</table>

<div class="d-block d-md-flex justify-content-between mt-4 mr-auto align-items-center">
    @if($topupFunds->total() > 0)
        <div class="col grid-margin grid-margin-md-0">@lang('general.showing') {{ $topupFunds->firstItem() }}
            to {{ $topupFunds->lastItem() }} of {{ $topupFunds->total() }} @lang('general.entries')
        </div>
    @else
        <div style="padding-left: 450px;">
            No records found
        </div>
    @endif
   {!! $topupFunds->render() !!}
</div>

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
        $('.remarks').text(remarks);
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

    });
</script>   