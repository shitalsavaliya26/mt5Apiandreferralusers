@extends('layouts.app')
@section('title', 'Ownership Bonus')
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
    <nav class="nav flex-column flex-sm-row justify-content-sm-center reportbuttons" style="flex-wrap:unset;">
        <a class="mb-3 mb-xl-0 btn btn-light btn-rounded" href="{{route('trading-profit')}}">@lang('sidebar.trading_profit')</a>
        <a class="mb-3 mb-xl-0 btn btn-light btn-rounded" href="{{route('unilevel')}}">@lang('sidebar.unilevel')</a>
        <a class="mb-3 mb-xl-0 btn btn-light btn-rounded" href="{{route('profit-sharing')}}">@lang('sidebar.profit_sharing')</a>
        <a class="mb-3 mb-xl-0 btn btn-light btn-rounded" href="{{route('leadership-bonus')}}">@lang('sidebar.leadership_bonus')</a>
        <a class="mb-3 mb-xl-0 btn btn-primary btn-rounded" href="{{route('ownership-bonus')}}">@lang('sidebar.ownership_bonus')</a>
        <a class="mb-3 mb-xl-0 btn btn-my-gradient btn-rounded text-uppercase font-weight-bolder"
           href="{{route('total-report')}}">@lang('sidebar.total')</a>
    </nav>

    <div class="hrlinelight mt-4 mt-xl-5 mb-5"></div>

    <header class="section-title titlebottomline">
        <h2 class="hrowheading">@lang('sidebar.ownership_bonus')</h2>
    </header>
    <div class="card ownership-bonus">
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
                    <form method="post" action="{{route('ownership-bonus')}}">
                        @csrf
                        <div class="mr-auto row">
                            <div id="" class="input-group col-sm-8 unilevel-inputs">
                                <input type="text" name="date-range-my readonly-text" readonly placeholder="@lang('general.search_date')"
                                       value="{{$searchedDate}}"
                                       class="form-control">
                                <input type="hidden" name="start_date" id="startdate" class="form-control">
                                <input type="hidden" name="end_date" id="enddate" class="form-control">
                                <span class="input-group-addon input-group-append border-left"></span>
                                <button type="submit" name="submit"
                                        class="btn-outline-twitter input-group-text btn-search" id="">@lang('general.search')
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
                        <th>@lang('general.amount')</th>
                        <th>@lang('general.commission')</th>
                        <th>@lang('general.percentage')</th>
                        <th>@lang('general.date')</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if($ownershipBonus)
				@php $x = $ownershipBonus->firstItem() @endphp
                        @foreach($ownershipBonus as $i => $bonus)
                            <tr>
                                <td>{{$x++}}</td>
                                <td>{{$bonus->profit}}</td>
                                <td>{{$bonus->commission}}</td>
                                <td>{{$bonus->percent}}</td>
                                <td id="breakdown_date">{{$bonus->created_at->format('m/d/Y')}}</td>
                                @endforeach
                            </tr>
                            @else
                                @lang('general.no_record')
                            @endif
                    </tbody>
                </table>
            </div>
            <div class="d-block d-md-flex row justify-content-between mt-4 align-items-center">
                
                @if($ownershipBonus->total() > 0)
                    <div class="col grid-margin grid-margin-md-0">@lang('general.showing') {{ $ownershipBonus->firstItem() }}
                        to {{ $ownershipBonus->lastItem() }} of {{ $ownershipBonus->total() }} @lang('general.entries')
                    </div>
                @else
                    <div class="col-12 d-block text-center">
                        No records found
                    </div>
                @endif
                <div class="col">
                    <ul class="pagination flex-wrap justify-content-md-end mb-0">
                        {{$ownershipBonus->links()}}
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
                                <h3 class="mb-0 text-uppercase">IDR {{$totalOwnershipBonus ? $totalOwnershipBonus : '0'}}</h3>
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
            window.location = "{{ $ownershipBonus->url(1) }}&items=" + this.value;
        };

        $('.view_breakdown').on('click', function () {
            var breakdown_date = $(this).data('date');
            $.ajax({
                url: '{{ route('get-ownership-bonus-breakdown') }}',
                data: {
                    date: breakdown_date
                },
                dataType: 'json',
                success: function (response) {
                    if (response.success == true) {
                        if (response.data.length > 0) {
                            var str = "<tr>";
                            for (var i = response.data.length - 1; i >= 0; i--) {
                                var date = moment(response.data[i].created_at).format('DD/MM/YYYY');
                                str += `<td>${response.data[i].commission}</td>`
                                    + `<td>${response.data[i].percentage}</td>`
                                    + `<td>${response.data[i].from_user.user_name}</td>`
                                    + `<td>${response.data[i].amount}</td>`
                                    + `<td>${date}</td>`
                                str += `</tr>`;
                                $('#hidden-date').val(response.data[i].created_at);
                            }
                            $('#breakdown_table').html(str);
                            $('#view_breakdown').modal('show');
                        }

                    }
                },
            });
        });

        $("#search_username").click(function () {
            var breakdown_date = $(this).data('date');
            $.ajax({
                type: 'GET',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '{{route('search-ownership-bonus-breakdown')}}',
                data: {
                    user_name: $("#username").val(),
                    date: $("#hidden-date").val()
                },
                success: function (response) {
                    if (response.success == true) {
                        if (response.data.length > 0) {
                            var str = "<tr>";
                            for (var i = response.data.length - 1; i >= 0; i--) {
                                var date = moment(response.data[i].created_at).format('DD/MM/YYYY');
                                str += `<td>${response.data[i].commission}</td>`
                                    + `<td>${response.data[i].percentage}</td>`
                                    + `<td>${response.data[i].from_user.user_name}</td>`
                                    + `<td>${response.data[i].amount}</td>`
                                    + `<td>${date}</td>`
                                str += `</tr>`;
                            }
                            $('#breakdown_table').html(str);
                        } else {
                            $('#breakdown_table').html(`<div class='text-white'>No record found</div>`);
                        }

                    }
                },
                error: function (result) {

                }
            });
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

            $('input[name="date-range-my"]').on('apply.daterangepicker', function (ev, picker) {
                $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
            });

        });
    </script>
@endsection
