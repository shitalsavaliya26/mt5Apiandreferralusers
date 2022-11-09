<!--- MOdel survey Capitl form ----->
<div id="modal_capital_survey" class="modal fade" role="dialog">
  <div class="modal-dialog  modal-lg">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-body">
           
            <div class="cust-wizards">
                {!! Form::open(['route' => 'capital-withdraw.store','enctype' => 'multipart/form-data','id'=>'form-wizards','calss' => 'wizard-big','method'=>'POST'])!!}
                    {{Form::hidden('amount',old('amount'),['class' => 'form-control '])}}
                    {{Form::hidden('security_password',old('security_password'),['class' => 'form-control '])}}
                    <h1><img src="{{asset('/images/image-asset/Icons/step-1.png')}}" class="fluid" ></h1>
                    <fieldset>
                        <h2 class="m-t-sm">{{trans('custom.by_read_tnc')}}</h2>
                        <div class="row">
                            <div class="col-lg-12">
                                {!! trans('custom.mt4with_step1_tnc')  !!}
                            </div>
                        </div>
                    </fieldset>
                    <h1><img src="{{asset('/images/image-asset/Icons/step-2.png')}}" class="fluid" ></h1>
                    <fieldset>
                        <h2>{{trans('custom.mt4with_step2')}}</h2>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <div class="from-inner-space">
                                        <label class="mb-2 bmd-label-static block">{{trans('custom.mt4with_step2_q1')}}:<span class="text-red">*</span></label>
                                        {{Form::text('mt4w_servey[1]',old('mt4w_servey[1]'),['class' => 'form-control '])}}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="from-inner-space">
                                        <label class="mb-2 bmd-label-static block">{{trans('custom.mt4with_step2_q2')}}:<span class="text-red">*</span></label>
                                        {{Form::text('mt4w_servey[2]',old('mt4w_servey[2]'),['class' => 'form-control '])}}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="from-inner-space">
                                        <label class="mb-2 bmd-label-static block">{{trans('custom.mt4with_step2_q3')}}:<span class="text-red">*</span></label>
                                        {{Form::text('mt4w_servey[3]',old('mt4w_servey[3]'),['class' => 'form-control '])}}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="from-inner-space">
                                        <label class="mb-2 bmd-label-static block">{{trans('custom.mt4with_step2_q4')}}:<span class="text-red">*</span></label>
                                        {{Form::text('mt4w_servey[4]',old('mt4w_servey[4]'),['class' => 'form-control '])}}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="from-inner-space">
                                        <label class="mb-2 bmd-label-static block">{{trans('custom.mt4with_step2_q5')}}:<span class="text-red">*</span></label>
                                        {{Form::text('mt4w_servey[5]',old('mt4w_servey[5]'),['class' => 'form-control '])}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                    <h1><img src="{{asset('/images/image-asset/Icons/step3.png')}}" class="fluid" ></h1>
                    <fieldset>
                        <div class="row">
                            <div class="col-sm-6 text-left">
                                <div class="form-group ">
                                    <div style="margin-top:0px" class="form-group label-floating">
                                        <label class="control-label block">{{trans('custom.upl_ic_proof')}} <small>(*)</small></label>
                                        <input name="ic_proof" id="ic_proof" type="file" class="" aria-required="true" required="" accept="image/*">
                                    </div>
                                </div>
                                <div class="form-group ">
                                    <div class="form-group label-floating">
                                        <label class="control-label block">{{trans('custom.upl_bank_proof')}} <small>(*)</small></label>
                                        <input name="bank_proof" id="bank_proof" type="file" class="" aria-required="true" required="" accept="image/*">
                                    </div>
                                </div>
                                <div class="form-group ">
                                    <div class="label-floating">
                                        <label class="control-label block">{{trans('custom.upl_mt4with_proof3')}} <small>(*)</small></label>
                                        <input name="mt4with_proof" id="mt4with_proof" type="file" class="" aria-required="true" required="" accept="image/*">
                                    </div>
                                </div>
                                <div class="form-group ">
                                    <div class="from-inner-space text-left">
                                    <label for="captcha" class="bmd-label-static block">{{ trans('custom.captcha') }}</label>
                                        <div class="form-group">
                                            <div class="captacha-img">
                                                {!! Captcha_img('flat') !!}
                                            </div>
                                            <button type="button" class="btn btn-primary" title="{{trans('custom.refresh')}}"><i class="fa fa-refresh" id="refresh-captcah"></i></button>
                                        </div>
                                        <input id="captcha" type="text" autocomplete="off" class="form-control " placeholder="{{trans('custom.enter_captcha')}}" name="captcha">
                                        @if($errors->first('captcha'))
                                        <div class="alert alert-danger alert-dismissable">
                                            {{ $errors->first('captcha') }}
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>  
                            <div class="col-sm-6 text-left">
                                <h4>{{trans('custom.instructions')}}</h4>
                                <p>{{trans('custom.instructions_mt4_upload_desc')}}</p>
                                <a target="_blank" href="{{asset('terms/mt4-withdrawal.pdf')}}" class="btn cus-width-auto cus-btn cus-btnbg-red">{{trans('custom.download')}}</a>
                            </div>
                        </div>
                    </fieldset>
                {{ Form::close() }}
            </div>
        </div>
    </div>
  </div>
</div>