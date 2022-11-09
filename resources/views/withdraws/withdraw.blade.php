@extends('layouts.app')
@section('title', 'Withdraw')
<style>
    #security_error, .error {
        color: red;
    }
</style>
@section('content')
    <div class="d-block mt-30"></div>

    <div class="text-white text-center w-100 medimagebgdiv" style="background-image: url(./images/earnings.png)">
        <h3 class="m-0 boldbultertext">@lang('withdraw.earnings')</h3>
    </div>
    <div class="d-block mt-5"></div>
    <div class="row">
        <div class="col-12 col-xl-4">
            <div class="stretch-card">
                <div class="card cardhoverable active">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <i class="fa fa-money icon-5rem"></i>
                            </div>
                            <div class="col">
                                <p class="card-title mb-2">@lang('general.acc_balance')</p>
                                <h3 class="mb-0 text-uppercase">
                                    {{-- IDR {{$user->total_capital ? $user->total_capital : '0'}} --}}
                                    IDR {{ isset($UserWallet) ? $UserWallet->withdrawal : '0' }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="hrlinelight mt-4 mb-4"></div>
        </div>
        <div class="col-12 col-xl-5 mt-4 mt-xl-0">
            @if(session()->has('message'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session()->get('message') }}
                </div>
            @endif
            @if(session()->has('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session()->get('error') }}
                </div>
            @endif
            @if(count($errors) > 0 )
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <ul class="p-0 m-0" style="list-style: none;">
                        @foreach($errors->all() as $error)
                            {{$error}}<br/><br/>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form class="forms-sample" class="desk-f-x-small" method="post" id="withdrawForm"
                  action="{{route('withdraw-request.store')}}" autocomplete="off">
                @csrf
                <h3 class="medbultertext text-white mb-4">@lang('withdraw.withdraw')</h3>
                <div class="bluebox p-3 mb-4">
                    <div class="row">
                        <div class="col">
                            <div class="row">
                                <div class="mx-2"><span class="medbultertext text-white">Account Name:</span></div>
                                <div class="mx-2"><span
                                        class="regbultertext text-muted">{{$paymentSetting->second_account_name}}</span></div>
                            </div>
                            <div class="row mt-2">
                                <div class="mx-2"><span class="medbultertext text-white">Bank Name:</span></div>
                                <div class="mx-2"><span
                                        class="regbultertext text-muted">{{$paymentSetting->second_bank_name}}</span></div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="row">
                                <div class="mx-2"><span class="medbultertext text-white">Account Number:</span></div>
                                <div class="mx-2"><span
                                        class="regbultertext text-muted">{{$paymentSetting->second_account_number}}</span>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="mx-2"><span class="medbultertext text-white">Account Opening:</span></div>
                                <div class="mx-2"><span
                                        class="regbultertext text-muted">{{$paymentSetting->second_account_opening}}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="exampleInput" class="col-sm-4 medbultertext text-white mb-0 align-self-center"
                           style="font-size: 12px;">@lang('withdraw.withdraw_amount'):</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control form-control-sm" id="exampleInput" name="amount"
                               placeholder="@lang('withdraw.place_holder_withdrawal')">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="exampleInput3" class="col-sm-4 medbultertext text-white mb-0 align-self-center"
                           style="font-size: small;">@lang('general.security_password'):</label>
                    <div class="col-sm-8">
                        <input type="password" class="form-control form-control-sm" id="security_password"
                               placeholder="@lang('withdraw.place_holder_secure_password')" name="security_password">
                        <label id="security_error"></label>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-md-12">
                        <button type="submit" id="submit-all" class="w-100 btn btn-primary text-uppercase">@lang('general.submit')
                        </button>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-12 col-xl-3 mt-5 mt-xl-0">
            <h4 class="medbultertext text-white mb-4">@lang('withdraw.term_condition')</h4>

            {!! trans('withdraw.term_and_condition') !!}
        </div>
    </div>

    <div class="hrlinelight mt-4 mb-5"></div>

    <header class="section-title titlebottomline">
        <h2 class="hrowheading" style="font-size: 18pt">@lang('withdraw.history')</h2>
    </header>
    <div class="card">
        <div class="card-body">
            <div class="d-block d-md-flex row justify-content-between mb-3">
                <div class="col grid-margin grid-margin-md-0">
                    <div class="d-flex flex-wrap align-items-center">
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
                </div>
                <form method="post" action="{{route('withdraw-request-form')}}">
                    @csrf
                    <div class="row">
                        <div id="" class="input-group col-sm-6">
                                <input type="text" name="date-range-my" placeholder="@lang('general.search_date')" value="{{$searchedDate}}"
                                       class="form-control readonly-text" readonly>
                                <input type="hidden" name="start_date" id="startdate" class="form-control">
                                <input type="hidden" name="end_date" id="enddate" class="form-control">
                                <span class="input-group-addon input-group-append border-left">
                                    <i  class="ti-calendar input-group-text"></i>
                                    <!-- <button type="text" name="date-range" class="ti-calendar input-group-text" disabled="disabled"></button> -->
                                </span>
                        </div>
                        <div class="input-group col-sm-3">
                            <button type="submit" name="date-range" class="form-control">Search</button>
                        </div>
                        <div id="" class="input-group col-sm-3">
                            <button type="submit" name="date-range" class="form-control btn-reset">@lang('general.reset')</button>
                        </div>
                    </div>
                </form>

                <div class="d-block mt-30 d-md-none"><i class="fa fa-hand-o-right"></i> Scroll right to see data in
                    table.
                </div>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th><i class="active"></i> No.</th>
                            <th><i class="active"></i>@lang('general.amount')</th>
                            <th><i class="active"></i>@lang('general.withdrawal_fees')</th>
                            <th><i class="active"></i>@lang('general.date')</th>
                            <th><i class="active"></i>@lang('general.status')</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            @if($withdraws)
				@php $x = $withdraws->firstItem() @endphp
                                @foreach($withdraws as $i => $withdraw)
                                    <td>{{$x++}}</td>
                                    
                                    <!-- <td>{{$withdraw->status == 0 ? $withdraw->amount - $withdraw->withdrawal_fees :( $withdraw->status == 2 ? $withdraw->amount + $withdraw->withdrawal_fees  : $withdraw->amount) }}</td> -->
                                    <td>{{$withdraw->amount}}</td>
                                    <td>{{$withdraw->withdrawal_fees && $withdraw->status!=2 ? $withdraw->withdrawal_fees : '-'}}</td>
                                    <td>{{$withdraw->created_at->format('m/d/Y')}}</td>
                                    <td>
                                        @if($withdraw->status == 1)
                                            <label class="badge badge-success">@lang('general.approved')</label>
                                        @elseif($withdraw->status == 2)
                                            <label class="badge badge-danger">@lang('general.rejected')</label>
                                        @else
                                            <label class="badge badge-warning">@lang('general.pending')</label>
                                        @endif
                                    </td>
                                    <td>
                                        @if($withdraw->remarks)
                                        <a href="javascript:void(0)" data-remarks="{{nl2br($withdraw->remarks)}}" class="badge badge-outline-primary view-remarks">@lang('withdraw.remark')</a>
                                        @endif

                                    </td>
                        </tr>
                        @endforeach
                        @else
                            No History available
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="d-block d-md-flex row justify-content-between mt-4 align-items-center">
                
                @if($withdraws->total() > 0)
                    <div class="col grid-margin grid-margin-md-0">@lang('general.showing') {{ $withdraws->firstItem() }}
                        to {{ $withdraws->lastItem() }} of {{ $withdraws->total() }} @lang('general.entries')
                    </div>
                @else
                    <div class="col-12 d-block text-center">
                        No records found
                    </div>
                @endif
                
                <div class="col">
                    <ul class="pagination flex-wrap justify-content-md-end mb-0">
                        {{$withdraws->links()}}
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="view-remarks" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title inline" id="exampleModalLabel">@lang('withdraw.remark')</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body" style=" overflow-x:auto;">
                            <div class="text-left" id="view_remarks">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
@endsection

@section('page_js')
    <script src="{{asset('/js/jquery-1.7.1.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('/js/jquery.validate.min.js')}}"></script>
    <script>
        document.getElementById('pagination').onchange = function () {
            window.location = "{{ $withdraws->url(1) }}&items=" + this.value;
        };

        $('.view-remarks').on('click', function () {
            var remarks = $(this).data('remarks');
            $('#view_remarks').html(remarks);
            $('#view-remarks').modal('show');
        });

        $('#withdrawForm').validate({
            // initialize the plugin
            rules: {
                amount: {
                    required: true,
                    min:parseFloat("{{isset($setting[0])?$setting[0]->minimum_withdraw_amount:$setting->minimum_withdraw_amount}}")
                },
                security_password: {
                    required: true
                },
            },
            submitHandler: function (form) {
                $.ajax({
                    url: '{{ route('check-secure-password') }}',
                    data: {
                        security_password: $("#security_password").val(),
                    },
                    dataType: 'json',
                    success: function (data) {
                        if (data.status == 'error') {
                            $('#security_error').text('password did not matched')
                        } else {
                            form.submit();
                        }
                    },

                    errors: function () {
                        alert('something went wrong');
                    }
                });
            }
        });
    </script>
    <script type="text/javascript">
        jQuery.noConflict();
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