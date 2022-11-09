<div class="table-responsive">
    <table id="order-listing" class="table text-black">
        <thead>
            <tr>
                <th>#id</th>
                <th>Username</th>
                <th>Amount</th>
                <th>Profit</th>
                <th>Payout date</th>
                <!-- <th>Action</th> -->
            </tr>
        </thead>
        <tbody>
        @if($leadership)
           @php $x = $leadership->firstItem() @endphp
           @foreach($leadership as $i => $pay)
                <tr>
                    <td>{{$x++}}</td>
                    <td>{{$pay->users['user_name']}}</td>
                    <td>{{number_format($pay->amount,2)}}</td>
                    <td>{{number_format($pay->profit,2)}}</td>
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
    @if($leadership->total() > 0)
        <div class="col grid-margin grid-margin-md-0">Showing {{ $leadership->firstItem() }}
            to {{ $leadership->lastItem() }} of {{ $leadership->total() }} entries
        </div>
    @endif
    <div class="col">
        <ul class="pagination flex-wrap justify-content-md-end mb-0">
            {{$leadership->links()}}
        </ul>
    </div>
</div>