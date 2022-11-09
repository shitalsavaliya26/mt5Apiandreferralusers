@extends('layouts.admin_app')
@section('title', 'Settings')
<style>
    .error {
        color: red;
    }
</style>
@section('content')
    <div class="main-panel">
        <div class="content-wrapper">
            @if(session()->has('message'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    {{ session()->get('message') }}
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
            
            <div class="row">
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="col-12 grid-margin">
                                <h4 class="card-title pb-1">General Settings</h4>
                                <form class="form-sample" method="post" id="setting"
                                      action="{{route('settings')}}">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group row">
                                                <label class="col-sm-12 col-form-label">Admin Email
                                                    address</label> <!-- first name to rank name-->
                                                <div class="col-sm-12"><!-- col-sm-9 to col-sm-12-->
                                                    <input type="text" name="admin_email" class="form-control"
                                                           value="{{old('admin_email',$setting->admin_email)}}"
                                                           placeholder="enter email"/>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group row">
                                                <label class="col-sm-12 col-form-label">Minimum withdrawal
                                                    request amount</label>
                                                <div class="col-sm-12"><!-- col-sm-9 to col-sm-12-->
                                                    <input type="text" class="form-control"
                                                           name="minimum_withdraw_amount"
                                                           value="{{old('minimum_withdraw_amount',$setting->minimum_withdraw_amount)}}"
                                                           id="minimum_withdraw_amount" 
                                                           placeholder="Minimum withdrawal request amount"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group row">
                                                <label class="col-sm-12 col-form-label">Withdrawal fees</label>
                                                <div class="col-sm-12"><!-- col-sm-9 to col-sm-12-->
                                                    <input type="text" class="form-control" name="withdraw_fees"
                                                           value="{{old('withdraw_fees',$setting->withdraw_fees)}}"
                                                           id="withdraw_fees" 
                                                           placeholder="enter withdrawal fees"/>
                                                </div>
                                            </div>
                                        </div>                                                
                                    
                                        <div class="col-md-4" style="display:none;">
                                            <div class="form-group row">
                                                <label class="col-sm-12 col-form-label">Topup Process
                                                    fees</label>
                                                <div class="col-sm-12"><!-- col-sm-9 to col-sm-12-->
                                                    <input type="text" class="form-control"
                                                           name="topup_process_fees"
                                                           value="{{old('topup_process_fees',$setting->topup_process_fees)}}"
                                                           placeholder="enter topup process fees"/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br/>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                               
                                                    <button type="submit" class="btn btn-primary">Save
                                                    </button>
                                                
                                                    <button type="reset" class="btn btn-secondary">Reset
                                                    </button>
                                                
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                    
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col grid-margin">
                                    <h4 class="card-title pb-1">Payment Bank Details</h4>
                                    <form class="form-sample" method="post" id="pay-setting"
                                          action="{{route('payments-settings')}}">
                                        @csrf

                                        <!--Deposit bank details-->
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group row">
                                                    <label class="col col-form-label">Deposit Bank Account Name</label>
                                                    <!-- first name to rank name-->
                                                    <div class="col-sm-12"><!-- col-sm-9 to col-sm-12-->
                                                        <input type="text" name="account_name"
                                                               class="form-control"
                                                               value="{{old('account_name',$paymentSetting->account_name)}}"
                                                               placeholder="account name"/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group row">
                                                    <label class="col col-form-label">Deposit Bank Name</label>
                                                    <div class="col-sm-12"><!-- col-sm-9 to col-sm-12-->
                                                        <input type="text" class="form-control" name="bank_name"
                                                               value="{{old('bank_name',$paymentSetting->bank_name)}}"
                                                               placeholder="enter bank name"/>
                                                    </div>
                                                </div>
                                            </div>
                                       
                                            <div class="col-md-3">
                                                <div class="form-group row">
                                                    <label class="col col-form-label">Deposit Account Number</label>
                                                    <!-- first name to rank name-->
                                                    <div class="col-sm-12"><!-- col-sm-9 to col-sm-12-->
                                                        <input type="text" name="account_number"
                                                               class="form-control"
                                                               value="{{old('account_number',$paymentSetting->account_number)}}"
                                                               placeholder="enter account number"/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group row">
                                                    <label class="col col-form-label">Deposit Account Opening</label>
                                                    <div class="col-sm-12"><!-- col-sm-9 to col-sm-12-->
                                                        <input type="text" class="form-control"
                                                               name="account_opening"
                                                               value="{{old('account_opening',$paymentSetting->account_opening)}}"
                                                               placeholder="enter account opening"/>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--End primary bank details-->

                                            <!--Withdrawal Bank details-->
                                            <div class="col-md-3">
                                                <div class="form-group row">
                                                    <label class="col col-form-label">Withdrawal Bank Account Name</label>
                                                    <!-- first name to rank name-->
                                                    <div class="col-sm-12"><!-- col-sm-9 to col-sm-12-->
                                                        <input type="text" name="second_account_name"
                                                               class="form-control"
                                                               value="{{old('account_name',$paymentSetting->second_account_name)}}"
                                                               placeholder="account name"/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group row">
                                                    <label class="col col-form-label">Withdrawal Bank Name</label>
                                                    <div class="col-sm-12"><!-- col-sm-9 to col-sm-12-->
                                                        <input type="text" class="form-control" name="second_bank_name"
                                                               value="{{old('second_bank_name',$paymentSetting->second_bank_name)}}"
                                                               placeholder="enter bank name"/>
                                                    </div>
                                                </div>
                                            </div>
                                       
                                            <div class="col-md-3">
                                                <div class="form-group row">
                                                    <label class="col col-form-label">Withdrawal Account Number</label>
                                                    <!-- first name to rank name-->
                                                    <div class="col-sm-12"><!-- col-sm-9 to col-sm-12-->
                                                        <input type="text" name="second_account_number"
                                                               class="form-control"
                                                               value="{{old('second_account_number',$paymentSetting->second_account_number)}}"
                                                               placeholder="enter account number"/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group row">
                                                    <label class="col col-form-label">Withdrawal Account Opening</label>
                                                    <div class="col-sm-12"><!-- col-sm-9 to col-sm-12-->
                                                        <input type="text" class="form-control"
                                                               name="second_account_opening"
                                                               value="{{old('second_account_opening',$paymentSetting->second_account_opening)}}"
                                                               placeholder="enter account opening"/>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--End secondary bank details-->
                                            
                                            <div class="col-md-4">
                                                <div class="form-group row">
                                                    <label class="col col-form-label">USD 1 = IDR</label>
                                                    <!-- first name to rank name-->
                                                    <div class="col-sm-12"><!-- col-sm-9 to col-sm-12-->
                                                        <input type="text" name="rmb" class="form-control"
                                                               value="{{old('rmb',$paymentSetting->rmb)}}"
                                                               placeholder="enter rmb"/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group row">
                                                    <label class="col col-form-label">USD 1 = NTD</label>
                                                    <div class="col-sm-12"><!-- col-sm-9 to col-sm-12-->
                                                        <input type="text" class="form-control" name="ntd"
                                                               value="{{old('ntd',$paymentSetting->ntd)}}"
                                                               placeholder="enter ntd"/>
                                                    </div>
                                                </div>
                                            </div>
                                        
                                            <div class="col-md-4">
                                                <div class="form-group row">
                                                    <label class="col col-form-label">USD 1 = HKD</label>
                                                    <!-- first name to rank name-->
                                                    <div class="col-sm-12"><!-- col-sm-9 to col-sm-12-->
                                                        <input type="text" name="hkd" class="form-control"
                                                               value="{{old('hkd',$paymentSetting->hkd)}}"
                                                               placeholder="enter hkd"/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group row">
                                                    <label class="col col-form-label">USD 1 = USDT</label>
                                                    <div class="col-sm-12"><!-- col-sm-9 to col-sm-12-->
                                                        <input type="text" class="form-control" name="usdt"
                                                               value="{{old('usdt',$paymentSetting->usdt)}}"
                                                               placeholder="enter usdt"/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group row">
                                                    <label class="col-sm-12 col-form-label">USD 1 = JPY</label>
                                                    <div class="col-sm-12"><!-- col-sm-9 to col-sm-12-->
                                                        <input type="text" class="form-control" name="jpy"
                                                               value="{{old('jpy',$paymentSetting->jpy)}}"
                                                               placeholder="enter jpy"/>
                                                    </div>
                                                </div>
                                            </div>                           
                                            <div class="col-md-12">                     
                                                <div class="form-group">                     
                                                    <button type="submit" class="btn btn-primary mr-2" >Save</button>
                                                   <button type="reset" class="btn btn-secondary">Reset</button>
                                                </div>                                                        
                                            </div>                                                        
                                        </div>
                                    </form>                                        
                                </div>
                            </div>
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
                    $('#setting').validate({
                        rules: {
                            admin_email: {
                                required: true,
                                email: true
                            },
                            minimum_withdraw_amount: {
                                required: true
                            },
                            withdraw_fees: {
                                required: true,
                            },
                            topup_process_fees: {
                                required: true
                            },
                        },
                    });
                    $('#pay-setting').validate({
                        rules: {
                            account_name: {
                                required: true,
                            },
                            bank_name: {
                                required: true
                            },
                            account_number: {
                                required: true
                            },
                            account_opening: {
                                required: true
                            },
                            rmb: {
                                required: true
                            },
                            ntd: {
                                required: true
                            },
                            hkd: {
                                required: true
                            },
                            usdt: {
                                required: true
                            },
                            jpy: {
                                required: true
                            },
                        }
                    });
                </script>
                <script type="text/javascript">
                    $(document).on('keyup','#setting',function(){
                        var minimum_withdraw_amount = $('#minimum_withdraw_amount').val();
                        var withdraw_fees = $('#withdraw_fees').val();

                        $('#minimum_withdraw_amount').attr('min',withdraw_fees);
                        $('#withdraw_fees').attr('max',minimum_withdraw_amount);
                    });
                </script>
@endsection
