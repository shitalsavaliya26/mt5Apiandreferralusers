<div class="table-responsive">
    <table id="order-listing" class="table text-black">
        <thead>
            <tr>
                <th>#id</th>
                <th>Username</th>
                <th>Amount</th>
                <th>Profit</th>
                <th>Payout date</th>
            </tr>
        </thead>
        <tbody>
        @if(isset($trading))
           @php $x = $trading->firstItem() @endphp
           @foreach($trading as $i => $pay)
                <tr>
                    <td>{{$x++}}</td>
                    <td>{{$pay->users['user_name']}}</td>
                    <td>{{number_format($pay->amount,2)}}</td>
                    <td>{{number_format($pay->profit,2)}}</td>
                    <td>{{$pay->created_at->format('m/d/Y')}}</td>
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
    @if($trading->total() > 0)
        <div class="col grid-margin grid-margin-md-0">Showing {{ $trading->firstItem() }}
            to {{ $trading->lastItem() }} of {{ $trading->total() }} entries
        </div>
    @endif
    <div class="col">
        <ul class="pagination flex-wrap justify-content-md-end mb-0">
            {{$trading->links()}}
        </ul>
    </div>
</div>