@extends('layouts.admin_app')
@section('title', 'Payout Report')
@section('content')
    <div class="main-panel payout-report">
        <div class="content-wrapper">
            <h4 class="font-weight-bold">Payout Report</h4>
            <br/>
            <div class="row ml-auto">
                <div class="col-md-12">
                    <form method="post" action="{{route('payout-report')}}">
                        @csrf
                        <div class="ml-2">
                            <div id="" class="input-group">
                                <div class="row col-lg-9 col-md-12 ml-auto search-field p-0">
                                    <div class="col-md-4 search-inpt">
                                        <input type="text" name="user_name"
                                               placeholder="@lang('general.search_username')"
                                               id="search_username" class="form-control" value="{{$searchedUserName}}">
                                    </div>
                                    <div class="col-md-4 search-inpt">
                                        <input type="text" name="date-range-my" placeholder="Select Date"
                                               value="{{$searchedDate}}" class="form-control">
                                        <input type="hidden" name="start_date" id="startdate" class="form-control">
                                        <input type="hidden" name="end_date" id="enddate" class="form-control">
                                        <span class="input-group-addon input-group-append border-left"></span>
                                    </div>
                                    <div class="row col-md-4 search-action">
                                        <button type="submit" name="submit"
                                                class=" btn-outline-twitter input-group-text">
                                            Search
                                        </button>
                                        &nbsp;
                                        <!-- <button type="reset" name="submit"
                                                class="btn-outline-twitter input-group-text">
                                            Reset
                                        </button> -->
                                        <a href="{{route('payout-report')}}" class="btn-outline-twitter input-group-text" style="color:#2caae1;text-decoration:none;" onMouseOver="this.style.color='#ffffff'" onMouseOut="this.style.color='#2caae1'">
                                            Reset
                                        </a>
                                    </div>
                                </div>
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

            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="table-responsive">
                                <table id="order-listing" class="table text-black">
                                    <thead>
                                    <!------------------------changes-->
                                    <tr class="text-black">
                                        <th>No.</th>
                                        <th>Username</th>
                                        <th>Full Name</th>
                                        <th>MT5 ID</th>
                                        <th>Breakdown</th>
                                        <th>Last Payout Date</th>
                                    </tr>
                                    </thead>
                                    @if($payouts)
                                        <tbody>
                                        {{--@foreach($payouts->unique('user_id') as $i => $pay)--}}
                                        @php $x = $payouts->firstItem() @endphp
					@foreach($payouts as $i => $pay)
                                            <tr>
                                                <td>{{$x++}}</td>
                                                <td>{{$pay->users['user_name']}}</td>
                                                <td>{{$pay->users['full_name']}}</td>
                                                <td>{{$pay->users['mt4_username']}}</td>
                                                <td><a href="#" class="view_breakdown"
                                                       data-user_id="{{$pay->user_id}}">@lang('general.view')
                                                        @lang('general.breakdown')</a></td>
                                                <td>{{$pay->created_at->format('m/d/Y')}}</td>
                                            </tr>
                                        @endforeach
                                        @else
                                            No Report found
                                        @endif
                                        </tbody>
                                </table>
                            </div>
                            <div class="d-block d-md-flex row justify-content-between mt-4 align-items-center">
                                
                                @if($payouts->total() > 0)
                                    <div class="col grid-margin grid-margin-md-0">Showing {{ $payouts->firstItem() }}
                                        to {{ $payouts->lastItem() }} of {{ $payouts->total() }} entries
                                    </div>
                                @else
                                    <div style="padding-left: 450px;">
                                        No records found
                                    </div>
                                @endif
                                <div class="col">
                                    <ul class="pagination flex-wrap justify-content-md-end mb-0">
                                        {{$payouts->links()}}
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="view_breakdown" tabindex="-1" aria-labelledby="myModalLabel"
                         role="dialog"
                         aria-labelledby="myModalLabel" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <a href="javascript:;"
                                   class="d-block text-right text-uppercase text-white text-small mr-4 mt-3"
                                   data-dismiss="modal" aria-label="Close">@lang('general.close')</a>
                                <div class="modal-body">
                                    <div class="table-responsive">
                                        <table class="table text-white">
                                            <thead>
                                            <tr>
                                                <th>Trading Profit</th>
                                                <th>Unilevel</th>
                                                <th>Leadership Bonus</th>
                                                <th>Profit Sharing</th>
                                                <th>Last payout date</th>
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
                </div>
            </div>
        </div>
        @endsection
        @section('page_js')
            <script type="text/javascript">
                $('.view_breakdown').on('click', function () {
                    var user_id = $(this).data('user_id');
                    $.ajax({
                        url: '{{ route('get-payout-breakdown') }}',
                        data: {
                            user_id: user_id
                        },
                        dataType: 'json',
                        success: function (response) {
                            console.log('response',response);
                            if (response.success == true) {
                                if (response.data.length > 0) {
                                    var str = "<tr>";
                                    for (var i = response.data.length - 1; i >= 0; i--) {
                                        var date = moment(response.data[i].created_at).format('MM/DD/YYYY');
                                        str += `<td>${response.data[i].trading_profit}</td>`
                                            + `<td>${response.data[i].unilevel}</td>`
                                            + `<td>${response.data[i].leadership_bonus}</td>`
                                            + `<td>${response.data[i].profit_sharing}</td>`
                                            + `<td>${date}</td>`
                                        str += `</tr>`;
                                    }
                                    $('#breakdown_table').html(str);
                                    $('#view_breakdown').modal('show');
                                }
                            }
                        },
                    });
                });
            </script>

            <script>
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
            </script>
@endsection
