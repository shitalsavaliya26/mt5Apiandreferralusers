@extends('layouts.app')
@section('title', 'Topup')

@section('content')
    <style>
    #security_error, .error {
        color: red;
    }
    .form-control{
        background-color: #2b2e4c;
    }
    </style>
    <div class="d-block mt-30"></div>
    <div class="text-white text-center w-100 medimagebgdiv" style="background-image: url(./images/funding.png)">
        <h3 class="m-0 boldbultertext">@lang('funding.funding')</h3>
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
                                    IDR {{ $UserWallet ? $UserWallet->topup_fund : '0' }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="hrlinelight mt-4 mb-4"></div>

            @lang('funding.description')</p>
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
            <form class="forms-sample" style="font-size: small;" method="post" id="topUpForm"
                  action="{{route('topup_funds.store')}}" enctype="multipart/form-data">
                @csrf
                <h3 class="medbultertext text-white mb-4">@lang('funding.topup_fund')</h3>
                <div class="form-group row ">
                    <label for="exampleInput2" class="col-sm-5 medbultertext text-white mb-0 align-self-center">
                        @lang('funding.top_amount'):</label>
                    <div class="col-sm-7">
                        <input type="text" class="form-control form-control-sm" id="exampleInput1" name="amount"
                               placeholder="">
                    </div>
                </div>

                <div class="bluebox p-3 mb-4" style="font-size: small;">
                    <div class="row">
                        <div class="col">
                            <div class="row">
                                <div class="mx-2"><span class="medbultertext text-white">Account Name:</span></div>
                                <div class="mx-2"><span
                                            class="regbultertext text-muted">{{$userBank->account_holder}}</span></div>
                            </div>
                            <div class="row mt-2">
                                <div class="mx-2"><span class="medbultertext text-white">Bank Name:</span></div>
                                <div class="mx-2"><span class="regbultertext text-muted">{{$userBank->name}}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="row">
                                <div class="mx-2"><span class="medbultertext text-white">Account Number:</span></div>
                                <div class="mx-2"><span
                                            class="regbultertext text-muted">{{$userBank->account_number}}</span></div>
                            </div>
                            <div class="row mt-2">
                                <div class="mx-2"><span class="medbultertext text-white">Account Opening:</span></div>
                                <div class="mx-2"><span
                                            class="regbultertext text-muted">{{$userBank->account_holder}}</span></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="dropzone mb-4" id="my-awesome-dropzone"></div>

                <div class="bluebox p-3 mb-4">
                    <div class="row">
                        <div class="col">
                            <div class="row">
                                <div class="mx-2"><span class="medbultertext text-white">Account Name:</span></div>
                                <div class="mx-2"><span
                                            class="regbultertext text-muted">{{$paymentSetting->account_name}}</span>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="mx-2"><span class="medbultertext text-white">Bank Name:</span></div>
                                <div class="mx-2"><span
                                            class="regbultertext text-muted">{{$paymentSetting->bank_name}}</span></div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="row">
                                <div class="mx-2"><span class="medbultertext text-white">Account Number:</span></div>
                                <div class="mx-2"><span
                                            class="regbultertext text-muted">{{$paymentSetting->account_number}}</span>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="mx-2"><span class="medbultertext text-white">Account Opening:</span></div>
                                <div class="mx-2"><span
                                            class="regbultertext text-muted">{{$paymentSetting->account_opening}}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <input type="hidden" value="" name="reciept_topup" id="reciept_topup">
                <div class="dropzone mb-4" id="my-awesome-dropzone2"></div>
                <input type="hidden" value="" name="reciept_process" id="reciept_process" readonly="">

                <div class="form-group row ">
                    <label for="exampleInput2" class="col-sm-5 medbultertext text-white mb-0 align-self-center">
                        @lang('funding.processing_fees') %:</label>
                    <div class="col-sm-7">
                        <input type="text" class="form-control form-control-sm processing_percentage" style="pointer-events: none;"
                               id="exampleInput3" name="processing" placeholder=""
                               value="">
                    </div>
                </div>
                <div class="form-group row ">
                    <label for="exampleInput2" class="col-sm-5 medbultertext text-white mb-0 align-self-center">
                        @lang('funding.processing_fees_amount'):</label>
                    <div class="col-sm-7">
                        <input type="text" class="form-control form-control-sm" style="pointer-events: none;"
                               id="exampleInput2" name="processing_fees" placeholder=""
                               value="">
                    </div>
                </div>

                <div class="form-group row ">
                    
                    <label for="exampleInput2" class="col-sm-5 medbultertext text-white mb-0 align-self-center">
                        @lang('general.security_password'):</label>
                    <div class="col-sm-7">
                        <input type="password" class="form-control form-control-sm" id="security_password"
                               placeholder="Enter security password" name="security_password">
                        <label id="security_error"></label>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-md-12">
                        <button type="submit" id="submit-all"
                                class="w-100 btn btn-primary text-uppercase">@lang('general.submit')
                        </button>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-12 col-xl-3 mt-5 mt-xl-0">

            <h4 class="medbultertext text-white mb-4">@lang('funding.term_condition')</h4>
            {!! trans('funding.term_condition_content') !!}
        </div>
    </div>

    <div class="hrlinelight mt-4 mb-5"></div>

    <header class="section-title titlebottomline">
        <h2 class="hrowheading" style="font-size: 18pt">@lang('funding.history')</h2>
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

                <form method="post" action="{{route('getTopupFunds')}}">
                    @csrf
                    <div class="row">
                        <div id="" class="input-group col-sm-6">
                            <input type="text" name="date-range-my" placeholder="@lang('general.search_date')"
                                   id="date-range"
                                   value="{{$searchedDate}}" class="form-control readonly-text" readonly>
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
                        <div class="input-group col-sm-3">
			                 <button type="submit" name="date-range" class="form-control btn-reset">@lang('general.reset')</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="d-block mt-30 d-md-none"><i class="fa fa-hand-o-right"></i> Scroll right to see data in table.
            </div>
            <div class="table-responsive" id="topup_data">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th><i class="active"></i> No.</th>
                        <th><i class="active"></i>@lang('general.amount')</th>
                        <th><i class="active"></i>@lang('funding.processing_fees')</th>
                        <th><i class="active"></i>@lang('funding.processing_percentage')</th>
                        <th><i class="active"></i>@lang('general.date')</th>
                        <th><i class="active"></i>@lang('general.status')</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        @if($topupFunds)
				            @php $x = $topupFunds->firstItem() @endphp
                            @foreach($topupFunds as $i => $topup)
                                <td>{{$x++}}</td>
                                <td>{{$topup->amount}}</td>
                                <td>{{$topup->processing_fees}}</td>
                                <td>{{($topup->processing_percentage) ? $topup->processing_percentage : '0'}}</td>
                                <td>{{$topup->created_at->format('m/d/Y')}}</td>
                                @if($topup->status == 1)
                                    <td><label class="badge badge-success">@lang('general.approved')</label></td>
                                @elseif($topup->status == 2)
                                    <td><label class="badge badge-danger">@lang('general.rejected')</label></td>
                                @else
                                    <td><label class="badge badge-warning">@lang('general.pending')</label></td>
                                @endif
                                <td>
                                    <a href="#" data-reciept_topup="{{asset('topup_reciepts/'.$topup->reciept_topup)}}" data-reciept_process="{{asset('process_reciepts/'.$topup->reciept_process)}}"  class="badge badge-outline-primary px-3 pop">@lang('general.view')</a>

                                    @if($topup->remarks)
                                    <a href="#" data-remarks="{{nl2br($topup->remarks)}}" class="badge badge-outline-primary view-remarks">@lang('withdraw.remark')</a>
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

            <div class="modal fade" id="imagemodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-body">
                            <button type="button" class="close" data-dismiss="modal">
                                <span aria-hidden="true">&times;</span>
                                <span class="sr-only">@lang('general.close')</span>
                            </button>
                            <div class="row">
                                <div class="col-sm-6 text-center">
                                    <p class="mb-2">Topup Receipt</p>
                                    <img src="" class="imagepreview img-fluid" style="width: 250px;height:auto;">
                                    <a href="" class="dowload-icon" download><i class="fa fa-file-pdf-o fa-4x mt-3"></i></a>
                                </div>
                                <div class="col-sm-6 text-center">
                                    <p class="mb-2">Process Receipt </p>
                                    <img src="" class="imagepreview1 img-fluid" style="width: 250px;height:auto">
                                    <a href="" class="dowload-icon1" download><i class="fa fa-file-pdf-o fa-4x mt-3"></i></a>
                                </div>
                            </div>
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

            <div class="d-block d-md-flex row justify-content-between mt-4 align-items-center">
                
                @if($topupFunds->total() > 0)
                    <div class="col grid-margin grid-margin-md-0">@lang('general.showing') {{ $topupFunds->firstItem() }}
                        to {{ $topupFunds->lastItem() }} of {{ $topupFunds->total() }} @lang('general.entries')
                    </div>
                @else
                    <div class="col-12 d-block text-center">
                        No records found
                    </div>
                @endif
                {{$topupFunds->links()}}
            </div>
        </div>
    </div>
@endsection

@section('page_js')
    <script src="{{asset('/js/jquery-1.7.1.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('/js/jquery.validate.min.js')}}"></script>
    <script>
        var processing_fees = '{{$setting->topup_process_fees}}';
        document.getElementById('pagination').onchange = function () {
            window.location = "{{ $topupFunds->url(1) }}&items=" + this.value;
        };
        $('#exampleInput1').on('keyup',function(){
            var newStr = $(this).val().replace(/,/g, "")
            var amount = parseFloat(newStr);
            console.log(amount);
            if(amount <= 75000){
                processing_fees = 5;
            }
            if(amount > 75000 && amount < 150000){
                console.log(amount)
                processing_fees = 5;
            } 
            if (amount >= 150000 && amount < 750000){
                processing_fees = 4;
            } 
            if (amount >= 750000 && amount < 1500000){
                processing_fees = 3;
            } 
            // if (amount >= 1500000 && amount < 15000000){
            //     processing_fees = 3;
            // } 
            if (amount >= 1500000){ // && amount <= 15000000
                processing_fees = 2;
            }

            // if(amount > 75000 && amount <= 150000000){
            //     console.log(amount)
            //     processing_fees = 5;
            // } 
            // if (amount > 150000000 && amount <= 750000000){
            //     processing_fees = 4;
            // } 
            // if (amount > 750000000 && amount <= 1500000000){
            //     processing_fees = 3;
            // } 
            // if (amount > 1500000000 && amount <= 15000000000){
            //     processing_fees = 2;
            // }

            amount = amount * (parseFloat(processing_fees)/100);

            $("input[name='processing']").val(processing_fees);
            $("input[name='processing_fees']").val(parseFloat(amount).toFixedSpecial(2));

        })
Number.prototype.toFixedSpecial = function(n) {
  var str = this.toFixed(n);
  if (str.indexOf('e+') === -1)
    return str;

  // if number is in scientific notation, pick (b)ase and (p)ower
  str = str.replace('.', '').split('e+').reduce(function(p, b) {
    return p + Array(b - p.length + 2).join(0);
  });
  
  if (n > 0)
    str += '.' + Array(n + 1).join(0);
  
  return str;
};
        $('.view-remarks').on('click', function () {

            var remarks = $(this).data('remarks');
            $('#view_remarks').html(remarks);
            // $('#view_remarks').html(remarks.replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1<br>$2'));
            $('#view-remarks').modal('show');

        });

        $('#topUpForm').validate({
            // initialize the plugin
            rules: {
                amount: {
                    required: true
                },
                reciept_topup: {
                    required: true
                },
                security_password: {
                    required: true
                },
            }
            ,
            submitHandler: function (form) {
                $.ajax({
                    url: '{{ route('check-secure-password') }}',
                    data: {
                        security_password: $("#security_password").val(),
                    },
                    dataType: 'json',
                    success: function (data) {
                        if (data.status == 'error') {
                            $('#security_error').text('Security password did not matched');
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
        $('.pop').on('click', function () {
            image1 = $(this).data('reciept_topup');
            image2 = $(this).data('reciept_process');
            var ext = image1.split('.');
            console.log("Image 1",ext);

            if(ext[ext.length - 1] == 'pdf' || ext[ext.length - 1] == "doc" || ext[ext.length - 1]=='ext'){
                $('.imagepreview').hide();
                $('.dowload-icon').show();
                $('.dowload-icon1').attr('href',image1);
            }else{
                $('.dowload-icon').hide();
                $('.imagepreview').show();
                $('.imagepreview').attr('src', image1);
            }
            var ext = image2.split('.');
            console.log("Image 2",ext);
            if(ext[ext.length - 1] == 'pdf' || ext[ext.length - 1] == "doc" || ext[ext.length - 1]=='ext'){
                $('.imagepreview1').hide();
                $('.dowload-icon1').show();
                $('.dowload-icon1').attr('href',image2);
            }else{
                $('.dowload-icon1').hide();
                $('.imagepreview1').show();
                $('.imagepreview1').attr('src', image2);
            }

            $('.imagepreview1').attr('src', image2);

            $('#imagemodal').modal('show');
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





