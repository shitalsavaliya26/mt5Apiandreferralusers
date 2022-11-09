@extends('layouts.app')
@section('title', 'FAQ')

@section('content')
    <div class="d-block mt-30"></div>

    <div class="text-white text-center w-100 medimagebgdiv" style="background-image: url(./images/faq-banner.png)">
        <h3 class="m-0 boldbultertext">@lang('faq.faq')</h3>
    </div>

    <div class="d-block mt-5"></div>

    <div class="row mb-3">
        <div class="col-12">
            <p>@lang('faq.note')<a href="mailto:">contact@avanya.net</a>
                @lang('faq.call') <a href="tel:+62818-0616-1481">+62XXXXXXX</a></p>
        </div>
    </div>

    <div class="cardbg">
        <div class="row">
            <div class="col-12 col-xl-6">
                <div class="faq-section">                    
                    <div id="accordion-1" class="accordion">
                        <div class="card">
                            <div class="card-header" id="heading-bb1">
                                <h5 class="mb-0">
                                    <a data-toggle="collapse" data-target="#collapse-bb1"
                                       aria-controls="collapse-bb1" class="collapsed" aria-expanded="false">
                                       @lang('faq.broker')
                                    </a>
                                </h5>
                            </div>
                            <div id="collapse-bb1" class="collapse"
                                 aria-labelledby="heading-bb1"
                                 data-parent="#accordion-1">
                                <div class="card-body">
                                    @lang('faq.broker_quetion')
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-xl-6">
                <div class="faq-section">                    
                    <div id="accordion-1" class="accordion">
                        <div class="card">
                            <div class="card-header" id="heading-fund_deposit">
                                <h5 class="mb-0">
                                    <a data-toggle="collapse" data-target="#collapse-fund_deposit"
                                       aria-controls="collapse-fund_deposit" class="collapsed" aria-expanded="false">
                                       @lang('faq.fund_deposit')
                                    </a>
                                </h5>
                            </div>
                            <div id="collapse-fund_deposit" class="collapse"
                                 aria-labelledby="heading-bb1"
                                 data-parent="#accordion-1">
                                <div class="card-body">
                                    @lang('faq.fund_deposit_que')
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-xl-6">
                <div class="faq-section">                    
                    <div id="accordion-1" class="accordion">
                        <div class="card">
                            <div class="card-header" id="heading-withdraw_fund">
                                <h5 class="mb-0">
                                    <a data-toggle="collapse" data-target="#collapse-withdraw_fund"
                                       aria-controls="collapse-withdraw_fund" class="collapsed" aria-expanded="false">
                                       @lang('faq.withdraw_fund')
                                    </a>
                                </h5>
                            </div>
                            <div id="collapse-withdraw_fund" class="collapse"
                                 aria-labelledby="heading-bb1"
                                 data-parent="#accordion-1">
                                <div class="card-body">
                                    @lang('faq.withdrawing_que')
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-xl-6">
                <div class="faq-section">                    
                    <div id="accordion-1" class="accordion">
                        <div class="card">
                            <div class="card-header" id="heading-trader">
                                <h5 class="mb-0">
                                    <a data-toggle="collapse" data-target="#collapse-trader"
                                       aria-controls="collapse-trader" class="collapsed" aria-expanded="false">
                                       @lang('faq.trader')
                                    </a>
                                </h5>
                            </div>
                            <div id="collapse-trader" class="collapse"
                                 aria-labelledby="heading-bb1"
                                 data-parent="#accordion-1">
                                <div class="card-body">
                                    @lang('faq.trader_que')
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-xl-6">
                <div class="faq-section">                    
                    <div id="accordion-1" class="accordion">
                        <div class="card">
                            <div class="card-header" id="heading-register">
                                <h5 class="mb-0">
                                    <a data-toggle="collapse" data-target="#collapse-register"
                                       aria-controls="collapse-register" class="collapsed" aria-expanded="false">
                                       @lang('faq.register')
                                    </a>
                                </h5>
                            </div>
                            <div id="collapse-register" class="collapse"
                                 aria-labelledby="heading-bb1"
                                 data-parent="#accordion-1">
                                <div class="card-body">
                                    @lang('faq.register_que')
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-xl-6">
                <div class="faq-section">                    
                    <div id="accordion-1" class="accordion">
                        <div class="card">
                            <div class="card-header" id="heading-trading">
                                <h5 class="mb-0">
                                    <a data-toggle="collapse" data-target="#collapse-trading"
                                       aria-controls="collapse-trading" class="collapsed" aria-expanded="false">
                                       @lang('faq.trading')
                                    </a>
                                </h5>
                            </div>
                            <div id="collapse-trading" class="collapse"
                                 aria-labelledby="heading-bb1"
                                 data-parent="#accordion-1">
                                <div class="card-body">
                                    @lang('faq.trading_que')
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-xl-6">
                <div class="faq-section">                    
                    <div id="accordion-1" class="accordion">
                        <div class="card">
                            <div class="card-header" id="heading-become_trader">
                                <h5 class="mb-0">
                                    <a data-toggle="collapse" data-target="#collapse-become_trader"
                                       aria-controls="collapse-become_trader" class="collapsed" aria-expanded="false">
                                       @lang('faq.become_trader')
                                    </a>
                                </h5>
                            </div>
                            <div id="collapse-become_trader" class="collapse"
                                 aria-labelledby="heading-bb1"
                                 data-parent="#accordion-1">
                                <div class="card-body">
                                    @lang('faq.become_trader_que')
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection
