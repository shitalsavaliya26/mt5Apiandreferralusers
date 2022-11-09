@extends('layouts.app')
@section('title','Total Report')
<style>
    .error {
        color: red;
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
    <nav class="nav flex-column flex-sm-row justify-content-sm-center reportbuttons" style="flex-wrap:unset;">
        <a class="mb-3 mb-xl-0 btn btn-light btn-rounded"
           href="{{route('trading-profit')}}">@lang('sidebar.trading_profit')</a>
        <a class="mb-3 mb-xl-0 btn btn-light btn-rounded" href="{{route('unilevel')}}">@lang('sidebar.unilevel')</a>
        <a class="mb-3 mb-xl-0 btn btn-light btn-rounded"
           href="{{route('profit-sharing')}}">@lang('sidebar.profit_sharing')</a>
        <a class="mb-3 mb-xl-0 btn btn-light btn-rounded"
           href="{{route('leadership-bonus')}}">@lang('sidebar.leadership_bonus')</a>
        <a class="mb-3 mb-xl-0 btn btn-light btn-rounded"
           href="{{route('ownership-bonus')}}">@lang('sidebar.ownership_bonus')</a>
        <a class="mb-3 mb-xl-0 btn btn-my-gradient btn-rounded text-uppercase font-weight-bolder"
           href="{{route('total-report')}}">@lang('sidebar.total')</a>
    </nav>

    <div class="hrlinelight mt-4 mt-xl-5 mb-5"></div>

    <header class="section-title titlebottomline">
        <h2 class="hrowheading">@lang('sidebar.total')</h2>
    </header>
    <div id="checkbox-warning" class="col-md-6 mx-auto">

    </div>
    <div class="form-group nav flex-column flex-sm-row reportcheckboxes">
        <div class="form-check form-check-secondary">
            <label class="form-check-label">
                <input type="checkbox" checked="checked" name="trading_profit" class="form-check-input"
                       data-id="cal_trade">
                @lang('sidebar.trading_profit')
            </label>
        </div>
        <div class="form-check form-check-secondary">
            <label class="form-check-label">
                <input type="checkbox" checked="checked" name="unilevel" class="form-check-input" data-id="cal_uni">
                @lang('sidebar.unilevel')
            </label>
        </div>
        <div class="form-check form-check-secondary">
            <label class="form-check-label">
                <input type="checkbox" checked="checked" name="profit_sharing" class="form-check-input"
                       data-id="cal_profit">
                @lang('sidebar.profit_sharing')
            </label>
        </div>
        <div class="form-check form-check-secondary">
            <label class="form-check-label">
                <input type="checkbox" checked="checked" name="leadership_bonus" class="form-check-input"
                       data-id="cal_leader">
                @lang('sidebar.leadership_bonus')
            </label>
        </div>
        <div class="form-check form-check-secondary">
            <label class="form-check-label">
                <input type="checkbox" class="form-check-input" name="ownership_bonus" checked="checked"
                       data-id="cal_owner">
                @lang('sidebar.ownership_bonus')
            </label>
        </div>
    </div>

    <div class="card total-report">
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
                <form method="post" action="{{route('total-report')}}">
                    @csrf
                    <div class="row mr-auto">
                        <div id="" class="input-group col-sm-6">
                            <input type="text" name="date-range-my" placeholder="@lang('general.search_date')" id="date-range"
                                   value="{{$searchedDate}}" class="form-control readonly-text" readonly>
                            <input type="hidden" name="start_date" id="startdate" class="form-control">
                            <input type="hidden" name="end_date" id="enddate" class="form-control">
                            <span class="input-group-addon input-group-append border-left">
                                <i  class="ti-calendar input-group-text"></i>
                            </span>
                        </div>
                        <div class="input-group col-sm-3">
                            <button type="submit" name="submit" class="btn-outline-twitter input-group-text btn-search">@lang('general.search')</button>
                        </div>
                        <div class="input-group col-sm-3">
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
                        <th class="trading_profit">@lang('sidebar.trading_profit')</th>
                        <th class="unilevel">@lang('sidebar.unilevel')</th>
                        <th class="profit_sharing">@lang('sidebar.profit_sharing')</th>
                        <th class="leadership_bonus">@lang('sidebar.leadership_bonus')</th>
                        <th class="ownership_bonus">@lang('sidebar.ownership_bonus')</th>
                        <th>@lang('sidebar.total')</th>
                        <th>@lang('general.date')</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                    @if($totalReports)
			@php $x = $totalReports->firstItem() @endphp
                        @foreach($totalReports as $i => $report)
                            @php
                                $sum = $report->trading_profit + $report->unilevel + $report->profit_sharing + $report->leadership_bonus + $report->ownership_bonus;
                            @endphp
                            <tr>
                                <td>{{$x++}}</td>
                                <td class="trading_profit" id="cal_trade-{{$i}}">{{$report->trading_profit}}</td>
                                <td class="unilevel" id="cal_uni-{{$i}}">{{$report->unilevel}}</td>
                                <td class="profit_sharing" id="cal_profit-{{$i}}">{{$report->profit_sharing}}</td>
                                <td class="leadership_bonus" id="cal_leader-{{$i}}">{{$report->leadership_bonus}}</td>
                                <td class="ownership_bonus" id="cal_owner-{{$i}}">{{$report->ownership_bonus}}</td>
                                <td><span class="text-white font-large" id="total-{{$i}}">{{$sum}}</span></td>
                                <td>{{$report->created_at->format('m/d/y')}}</td>
                                @endforeach
                                @else
                                    @lang('general.no_record')
                                @endif
                            </tr>
                    </tbody>
                </table>
            </div>
            <input type="hidden" value="{{$i}}" id="totalrecords">
            <div class="d-block d-md-flex row justify-content-between mt-4 align-items-center">
                
                @if($totalReports->total() > 0)
                    <div class="col grid-margin grid-margin-md-0">@lang('general.showing') {{ $totalReports->firstItem() }}
                        to {{ $totalReports->lastItem() }} of {{ $totalReports->total() }} @lang('general.entries')
                    </div>
                @else
                    <div class="col-12 d-block text-center">
                        No records found
                    </div>
                @endif
                <div class="col">
                    <ul class="pagination flex-wrap justify-content-md-end mb-0">
                        {{$totalReports->links()}}
                    </ul>
                </div>
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
                                <h3 class="mb-0 text-uppercase">IDR <span class="total-sum-check">{{$totalReportSum}}</span></h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection

@section('page_js')
    <script>
        document.getElementById('pagination').onchange = function () {
            window.location = "{{ $totalReports->url(1) }}&items=" + this.value;
        };

        $("input:checkbox").click(function () {
            var totalTradingProfit = {{$totalTradingProfit}};
            var totalUnilevels = {{$totalUnilevels}};
            var totalProfitSharing = {{$totalProfitSharing}};
            var totalLeadershipBonus = {{$totalLeadershipBonus}};
            var totalOwnershipBonus = {{$totalOwnershipBonus}};

            if ($('input:checkbox:checked').length == 0) {
                var str;
                str = `<div class="alert alert-fill-danger" role="alert">
<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <i class="ti-info-alt"></i>
                Please select at least one report.
                </div>`;
                $('#checkbox-warning').html(str);

                return false;
            }
            var total_amount = 0;
            var ampunt = [];
            $('input[type=checkbox]:checked').each(function () {
                var name = $(this).attr("name");
                // alert(name);
                if( name == 'leadership_bonus' ){
                    total_amount +=  totalLeadershipBonus;
                    ampunt.push(totalLeadershipBonus);
                }
                if( name == 'trading_profit' ){
                    total_amount +=  totalTradingProfit;
                    ampunt.push(totalTradingProfit);
                }
                if( name == 'unilevel' ){
                    total_amount +=  totalUnilevels;
                    ampunt.push(totalUnilevels);
                }
                if( name == 'profit_sharing' ){
                    total_amount +=  totalProfitSharing;
                    ampunt.push(totalProfitSharing);
                }
                if( name == 'ownership_bonus' ){
                    total_amount +=  totalOwnershipBonus;
                    ampunt.push(totalOwnershipBonus);
                }
                
            });
            $('.total-sum-check').html(total_amount);
            var column = "." + $(this).attr("name");
            $(column).toggle();
        });

        $('input:checkbox').change(function () {
            var totalrecords = $('#totalrecords').val();
            for (var i = 0; i <= totalrecords; i++) {
                var total = 0;
                $('input:checkbox:checked').each(function () {
                    var id = $(this).data('id');
                    total += parseInt($('#' + id + '-' + i).text());
                });
                $("#total-" + i).text(total);
            }
        });

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

	    $('.ti-calendar').click(function () {
                $('input[name="date-range-my"]').focus();
            });

            $('input[name="date-range-my"]').on('apply.daterangepicker', function (ev, picker) {
                $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
            });

        });
    </script>
@endsection

