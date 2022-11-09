@extends('layouts.app')
@section('title', 'Unilevel Profit')
<style>
    .error {
        color: red;
    }

    Account Details
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
    @media (max-width: 767px) and (min-width: 320px){
        #search_username{
        margin-top: 10px !important;
    }}
    
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
        <a class="mb-3 mb-xl-0 btn btn-primary btn-rounded" href="{{route('unilevel')}}">@lang('sidebar.unilevel')</a>
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
        <h2 class="hrowheading">@lang('sidebar.unilevel')</h2>
    </header>
    <div class="card">
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
                <form method="post" action="{{route('unilevel')}}">
                    @csrf
                    <div class="mr-auto row">
                        <div id="" class="input-group col-sm-8 unilevel-inputs">
                            <input type="text" name="date-range-my" placeholder="@lang('general.search_date')"
                                   value="{{$searchedDate}}"
                                   class="form-control readonly-text" readonly>
                            <input type="hidden" name="start_date" id="startdate" class="form-control">
                            <input type="hidden" name="end_date" id="enddate" class="form-control">
                            <button type="submit" name="submit"
                                    class="btn-outline-twitter input-group-text btn-search"
                                    id="">@lang('general.search')
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
                        <th>@lang('general.total') @lang('general.amount')</th>
                        <th>@lang('general.date')</th>
                        <th>@lang('general.breakdown')</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if($unilevels)
			             @php $x = $unilevels->firstItem() @endphp
                        @foreach($unilevels as $i => $unilevel)
                            <tr>
                                <td>{{$x++}}</td>
                                <td>{{$unilevel->profit}}</td>
                                <td id="breakdown_date">{{$unilevel->created_at->format('m/d/Y')}}</td>
                                <td><a href="#" class="view_breakdown" data-date="{{$unilevel->created_at}}">
                                        @lang('general.view') @lang('general.breakdown')</a></td>
                                @endforeach
                            </tr>
                            @else
                                @lang('general.no_record')
                            @endif
                    </tbody>
                </table>
            </div>
            <div class="d-block d-md-flex row justify-content-between mt-4 align-items-center">
                @if($unilevels->total() > 0)
                    <div class="col grid-margin grid-margin-md-0">@lang('general.showing') {{ $unilevels->firstItem() }}
                        to {{ $unilevels->lastItem() }} of {{ $unilevels->total() }} @lang('general.entries')
                    </div>
                @else
                    <div class="col-12 d-block text-center">
                        No records found
                    </div>
                @endif
                <div class="col">
                    <ul class="pagination flex-wrap justify-content-md-end mb-0">
                        {{$unilevels->links()}}
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="view_breakdown" tabindex="-1" aria-labelledby="myModalLabel" role="dialog"
         aria-labelledby="myModalLabel" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <a href="javascript:;" class="d-block text-right text-uppercase text-white text-small mr-4 mt-3"
                   data-dismiss="modal" aria-label="Close">@lang('general.close')</a>

                <div class="modal-body">
                    <div class="row ml-auto">
                        <input type="text" placeholder="@lang('general.search_username')" id="username" name="username"
                               class="form-control col-md-4">
                        <input type="hidden" id="hidden-date" class="form-control">
                        <button type="submit" name="submit"
                                class="btn-outline-twitter input-group-text mx-1"
                                id="search_username">@lang('general.search')
                        </button>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>@lang('general.commission')</th>
                                <th>@lang('general.percentage')</th>
                                <th>@lang('general.from_user')</th>
                                <th>@lang('general.amount')</th>
                                <th>@lang('general.date')</th>
                            </tr>
                            </thead>
                            <tbody id="breakdown_table">
                            </tbody>
                        </table>
                    </div>
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
                                <h3 class="mb-0 text-uppercase">IDR {{$totalUnilevels ? $totalUnilevels : '0'}}</h3>
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
            window.location = "{{ $unilevels->url(1) }}&items=" + this.value;
        };

        $('.view_breakdown').on('click', function () {
            var breakdown_date = $(this).data('date');
            $.ajax({
                url: '{{ route('get-unilevel-breakdown') }}',
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
                url: '{{route('search-breakdown-by-username')}}',
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
                            $('#breakdown_table').html(`<div class='text-white'>@lang('general.no_record').</div>`);
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
