@extends('layouts.app')
@section('title', 'Traders')
@section('content')
<style>
    .error {
        color: red;
    }

    .
    .btn-group > .btn {
        position: relative;

    }
    .show-txt,.show-input{
        cursor: pointer;
    }
    .btn-group .btn input {
        position: absolute;
        clip: rect(0, 0, 0, 0);

    }

    label.back.active {
        background: linear-gradient(180deg, rgba(176, 128, 44, 1), rgba(232, 205, 88, 1));
        border: none;
        color: #fff !important;
    }
</style>
@php 
$verify_days = 'Saturday';//date('l'); 
@endphp
<div class="d-block mt-30"></div>
<div class="text-white w-100 medimagebgdiv" style="background-image: url(./images/choose-trader.png)">
    <h3 class="m-0 boldbultertext pl-3 mob-regular">@lang('traders.traders')</h3>
    <h3 class="m-0 boldbultertext text-right pr-3 mob-regular"><strong  class="pl-5">@lang('traders.total_capital')</strong> <br> IDR {{auth()->user()->userwallet!=null?auth()->user()->userwallet->topup_fund:"0.00"}}</h3>
</div>
<p class="text-danger h6 mt-4"><strong>Note:</strong> Select and change traders only on Saturday or Sunday. Other days can't allowed  to choose request. </p>        
<div class="d-block mt-5"></div>
<div class="d-block mt-30" id="display_sucess">
    @if(session()->has('message'))
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        {{ session()->get('message') }}
    </div>
    @endif
</div>
<form method="post" action="" class="submit-traders">
    @csrf
    <div class="row tradersrow">
        @if(count($traders) > 0)
        
        @foreach($traders as $trader)
        <input type="hidden" name="trader_id[]" value="{{$trader->id}}">
        <div class="col-sm-6 col-md-6 col-lg-4 col-xl-3 mb-30px traders-equal-heights">
            @if(count($traderHistoriesIds) > 0)
            @if(in_array($trader->id, $traderHistoriesIds) && $trader->translation)

            <div class="card p-4 active" id="addactive_{{$trader->id}}">
                <div class="text-center">
                    <div class="traderBg" style="background: url({{asset('traders/besttrader')}}/{{$trader->best_trader_image}})">
                    </div>
                    <img src="{{asset('traders')}}/{{$trader->profile_picture}}" alt="profile"
                    class="img-lg rounded-circle mb-4 tradeBgImg">
                    <div class="mb-3">
                        <h3 class="medbultertext text-white m-0">{{($trader->translation['name'])? str_limit($trader->translation['name'],14) : str_limit($trader->name,14)}} </h3>
                    </div>
                    <div class="hrlinedark mb-3"></div>
                    <p class="mb-3 text-white">{{($trader->translation['subtitle'])? str_limit($trader->translation['subtitle'],14) : str_limit($trader->subtitle,14)}}
                    </p>
                    <div class="hrlinedark mb-3"></div>
                    <div class="invest-amont-graph">
                        <p class=" text-white invest-amount input-{{$trader->id}} d-none ">
                            <input type="number" autocomplete="off" step="0.01" maxlength="28" name="amount[{{$trader->id}}]" class="form-control-sm" value="{{@$amount[$trader->id]}}" required min="{{$trader->minimum_amount}}" @if($trader->maximum_amount && $trader->maximum_amount != '0') max="{{ $trader->maximum_amount }}" @endif/>
                            <i class="fa fa-close show-txt"  data-id="{{$trader->id}}"></i>
                        </p>
                        <p class="label-{{$trader->id}} mb-3">
                            IDR {{isset($amount[$trader->id])?@$amount[$trader->id]:"0.00"}}&nbsp;&nbsp;
                            @if(in_array($verify_days,['Saturday','Sunday']))
                            <i class="edit-icon fa fa-edit show-input" data-id="{{$trader->id}}"></i>
                            @endif
                        </p>
                    </div>

                    <a href="#" class="text-small btn-block mb-3 text-uppercase view-trader"
                    data-name="{{($trader->translation['name'])? $trader->translation['name'] : $trader->name}}" 
                    data-subtitle="{{($trader->translation['subtitle'])? $trader->translation['subtitle'] : $trader->subtitle}}"
                    data-graph="{{$trader->graph_picture}}"  data-best_trader="@if(file_exists(public_path('/traders/besttrader/'.$trader->best_trader_image)) && $trader->best_trader_image) {{$trader->best_trader_image}} @endif"
                    data-description="{{ ($trader->translation['description'])? $trader->translation['description'] : $trader->description }}">@lang('traders.view_graph')</a>
                    <div class="items info-block block-info clearfix">
                        <div class="btn-group btn-block itemcontent">
                            <label class="btn btn-my-gradient btn-block text-uppercase"
                            id="remove_{{$trader->id}}">
                            <div class="itemcontent">
                                <input type="checkbox" class="sub_chk" data-id="{{$trader->id}}"
                                name="var_id[]" value="{{$trader->id}}" checked="checked"
                                autocomplete="off" {{(!in_array($verify_days,['Saturday','Sunday'])) ? 'Disabled' : ''}}>
                                <div id="dem_{{$trader->id}}">@lang('traders.selected')</div>
                            </div>
                        </label>
                    </div>
                </div>
            </div>
        </div>
        @else
        <div class="card p-4 " id="addactive_{{$trader->id}}">
            <div class="text-center">
                <div class="traderBg" style="background: url({{asset('traders/besttrader')}}/{{$trader->best_trader_image}})">

                </div>
                <img src="{{asset('traders')}}/{{$trader->profile_picture}}" alt="profile"
                class="img-lg rounded-circle mb-4 tradeBgImg">
                <div class="mb-3">
                    <h3 class="medbultertext text-white m-0">{{($trader->translation['name'])? str_limit($trader->translation['name'],14) : str_limit($trader->name,14)}} </h3>
                </div>
                
                <div class="hrlinedark mb-3"></div>
                <p class="mb-3 regbultertext text-white">{{($trader->translation['subtitle'])? str_limit($trader->translation['subtitle'],14) : str_limit($trader->subtitle,14)}}</p>
                <div class="hrlinedark mb-3"></div>

                <div class="invest-amont-graph">
                    <p class="mb-3 regbultertext text-white invest-amount pl-0 pr-0">
                        <input type="number" autocomplete="off" step="0.01" maxlength="28" name="amount[{{$trader->id}}]" placeholder="@lang('traders.amount_placeholder')" class="form-control-sm  amount-class" readonly="" min="{{$trader->minimum_amount}}" @if($trader->maximum_amount && $trader->maximum_amount != '0') max="{{$trader->maximum_amount}}" @endif />
                    </p>
                    <a href="#" class="text-small btn-block mb-3 text-uppercase view-trader"
                    data-name="{{($trader->translation['name'])? $trader->translation['name'] : $trader->name}}" data-subtitle="{{($trader->translation['subtitle'])? $trader->translation['subtitle'] : $trader->subtitle}}" data-graph="{{$trader->graph_picture}}"  data-best_trader="@if(file_exists(public_path('/traders/besttrader/'.$trader->best_trader_image)) && $trader->best_trader_image) {{$trader->best_trader_image}} @endif"
                    data-description="{{ ($trader->translation['description'])? $trader->translation['description'] : $trader->description }}">@lang('traders.view_graph')</a>
                </div>
                <div class="items info-block block-info clearfix">
                    <div class="btn-group btn-block itemcontent">
                        <label class=" btn btn-primary btn-block text-uppercase"
                        id="remove_{{$trader->id}}">
                        <div class="itemcontent">
                            <input type="checkbox" class="sub_chk" data-id="{{$trader->id}}"
                            name="var_id[]"  value="{{$trader->id}}" {{(!in_array($verify_days,['Saturday','Sunday'])) ? 'Disabled' : ''}}>
                            <div id="dem_{{$trader->id}}">@lang('traders.select_trader')</div>
                        </div>
                    </label>
                </div>
            </div>
        </div>
    </div>
    @endif
    @else
    <div class="card p-4 " id="addactive_{{$trader->id}}">
        <div class="text-center">
            <div class="traderBg" style="background: url({{asset('traders/besttrader')}}/{{$trader->best_trader_image}})">
            </div>

            <img src="{{asset('traders')}}/{{$trader->profile_picture}}" alt="profile"
            class="img-lg rounded-circle mb-4 tradeBgImg">
            <div class="mb-3">
                <h3 class="medbultertext text-white m-0">{{str_limit($trader->name,14)}}</h3>
            </div>
            <div class="hrlinedark mb-3"></div>
            <p class="mb-3 regbultertext text-white">{{str_limit($trader->subtitle,14)}}
            </p>
            <div class="hrlinedark mb-3"></div>

            <div class="invest-amont-graph">
                <p class="mb-3 regbultertext text-white invest-amount">
                    <input type="number" autocomplete="off" step="0.01" maxlength="28" name="amount[{{$trader->id}}]" placeholder="@lang('traders.amount_placeholder')" class="form-control-sm amount-class " min="{{$trader->minimum_amount}}"  @if($trader->maximum_amount && $trader->maximum_amount != 0) max="{{$trader->maximum_amount}}" @endif />
                </p>
                <a href="#" class="text-small btn-block mb-3 text-uppercase view-trader"
                data-name="{{($trader->translation['name'])? $trader->translation['name'] : $trader->name}}" data-subtitle="{{($trader->translation['subtitle'])? $trader->translation['subtitle'] : $trader->subtitle}}" data-graph="{{$trader->graph_picture}}" data-best_trader="@if(file_exists(public_path('/traders/besttrader/'.$trader->best_trader_image)) && $trader->best_trader_image) {{$trader->best_trader_image}} @endif"
                data-description="{{ ($trader->translation['description'])? $trader->translation['description'] : $trader->description }}">@lang('traders.view_graph')</a>
            </div>
            <div class="items info-block block-info clearfix">
                <div class="btn-group btn-block itemcontent">
                    <label class=" btn btn-primary btn-block text-uppercase"
                    id="remove_{{$trader->id}}">
                    <div class="itemcontent">
                        <input type="checkbox" id="check" data-id="{{$trader->id}}"
                        class="sub_chk" name="var_id[]" value="{{$trader->id}}" readonly {{(!in_array($verify_days,['Saturday','Sunday'])) ? 'Disabled' : ''}}>
                        @lang('traders.select_trader')
                    </div>
                </label>
            </div>
        </div>
    </div>
</div>
@endif
<div class="modal fade" id="exampleModal-1" tabindex="-1" aria-labelledby="myModalLabel"
role="dialog" aria-hidden="true">
<div class="modal-dialog lg" role="document">
    <div class="modal-content p-4">
        <a href="javascript:;" class="d-block text-right text-uppercase text-white text-small"
        data-dismiss="modal" aria-label="Close">@lang('general.close')</a>
        <div class="mb-3 mt-3">
            <h3 class="medbultertext text-white m-0" id="trader-name"></h3>
        </div>
        <p class="mb-3 regbultertext text-white" style="" id="subtitle"></p>
        <span class="bestTraderImagespn"></span>
        <!-- <img src="" class="bestTraderImage" style="max-height:220px;width: auto"> -->

        <p class="mb-3 regbultertext text-white" style=""
        id="description"></p>
        <img src="" class="imagepreview" style="max-height:220px;width: auto">

    </div>
</div>
</div>
</div>
@endforeach
@else
No Traders Available
@endif
</div>

<div class="cardbg">
    <div class="d-block d-md-flex row justify-content-between align-items-center">
        <div class="col grid-margin grid-margin-md-0">@lang('general.showing') {{ $traders->firstItem() }}
            to {{ $traders->lastItem() }} of {{ $traders->total() }} @lang('general.entries')
        </div>
        <div class="col">
            <ul class="pagination flex-wrap justify-content-md-end mb-0">
                {{$traders->links()}}
            </ul>
        </div>
    </div>
</div>
<input type="hidden" id="hidden_val">
<div class="row mt-4">
    <div class="col-md-12 text-right">
        <button type="submit" id="master" class="btn btn-my-gradient text-uppercase px-5 " {{(!in_array($verify_days,['Saturday','Sunday'])) ? 'Disabled' : ''}}>@lang('traders.confirm_trader')
        </button>
    </div>
</div>
</form>

<div class="hrlinelight mt-4 mb-5"></div>

<header class="section-title titlebottomline">
    <h2 class="hrowheading">@lang('traders.history')</h2>
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
            <form method="post" action="{{route('choose-traders')}}">
                @csrf
                <div class="mr-auto row trader-history">
                    <div id="" class="input-group col-sm-6">
                        <input type="text" name="date-range-my" id="date-range" placeholder="@lang('general.search_date')"
                        value="{{$searchedDate}}" class="form-control readonly-text" readonly>
                        <input type="hidden" name="start_date" id="startdate" class="form-control">
                        <input type="hidden" name="end_date" id="enddate" class="form-control">
                        <span class="input-group-addon input-group-append border-left">
                            <i  class="ti-calendar input-group-text"></i>
                            <!-- <button type="submit" name="date-range" class="ti-calendar input-group-text"></button> -->
                        </span>
                    </div>
                    <div class="input-group col-sm-3">
                        <button type="submit" name="date-range" class="form-control">Search</button>
                    </div>
                    <div class="input-group col-sm-3">
                        <button type="submit" name="date-range" class="form-control btn-reset">@lang('general.reset')</button>
                        <!-- <button type="submit" name="submit" class="btn-outline-twitter input-group-text btn-reset">@lang('general.reset') -->
                        </button>
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
                            <th>No.</th>
                            <th>@lang('traders.trader')</th>
                            <th>@lang('general.amount')</th>
                            <th>@lang('traders.switch_date')</th>
                            <th>@lang('general.status')</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($traderHistories)
                        @php $x = $traderHistories->firstItem() @endphp
                        @foreach($traderHistories as $i => $history)
                        @if($history->traders)
                        <tr>
                            <td>{{$x++}}</td>
                            <td>{{isset($history->traders->translation['name']) && $history->traders->translation['name']!="" ? $history->traders->translation['name'] : $history->traders->name}}</td>
                            <td>IDR {{$history->amount}}</td>
                            <td>{{$history->created_at->format('m/d/Y')}}</td>
                            @if($history->status == 1)
                            <td><label class="badge badge-success">@lang('general.approved')</label></td>
                            @elseif($history->status == 2)
                            <td><label class="badge badge-danger">@lang('general.rejected')</label></td>
                            @elseif($history->status == 3)
                            <td><label class="badge badge-info">@lang('general.expired')</label></td>
                            @else
                            <td><label class="badge badge-warning">@lang('general.pending')</label></td>
                            @endif
                            <td><label class="badge badge-danger"></label></td>
                            <td><a href="#" class="badge badge-outline-primary px-3 view_trader_graph"
                                data-graph="{{$history->traders->graph_picture}}">@lang('general.view')</a>
                                @if($history->remarks)
                                <a href="#" data-remarks="{{nl2br($history->remarks)}}" class="badge badge-outline-primary view-remarks">@lang('general.remarks')</a>
                                @endif
                            </td>
                        </tr>
                        @endif
                        @endforeach
                        @else
                        No history founds
                        @endif
                    </tbody>
                </table>
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

            <div class="modal fade" id="view_traders" tabindex="-1" aria-labelledby="myModalLabel" role="dialog"
            aria-labelledby="myModalLabel" role="dialog" aria-hidden="true">
            <div class="modal-dialog lg" role="document">
                <div class="modal-content p-4">
                    <a href="javascript:;" class="d-block text-right text-uppercase text-white text-small"
                    data-dismiss="modal" aria-label="Close">@lang('general.close')</a>
                    <div class="modal-content p-4">
                        <img src="" class="imagepreview" style="max-height:220px;width:auto">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="d-block d-md-flex row justify-content-between mt-8 align-items-center">
        @if($traderHistories->total() > 0)
        <div class="col grid-margin grid-margin-md-0">@lang('general.showing') {{ $traderHistories->firstItem() }}
            to {{ $traderHistories->lastItem() }} of {{ $traderHistories  ->total() }} @lang('general.entries')
        </div>
        @else
        <div class="col-12 d-block text-center">
            No records found
        </div>
        @endif

        <div class="col">
            <ul class="pagination flex-wrap justify-content-md-end mb-0">
                {{$traderHistories->links()}}
            </ul>
        </div>
    </div>
</div>
</div>
@endsection
@section('page_js')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var elements = document.getElementsByTagName("INPUT");
        for (var i = 0; i < elements.length; i++) {
            elements[i].oninvalid = function(e) {
                e.target.setCustomValidity("");
                if (!e.target.validity.valid) {

                    e.target.setCustomValidity("You must pick a number between "+e.target.getAttribute('min')+" and "+e.target.getAttribute('max')+".");
                }
            };
            elements[i].oninput = function(e) {
                e.target.setCustomValidity("");
            };
        }
    })
    function forceNumber(element) {
        // alert();
        element
        .data("oldValue", '')
        .bind("paste", function(e) {
          var validNumber = /^[-]?\d+(\.\d{1,2})?$/;
          element.data('oldValue', element.val())
          setTimeout(function() {
            if (!validNumber.test(element.val()))
              element.val(element.data('oldValue'));
      }, 0);
      });
        element
        .keypress(function(event) {
          var text = $(this).val();
        if ((event.which != 46 || text.indexOf('.') != -1) && //if the keypress is not a . or there is already a decimal point
        ((event.which < 48 || event.which > 57) && //and you try to enter something that isn't a number
          (event.which != 45 || (element[0].selectionStart != 0 || text.indexOf('-') != -1)) && //and the keypress is not a -, or the cursor is not at the beginning, or there is already a -
          (event.which != 0 && event.which != 8))) { //and the keypress is not a backspace or arrow key (in FF)
            event.preventDefault(); //cancel the keypress
    }

        if ((text.indexOf('.') != -1) && (text.substring(text.indexOf('.')).length > 2) && //if there is a decimal point, and there are more than two digits after the decimal point
        ((element[0].selectionStart - element[0].selectionEnd) == 0) && //and no part of the input is selected
        (element[0].selectionStart >= element.val().length - 2) && //and the cursor is to the right of the decimal point
        (event.which != 45 || (element[0].selectionStart != 0 || text.indexOf('-') != -1)) && //and the keypress is not a -, or the cursor is not at the beginning, or there is already a -
        (event.which != 0 && event.which != 8)) { //and the keypress is not a backspace or arrow key (in FF)
            event.preventDefault(); //cancel the keypress
    }
    var length = text.substring(text.indexOf('.'), text.indexOf('.').length).length;
    console.log(length);
    if(text.indexOf('.') != -1 && length > 2){
        event.preventDefault();
    }
// alert();
var length = 25;
var decimalLength = 0;
if(text.indexOf('.') != -1){
        // alert(length); alert(text.length);
        decimalLength = text.substring(text.indexOf('.'), text.indexOf('.').length).length;
    }
    length += decimalLength;

    if(text.length > length && text.substring(0,9) != '.'){
        event.preventDefault();
    }
});
    }

    $('.show-txt').on('click',function(){
        var id = $(this).data('id');
        $('.label-'+id).removeClass('d-none');
        $('.input-'+id).addClass('d-none');
    });
    $('.show-input').on('click',function(){
        var id = $(this).data('id');
        $('.label-'+id).addClass('d-none');
        $('.input-'+id).removeClass('d-none'); 

    });
    var total_capital = {{auth()->user()->userwallet!=null?auth()->user()->userwallet->topup_fund:0.00}};
    $(document).ready(function () {

        if($('ul.pagination li').length != undefined && $('ul.pagination li').length > 0){
                // document.getElementById('pagination a').onchange = function() {
                //     window.location = "{{ $traderHistories->url(1) }}&items=" + this.value;
                // };

                // document.getElementById('traders').onchange = function() {
                //     window.location = "{{ $traders->url(1) }}&items=" + this.value;
                // };
            }

            $('input[type="checkbox"]').click(function () {
                if ($(this).is(":checked")) {
                    $(this).addClass("active");
                    var chvalue = $(this).val();
                    $('#remove_' + chvalue).addClass('back');
                    $('#remove_' + chvalue).addClass('active');
                    $('#addactive_' + chvalue).addClass('active');
                    $('#dem_' + chvalue).text('Selected');
                    $('#addactive_' + chvalue).find('.invest-amount input').attr('required',"true").removeAttr('readonly');
                } else if ($(this).is(":not(:checked)")) {
                    var chvalue = $(this).val();
                    $('#remove_' + chvalue).removeClass('back');
                    $('#remove_' + chvalue).removeClass('active');
                    $('#addactive_' + chvalue).removeClass('active');
                    $('#addactive_' + chvalue).removeClass('active');
                    $('#dem_' + chvalue).text('Select Trader');
                    $('#remove_' + chvalue).removeClass('btn-my-gradient');
                    $('#remove_' + chvalue).addClass('btn-primary');
                    $('#addactive_' + chvalue).find('.invest-amount input').attr('readonly',true).removeAttr('required');
                }
            });
        });

    $(function () {
        $('.view-trader').on('click', function () {
            var name = $(this).data('name');
            var description = $(this).data('description');
            var newsrc = "{{asset('traders/graphs')}}"
            var graph = $(this).data('graph');
            var subtitle = $(this).data('subtitle');
            var best_trader = $(this).data('best_trader');
            var src = "{{asset('traders/besttrader')}}"

            $('.imagepreview').attr('src', newsrc + "/".concat(graph));

            if(best_trader != ''){
                var path = src + "/".concat(jQuery.trim(best_trader));
                $('.bestTraderImagespn').html('<img src="'+jQuery.trim(path)+'" class="bestTraderImage" style="max-height:220px;width: 100%">');
            }

            $('#trader-name').text(name);
            $('#subtitle').html(subtitle);
            $('#description').html(description);
            $('#exampleModal-1').modal('show');
        });

        $('.view_trader_graph').on('click', function () {
            // alert($(this).data('remarks'));
            var newsrc = "{{asset('traders/graphs')}}"
            var graph = $(this).data('graph');
            $('.imagepreview').attr('src', newsrc + "/".concat(graph));
            // $('#remarks').html($(this).data('remarks'));
            $('#view_traders').modal('show');
        });
        $('.view-remarks').on('click', function () {

            var remarks = $(this).data('remarks');
            $('#view_remarks').html(remarks);
            // $('#view_remarks').html(remarks.replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1<br>$2'));
            $('#view-remarks').modal('show');

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
        $('.invest-amount input').each(function(e){
            forceNumber($(this));
        });
        function calculateInvestment(){
            var total = 0;
            var var_id = [];
            $('.invest-amount input').each(function(e){
                if($(this).prop('readonly') != true && $(this).val() != 0){
                    total += parseFloat($(this).val());
                    // alert($(this).val());
                    console.log("total::",total);
                    var length = $(this).val().substring($(this).val().indexOf('.'), $(this).val().indexOf('.').length).length;
                    console.log(length);
                    if($(this).val().indexOf('.') != -1 && length > 3){
                        // val.replace(/\.+$/,"");
                        alert("{{trans('traders.validate_decimal')}}");
                        return false;
                    }

                }

                return true;
            })
        // if (!total) {
        //     alert("{{trans('traders.validate_choosetrader')}}");
        //     return false;
        // }
        if(total > total_capital){
            alert("{{trans('traders.validate_income')}}");
            return false;
        }
        return true;
    }
    $(document).ready(function(){
        $('.invest-amount input[type="number"]').on('change',function(){
            calculateInvestment();
        });
    })

    $('.submit-traders').on('submit', function (e) {
        e.preventDefault();
        if(calculateInvestment()){
            $.ajax({
                url: '{{route('save-traders')}}',
                type: 'POST',
                data: $(this).serialize(),
                success: function (data) {
                    if (data['success']) {
                        $(".sub_chk:checked").each(function () {
                        });
                        $("#display_sucess").html(` <div class="alert alert-success alert-dismissible fade show" role="alert">
                           <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                           <span aria-hidden="true">&times;</span>
                           </button> Traders Selected
                           </div>`);
                        window.location.reload();
                    } else {
                        alert("{{trans('traders.validate_choosetrader')}}");
                    }
                },
                error: function (data) {
                    alert(data.responseText);
                }
            });
        }

    });
    $('.confirmed').on('click', function (e) {

        var allVals = [];
        $(".sub_chk:checked").each(function () {
            allVals.push($(this).attr('data-id'));

        });
        var join_selected_values = allVals.join(",");

    });
});
</script>

@endsection
