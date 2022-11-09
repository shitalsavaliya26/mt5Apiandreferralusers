@extends('layouts.admin_app')
@section('title', 'Trader Report')
@section('content')
<div class="main-panel">
    <div class="content-wrapper">
        <h4 class="font-weight-bold">Trader Report</h4>
        <div class="row">

            <div class="col">
                <form method="get" action="{{route('trader_report')}}" id="report-all">
                   <?php 
                   $parameter = '';
                   foreach ($_GET as $key => $value) {
                    $parameter .= $key.'='.$value.'&';
                }

                ?>
                <div class="ml-2 mt-4 mb-2 text-right">
                   <a class="col-sm-12 col-lg-2 col-md-4 btn text-black btn-outline-dark mt-2" href="{{route('trader-report-exports').'?'.$parameter}}">Export Report</a></div>
                   <div class="ml-2 mt-4 mb-2 text-right">
                    <div id="" class="input-group">
                        <input type="text" id="date-range-my" placeholder="Select Date" value="{{$searchedDate}}" class="form-control">
                        <input type="hidden" name="start_date" value="{{@$data['start_date']}}" id="startdate" class="form-control">
                        <input type="hidden" name="end_date" value="{{@$data['end_date']}}" id="enddate" class="form-control">
                        <span class="input-group-addon input-group-append border-left">
                            {{-- <button type="submit" name="date-range" class="ti-calendar input-group-text"></button>--}}
                        </span>
                        <select class="mx-1 form-control" name="trader_id" id="trader_id">
                            <option value="">Select Trader</option>
                            @foreach($traders as $trader)
                            <option value="{{$trader->id}}" @if($trader->id == $searchedtrader_id) selected @endif>{{$trader->name}}</option>
                            @endforeach
                        </select>
                        <select class="mx-1 form-control" name="user_id" id="user_id">
                            <option value="">Select Investor</option>
                            @foreach($investors as $investor)
                            <option value="{{$investor->id}}" @if($investor->id == $searcheduser_id) selected @endif>{{$investor->user_name}}</option>
                            @endforeach
                        </select>
                        <button type="submit" class=" btn-outline-twitter input-group-text">
                            Search
                        </button>
                        <a class="btn-outline-twitter input-group-text mx-1" onmouseout = "$(this).css('color','#2caae1');" 
                        onmouseover = "$(this).css('color','white');" id="reset_link" style="color:#2caae1;text-decoration: none;" href="{{route('trader_report')}}">@lang('general.reset')
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
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-12">
                <div class="table-responsive">
                    <table id="order-listing" class="table text-muted">
                        <thead>
                            <!------------------------changes-->
                            <tr class="text-black">
                                <th>No.</th>
                                <th>Investor</th>
                                <th>Trader MT5 ID</th>
                                <th>Capital</th>
                                <th>Date From</th>
                                <th>Date To</th>
                                <th>Trader</th>
                                <th class="text-center">Total Investers</th>
                                <th>Trading Profit</th>
                                <th>Traders Commission</th>
                            </tr>
                        </thead>
                        @if(!count($traders_history))
                        <tbody>
                            <tr>
                             <th colspan="10" class="text-center">No records found</th>
                         </tr>
                     </tbody>
                     @else
                     <tbody>
                        @php 
                        $x = $traders_history->firstItem() 
                        @endphp
                        @foreach($traders_history as $row)
                        @if($row->traders && $row->get_user)
                        <tr>
                            <th>{{$x++}}</th>
                            <td>{{$row->get_user->user_name}}</td>
                            <td>@if($row->traders->mt5_username) {{$row->traders->mt5_username}} @else N/A @endif</td>
                            <td>{{$row->amount}}</td>
                            <td>{{$row->start_date}}</td>
                            <td>{{$row->end_date}}</td>
                            <td>{{$row->traders->name}}</td>
                            <td class="text-center">
                                {{$row->traders->history()->where('status',1)->distinct('user_id')->count()}}
                            </td>                     
                            <td>{{number_format($row->profit,2)}}</td>
                            <td>{{number_format($row->commission,2)}}</td>
                        </tr>
                        @endif
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td></td>
                            <td></td>
                            <td>Total:</td>
                            <td>{{number_format($traders_history->sum('amount'),2)}}</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>{{number_format($traders_history->sum('profit'),2)}}</td>
                            <td>{{number_format($traders_history->sum('commission'),2)}}</td>
                        </tr>
                    </tfoot>
                    @endif

                </table>
            </div>
            <div class="d-block d-md-flex row justify-content-between mt-4 align-items-center">
             @if($traders_history->total() > 0)
             <div class="col grid-margin grid-margin-md-0">Showing {{ $traders_history->firstItem() }}
                to {{ $traders_history->lastItem() }} of {{ $traders_history->total() }} entries
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
</div>

@endsection
@section('page_js')
<script type="text/javascript">
    $('#date-range-my').daterangepicker({
        opens: 'left',
        autoUpdateInput: false,
        locale: {
            cancelLabel: 'Clear'
        },
        maxDate:new Date(),
    }, function (start, end, label) {
        var startdate = start.format('YYYY-MM-DD h:mm:ss');
        var enddate = end.format('YYYY-MM-DD h:mm:ss');

        $('#startdate').val(startdate);
        $('#enddate').val(enddate);

    });

    $('#date-range-my').on('apply.daterangepicker', function (ev, picker) {
        $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
    });
</script>
@endsection
