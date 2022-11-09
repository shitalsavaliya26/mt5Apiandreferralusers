@extends('layouts.app')
@section('title', 'Trading Profit')
<style>
    .error {
        color: red;
    }

    div#tabs-holder {
        border: 1px solid #eee;
        padding: 1%;
        border-top: none;
        border-left: none;
        border-right: none;
        width: 100%;
    }

    .nav-tabs .nav-link.active, .nav-tabs .nav-item.show .nav-link {
        color: #060e15 !important;
        background-color: #b9efac !important;
    }

    span#basic-addon2 {
        cursor: pointer;
    }

    div#nav-tabContent {
        text-align: center;
    }
    @media (min-width: 576px){
.flex-sm-row {
    flex-wrap: wrap !important;
}
}
</style>
@section('content')
    <div class="d-block mt-30"></div>
    <div class="text-white text-center w-100 medimagebgdiv" style="background-image: url(./images/report.png)">
        <h3 class="m-0 boldbultertext">@lang('general.report')</h3>
    </div>

    <div class="d-block mt-30"></div>
    @include('users.report_menu')

    <div class="hrlinelight mt-4 mt-xl-5 mb-5"></div>

    <header class="section-title titlebottomline">
        <h2 class="hrowheading">@lang('sidebar.trading_profit')</h2>
    </header>
    <div class="card trading-profile">
        <div class="card-body">
            <div class="d-block d-md-flex row justify-content-between mb-3">
                <div class="col grid-margin grid-margin-md-0">
                    <form>
                        <div class="d-flex flex-wrap align-items-center">
                            <div>@lang('general.show')</div>
                            <select id="pagination" class="form-control form-control-sm showperpage">
                                <option value="5" @if($items == 5) selected @endif >5</option>
                                <option value="10" @if($items == 10) selected @endif >10</option>
                                <option value="25" @if($items == 25) selected @endif >25</option>
                                <option value="50" @if($items == 50) selected @endif >50</option>
                                <option value="100" @if($items == 100) selected @endif >100</option>
                            </select>
                            <div>@lang('general.entries')</div>
                        </div>
                    </form>
                </div>
                <form method="post" action="{{route('trading-profit')}}" class="trading-profile-form">
                    @csrf
                    <div class="row mr-auto">
                        <div id="" class="input-group col-sm-8 unilevel-inputs">
                            <input type="text" placeholder="@lang('general.search_date')" name="date-range-my"
                                   value="{{$searchedDate}}"
                                   class="form-control readonly-text" readonly>
                            <input type="hidden" name="start_date" id="startdate" class="form-control">
                            <input type="hidden" name="end_date" id="enddate" class="form-control">
                            <button type="submit" name="submit"
                                    class="btn-outline-twitter input-group-text btn-search">@lang('general.search')
                            </button>
                        </div>
                        <div class="input-group col-sm-4">
                            <button type="submit" name="submit"
                                    class="btn-outline-twitter input-group-text btn-reset">@lang('general.reset')
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="d-block mt-30 d-md-none"><i class="fa fa-hand-o-right"></i> Scroll right to see data in table.
            </div>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>No.</th>
                        <th>@lang('sidebar.trading_profit')</th>
                        <th>70%</th>
                        <th>@lang('general.date')</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if($tradingProfits)
			@php $x = $tradingProfits->firstItem() @endphp
                        @foreach($tradingProfits as $i => $profit)
                            <tr>
                                <td>{{$x++}}</td>
                                <td>{{$profit->profit}}</td>
                                <td>{{$profit->amount}}</td>
                                <td>{{$profit->created_at->format('m/d/Y')}}</td>
                                @endforeach
                            </tr>
                            @else
                                @lang('general.no_record')
                            @endif
                    </tbody>
                </table>
            </div>
            <div class="d-block d-md-flex row justify-content-between mt-4 align-items-center">
                @if($tradingProfits->total() > 0)
                    <div class="col grid-margin grid-margin-md-0">@lang('general.showing') {{ $tradingProfits->firstItem() }}
                        to {{ $tradingProfits->lastItem() }} of {{ $tradingProfits->total() }} @lang('general.entries')
                    </div>
                @else
                    <div class="col-12 d-block text-center">
                        No records found
                    </div>
                @endif
                <div class="col">
                    <ul class="pagination flex-wrap justify-content-md-end mb-0">
                        {{$tradingProfits->links()}}
                    </ul>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-sm-12 col-md-5 offset-md-7 col-xl-3 offset-xl-9">
                <div class="stretch-card">
                    <div class="card cardhoverable active">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col">
                                    <p class="card-title mb-2">@lang('general.total') @lang('general.amount')</p>
                                    <h3 class="mb-0 text-uppercase">IDR {{$totalTradingProfit ? $totalTradingProfit : '0'}}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endsection
        @section('page_js')
            <script type="text/javascript">
                document.getElementById('pagination').onchange = function () {
                    window.location = "{{ $tradingProfits->url(1) }}&items=" + this.value;
                };

                $(function () {
                    $('input[name="date-range-my"]').daterangepicker({
                        opens: 'left',
                        autoUpdateInput: false,
                        locale: {
                            cancelLabel: 'Clear'
                        }
                    }, function (start, end, label) {
                        var startdate = start.format('YYYY-MM-DD h:mm:ss');
                        var enddate = end.format('YYYY-MM-DD h:mm:ss');

                        $('#startdate').val(startdate);
                        $('#enddate').val(enddate);

                    });

                    $('input[name="date-range-my"]').on('apply.daterangepicker', function (ev, picker) {
                        $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
                    });

                });
            </script>
@endsection
