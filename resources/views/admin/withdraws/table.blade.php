<table id="order-listing" class="table text-muted">
    <thead>
        <tr class="text-black">
            <th width="50px"><input type="checkbox" id="master"></th>
            <th>No.</th>
            <th>Username</th>
            <th>Amount</th>
            <th>Withdrawal fees</th>
            <th>Status</th>
            <th>Date</th>
            <th>Actions</th>
        </tr>
    </thead>
    
    @if($withdraws)
        <tbody>
            @php $x = $withdraws->firstItem() @endphp
            
            @foreach($withdraws as $i => $withdraw)
                <tr id="tr_{{$withdraw->id}}">
                    
                    @if($withdraw->status == '0')
                        <td><input type="checkbox" class="sub_chk" data-id="{{$withdraw->id}}"></td>
                    @else
                        <td></td>
                    @endif
                    
                    <td>{{$x++}}</td>
                    <td>{{$withdraw->users['user_name']}}</td>
                    <td>{{$withdraw->amount}}</td>
                    <td>{{$withdraw->withdrawal_fees ? $withdraw->withdrawal_fees : '-'}}</td>
                    
                    @if($withdraw->status == 1)
                        <td><label class="badge badge-success">Approved</label></td>
                    @elseif($withdraw->status == 2)
                        <td><label class="badge badge-danger">Rejected</label></td>
                    @else
                        <td><label class="badge badge-warning">Pending</label></td>
                    @endif
                    
                    <td>{{$withdraw->created_at->format('m/d/Y')}}</td>

                    @if($withdraw->status == '0')
                        <td><a class="btn btn-outline-dark update-withdraw"
                               data-id="{{$withdraw->id}}" data-amount="{{$withdraw->amount}}"
                               data-user_id="{{$withdraw->users['id']}}">Action</a>
                        </td>
                    @else
                        <td><a href="#" data-remarks="{{nl2br($withdraw->remarks)}}"
                               class="badge badge-outline-primary pop view-remarks">Remarks</a>
                        </td>
                    @endif
                </tr>
            @endforeach
        </tbody>
    @else
        No Request found
    @endif
</table>

<div class="d-block d-md-flex justify-content-between mt-4 mr-auto align-items-center">
    @if($withdraws->total() > 0)
        <div class="col grid-margin grid-margin-md-0">@lang('general.showing') {{ $withdraws->firstItem() }}
            to {{ $withdraws->lastItem() }} of {{ $withdraws->total() }} @lang('general.entries')
        </div>
    @else
        <div style="padding-left: 450px;">
            No records found
        </div>
    @endif
	
{!! $withdraws->render() !!}
</div>

<script type="text/javascript">
    jQuery.noConflict();
    
    $('.update-withdraw').on('click', function () {
        var id = $(this).data('id');
        var user_id = $(this).data('user_id');
        var amount = $(this).data('amount');
        var newsrc = "{{url('avanya-vip-portal/update-withdraw-status')}}";

        $('input#user_id').val(user_id);
        $('input#amount').val(amount);
        $('#update-withdraw').attr('action', newsrc + "/".concat(id));
        $('#updateWithdraw').modal('show');
    });

    $('.view-remarks').on('click', function () {
        var remarks = $(this).data('remarks');
        $('.remarks').text(remarks);
        $('#view-remarks').modal('show');
    });

    jQuery(document).ready(function () {
    
        jQuery('#master').on('click', function (e) {
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