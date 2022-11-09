<div class="table-responsive">
    <table id="order-listing" class="table text-black">
        <thead>
            <tr>
                <th>#id</th>
                <th>Username</th>
                <th>MT5 ID</th>
                <th>Trading Profit</th>
                <th>Unilevel</th>
                <th>Leadership Bonus</th>
                <th>Profit Sharing</th>
                <th>Ownership Bonus</th>
                <th>Payout date</th>
                <!-- <th>Action</th> -->
            </tr>
        </thead>
        <tbody>
        @if($reports)
           @php $x = $reports->firstItem() @endphp
           @foreach($reports as $i => $pay)
                <tr>
                    <td>{{$x++}}</td>
                    <td>{{$pay->users['user_name']}}</td>
                    <td>{{$pay->users['mt4_username']}}</td>
                    <td>{{$pay->trading_profit}}</td>
                    <td>{{$pay->unilevel}}</td>
                    <td>{{$pay->leadership_bonus}}</td>
                    <td>{{$pay->profit_sharing}}</td>
                    <td>{{$pay->ownership_bonus}}</td>
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
<hr>
<div class="row">
    @if($reports->total() > 0)
        <div class="col grid-margin grid-margin-md-0">Showing {{ $reports->firstItem() }}
            to {{ $reports->lastItem() }} of {{ $reports->total() }} entries
        </div>
    @endif
    <div class="col">
        <ul class="pagination flex-wrap justify-content-md-end mb-0">
            {{$reports->links()}}
        </ul>
    </div>
</div>