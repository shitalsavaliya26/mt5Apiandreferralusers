<div class="table-responsive">
    <table id="order-listing" class="table text-black">
        <thead>
            <tr>
                <th>#id</th>
                <th>Username</th>
                <th>MT5 ID</th>
                <th>Amount</th>
                <th>Commission</th>
                <th>Payout date</th>
                <!-- <th>Action</th> -->
            </tr>
        </thead>
        <tbody>
        @if(isset($ownership))
           @php $x = $ownership->firstItem() @endphp
           @foreach($ownership as $i => $pay)
                <tr>
                    <td>{{$x++}}</td>
                    <td>{{$pay->users['user_name']}}</td>
                    <td>{{$pay->users['mt4_username']}}</td>
                    <td>{{$pay->amount}}</td>
                    <td>{{$pay->commission}}</td>
                    <td>{{$pay->created_at->format('m/d/Y')}}</td>
                    <!-- <td><a href="#" class="view_breakdown" data-user_id="{{$pay->user_id}}">lang('general.view') @lang('general.breakdown')</a></td> -->
                </tr>
            @endforeach
        @else
            <tr><td colspan="9">No Report found</td></tr>
        @endif
        </tbody>
    </table>
</div>
@if($ownership->total() > 0)
    <div class="col grid-margin grid-margin-md-0">Showing {{ $ownership->firstItem() }}
        to {{ $ownership->lastItem() }} of {{ $ownership->total() }} entries
    </div>
@endif
<div class="col">
    <ul class="pagination flex-wrap justify-content-md-end mb-0">
        {{$ownership->links()}}
    </ul>
</div>