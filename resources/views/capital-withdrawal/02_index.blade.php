@extends('layouts.app')
@section('title', trans('sidebar.capital_withdrawal'))

@section('content')
<style>
    #security_error, .error {
        color: red;
    }
    .wizard > .content > .body label.error{
      margin-left:0;
    }
</style>
<div class="d-block mt-30"></div>

<div class="text-white text-center w-100 medimagebgdiv" style="background-image: url(./images/earnings.png)">
    <h3 class="m-0 boldbultertext">@lang('capital_withdrawal.title')</h3>
</div>
@if(session()->has('error'))
<div class="alert alert-danger alert-dismissible fade show  mt-4" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
  {{ session()->get('error') }}
</div>
@endif
@if(session()->has('message'))
<div class="alert alert-success alert-dismissible fade show mt-4" role="alert">
  {{ session()->get('message') }}
</div>
@endif
        <div class="content-wrapper">
          <div class="row">
            <div class="col-12 grid-margin">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title"></h4>
                  <form id="example-form" action="{{route('capital-withdrawal.store')}}" method="post" >
                    {{csrf_field()}}
                    <div>
                      <h3>@lang('capital_withdrawal.terms')</h3>
                      <section>
                        <!-- <h3>@lang('capital_withdrawal.terms')</h3> -->
                        <div>{!! trans('capital_withdrawal.terms_content') !!}</div>
                      </section>
                      <h3>@lang('capital_withdrawal.withdrawal_detail')</h3>
                      <section>
                        <div class="form-group">
                          <label>Choose Traders</label>
                          <select class="form-control" name="choose_trader" data-error="#err_trader" required onchange="caclulate($(this))">
                              @foreach($traders as $trader)
                              <option value="{{$trader->trader_id}}" data-amount="{{$trader->amount}}"> 
                                {{$trader->traders->translation!=null?$trader->traders->translation->name:$trader->traders->name}} [{{$trader->amount}}]
                              </option>
                              @endforeach
                          </select>
                          <div id="err_trader"></div>
                        </div>
                        <div class="form-group">
                          <label>@lang('capital_withdrawal.amount')</label>
                          <input type="amount" required name="amount" data-error="#err_amount" class="form-control" id="capital_withdrawal_amount" placeholder="@lang('capital_withdrawal.amount')" value="{{old('amount')}}">
                          <div id="err_amount"></div>
                        </div>
                        <div class="form-group">
                          <label>@lang('capital_withdrawal.security_password')</label>
                          <input type="password" name id="security_password" class="form-control" data-error="#security_error" placeholder="@lang('capital_withdrawal.enter_security_password')">
                          <label id="security_error"></label>
                        </div>
                      </section>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
          <!--vertical wizard-->
          <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="table-responsive">
                                <table id="order-listing" class="table text-muted">
                                    <thead>
                                    <!------------------------changes-->
                                    <tr class="text-black">
                                        <th><i class="active"></i> No.</th>
                                        <th><i class="active"></i> Amount</th>
                                        <th><i class="active"></i> Request Date</th>
                                        <th><i class="active"></i> Status</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(!count($capital_withdraw))
                                    <tr>
                                      <th colspan="5" class="text-center">No records found</th>
                                    </tr>
                                    @else
                                    @php $x = $capital_withdraw->firstItem() @endphp
                                      @foreach($capital_withdraw as $row)
                                        <tr>
                                          <td>{{$x++}}</td>
                                          <td>{{$row->amount}}</td>
                                          <td>{{$row->created_at->format('m/d/Y')}}</td>
                                          <td>
                                            @if($row->status == 1)
                                              <label class="badge badge-success">Approved</label>
                                            @elseif($row->status == 2)
                                              <label class="badge badge-danger">Rejected</label>
                                            @else
                                              <label class="badge badge-warning">Pending</label>
                                            @endif
                                          </td>
                                        </tr>
                                      @endforeach
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                            <div class="d-block d-md-flex row justify-content-between mt-4 align-items-center">
                                 @if($capital_withdraw->total() > 0)
                                    <div class="col grid-margin grid-margin-md-0">Showing {{ $capital_withdraw->firstItem() }}
                                        to {{ $capital_withdraw->lastItem() }} of {{ $capital_withdraw->total() }} entries
                                    </div>
                                @endif
                                <div class="col">
                                    <ul class="pagination flex-wrap justify-content-md-end mb-0">
                                        {{$capital_withdraw->links()}}
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection
@section('page_js')
<script src="{{asset('js/jquery.steps.min.js')}}"></script>
<script src="{{asset('js/jquery.validate.min.js')}}"></script>
<script type="text/javascript">
    var amount;
    var caclulate = function(th) {
        // body...
        amount = 0;
        $('select[name="choose_trader"]').find('option:checked').each(function(){
                amount += parseFloat($(this).attr('data-amount'));
            // console.log("amount",amount);
        });
        // var amount += 
        // alert('Amount::',amount);
        $( "#capital_withdrawal_amount" ).rules( "add", {
          max: amount
        });
    }

    var form = $("#example-form");
    form.validate({
      errorPlacement: function errorPlacement(error, element) 
      {
        var placement = $(element).data('error');
        if (placement) {
          $(placement).append(error)
        } else {
          error.insertAfter(element);
        }
      },
      rules: {
        choose_trader: {
          required: true
        },
        amount: {
          required: true,
          number:true,
          min:0,
        },
        security_password: {
          required: true,
        }
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
              $('#security_error').text('Security Password did not matched')
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

    form.children("div").steps({
      headerTag: "h3",
      bodyTag: "section",
      transitionEffect: "slideLeft",
      onStepChanging: function(event, currentIndex, newIndex) {
        form.validate().settings.ignore = ":disabled,:hidden";
        return form.valid();
      },
      onFinishing: function(event, currentIndex) {
        form.validate().settings.ignore = ":disabled";
        return form.valid();
      },
      onFinished: function(event, currentIndex) {
        $("#example-form").submit();
      }
    });
    

</script>
<!-- <script src="{{asset('js/wizard.js')}}"></script> -->

@endsection