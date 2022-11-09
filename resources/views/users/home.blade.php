@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<style>
    @media (max-width: 350px) and (min-width: 300px)
    {
       .card-row .card-body {
        margin-bottom: 10px !important;
        margin-top: 10px !important;
        margin-left: 5px !important;
        margin-right: 10px !important;
        padding: 0px !important;
    }
}
</style>
    <header class="section-title titlebottomline mt-4">
        <h2 class="hrowheading" style="font-size: 18pt;">@lang('dashboard.welcome_message'), {{auth::user()->user_name}}
            .</h2>
    </header>
    <!-- Slider Ends -->
    <div class="d-block mt-5"></div>
    <!-- Four Blocks Starts -->
    <div class="row fourblocks">
        <div class="col-md-3 grid-margin grid-margin-md-0 stretch-card">
            <div class="card cardhoverable active">
                <div class="card-body">
                    <p class="card-title text-md-center text-xl-left regbultertext">@lang('dashboard.current_rank')</p>
                    <div
                        class="d-flex flex-wrap justify-content-between justify-content-md-center justify-content-xl-between align-items-center">
                        <h3 class="mb-0 mb-md-2 mb-xl-0 order-md-1 order-xl-0 text-uppercase">{{auth::user()->rank->name}}</h3>
                        <i class="fa fa-diamond icon-md text-muted mb-0 mb-md-3 mb-xl-0"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 grid-margin grid-margin-md-0 stretch-card">
            <div class="card cardhoverable">
                <div class="card-body">
                    <p class="card-title text-md-center text-xl-left regbultertext">@lang('dashboard.total_direct_downline')</p>
                    <div
                        class="d-flex flex-wrap justify-content-between justify-content-md-center justify-content-xl-between align-items-center">
                        <h3 class="mb-0 mb-md-2 mb-xl-0 order-md-1 order-xl-0">{{isset($directDownline) ? count($directDownline): 0}}</h3>
                        <i class="ti-user icon-md text-muted mb-0 mb-md-3 mb-xl-0"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 grid-margin grid-margin-md-0 stretch-card">
            <div class="card cardhoverable">
                <div class="card-body">
                    <p class="card-title text-md-center text-xl-left regbultertext">@lang('dashboard.personal_investment')</p>
                    <div
                        class="d-flex flex-wrap justify-content-between justify-content-md-center justify-content-xl-between align-items-center">
                        <h3 class="mb-0 mb-md-2 mb-xl-0 order-md-1 order-xl-0">{{isset($UserWallet->topup_fund) ? $UserWallet->topup_fund : 0}}</h3>
                        <i class="ti-agenda icon-md text-muted mb-0 mb-md-3 mb-xl-0"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 stretch-card">
            <div class="card cardhoverable">
                <div class="card-body">
                    <p class="card-title text-md-center text-xl-left regbultertext">@lang('dashboard.total_downlines')</p>
                    <div
                        class="d-flex flex-wrap justify-content-between justify-content-md-center justify-content-xl-between align-items-center">
                        <h3 class="mb-0 mb-md-2 mb-xl-0 order-md-1 order-xl-0">{{isset($totalDownlines) ? $totalDownlines : 0}}</h3>
                        <i class="ti-layers-alt icon-md text-muted mb-0 mb-md-3 mb-xl-0"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Four Blocks Ends -->

    <div class="d-block mt-30"></div>

    <!-- Progress Blocks Starts -->
    @if(!empty($nextRank))
        <div class="stretch-card grid-margin grid-margin-md-0">
            <div class="card">
                <div class="card-body">
                    <p class="card-title boldbultertext">@lang('dashboard.criteria_to_next_ranking') <b>({{$nextRank->name}})</b></p>
                        @php                            
                            if(isset($nextRank->direct_downline) && $nextRank->direct_downline > 0){
                                $rank1 = isset($directDownline) ? (count($directDownline) * 100) / $nextRank->direct_downline : '0';
                            }else{
                                $rank1 = 0;
                            }

                            if(isset($nextRank->direct_sale) && $nextRank->direct_sale > 0){
                                $rank2 = isset($UserWallet->topup_fund) ? ($UserWallet->topup_fund * 100) / $nextRank->direct_sale : '0';
                            }else{
                                $rank2 = 0;
                            }

                            if(isset($nextRank->downline_sales) && $nextRank->downline_sales > 0){
                                $rank3 = isset($totalFund) ? ($totalFund * 100) / $nextRank->downline_sales : '0';
                            }else{
                                $rank3 = 0;
                            }
                        @endphp

                    <div class="d-flex align-items-center justify-content-between1 flex-wrap ">
                        @if(isset($nextRank->direct_downline) && $nextRank->direct_downline > 0)
                        <div class="col-md-4 border-right pr-md-4 mb-4 mb-md-0 text-center">
                            <p class="regbultertext text-white ranktitle"
                               style="font-size: 18pt">@lang('dashboard.total_direct_downline')
                            </p>
                            <div class="progress progress-lg progress-rounded mt-3">
                                <div class="progress-bar bg-success-dark" role="progressbar" style="width:{{$rank1}}%"
                                     aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <h4 class="mb-0 mt-3 lightbultertext text-white">
                                {{ isset($directDownline) ? count($directDownline) : 0}}/<span
                                    class="boldbultertext">{{isset($nextRank) ? $nextRank->direct_downline : 0}}</span>
                            </h4>
                        </div>
                        @endif
                        @if(isset($nextRank->direct_sale) && $nextRank->direct_sale > 0)
                        <div class="col-md-4 border-right pr-md-4 mb-4 mb-md-0 text-center">
                            <p class="regbultertext text-white ranktitle"
                               style="font-size: 18pt">@lang('dashboard.personal_investment')</p>

                            <div class="progress progress-lg progress-rounded mt-3">
                                <div class="progress-bar bg-primary-dark" role="progressbar" style="width:{{$rank2}}%"
                                     aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <h4 class="mb-0 mt-3 lightbultertext text-white">
                                {{isset($UserWallet->topup_fund) ? $UserWallet->topup_fund : 0}}/<span
                                    class="boldbultertext">{{isset($nextRank) ? $nextRank->direct_sale : 0}}</span>
                            </h4>
                        </div>
                        @endif
                        @if(isset($nextRank->downline_sales) && $nextRank->downline_sales > 0)
                        <div class="col-md-4 pr-md-4 mb-md-0 text-center">
                            <p class="regbultertext text-white ranktitle"
                               style="font-size: 18pt">@lang('dashboard.group_investment')</p>
                            <div class="progress progress-lg progress-rounded mt-3">
                                <div class="progress-bar bg-pink-dark" role="progressbar" style="width:{{$rank3}}%"
                                     aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <h4 class="mb-0 mt-3 lightbultertext text-white">{{isset($totalFund) ? $totalFund : 0}}/<span
                                    class="boldbultertext">{{isset($nextRank) ? $nextRank->downline_sales : 0}}</span>
                            </h4>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif
    <!-- Progress Blocks Ends -->

    <div class="d-block mt-30"></div>

    <!-- Performance Overview Starts -->
    <div class="row">
        <div class="col-md-12">
            <div class="card bg-primary border-0 position-relative">
                <div class="card-body">
                    <p class="card-title text-white">@lang('dashboard.perfomance_oview')</p>
                    <div id="performanceOverview"
                         class="carousel slide performance-overview-carousel position-static pt-2" data-ride="carousel">
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <div class="row">
                                    <div class="col-md-4 item">
                                        <div class="d-flex flex-column flex-xl-row mt-4 mt-md-0">
                                            <!-- <div class="icon icon-a text-white mr-3">
                                                <i class="ti-cup icon-lg ml-3"></i>
                                            </div> -->
                                            <div class="content text-white">
                                                <div class="d-flex flex-wrap align-items-center mb-2 mt-3 mt-xl-1">
                                                    <h3 class="regbultertext mr-2 mb-1 w-100"
                                                        style="font-size: 18pt">@lang('sidebar.trading_profit')</h3>
                                                    <br><h3 class="mb-0 boldbultertext" style="font-size: 18pt">
                                                        IDR  {{isset($tradingProfit) ? $tradingProfit : '0'}}</h3>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 item">
                                        <div class="d-flex flex-column flex-xl-row mt-5 mt-md-0">
                                            <!-- <div class="icon icon-b text-white mr-3">
                                                <i class="ti-bar-chart icon-lg ml-3"></i>
                                            </div> -->
                                            <div class="content text-white">
                                                <div class="d-flex flex-wrap align-items-center mb-2 mt-3 mt-xl-1">
                                                    <h3 class="regbultertext mr-2 mb-1 w-100"
                                                        style="font-size: 18pt">@lang('sidebar.unilevel')</h3>
                                                    <br><h3 class="mb-0 boldbultertext" style="font-size: 18pt">
                                                        IDR  {{isset($unilevel) ? $unilevel : '0'}}</h3>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 item">
                                        <div class="d-flex flex-column flex-xl-row mt-5 mt-md-0">
                                            <!-- <div class="icon icon-c text-white mr-3">
                                                <i class="ti-shopping-cart-full icon-lg ml-3"></i>
                                            </div> -->
                                            <div class="content text-white">
                                                <div class="d-flex flex-wrap align-items-center mb-2 mt-3 mt-xl-1">
                                                    <h3 class="regbultertext mr-2 mb-1 w-100"
                                                        style="font-size: 18pt">@lang('sidebar.leadership_bonus')</h3>
                                                    <br><h3 class="mb-0 boldbultertext" style="font-size: 18pt">
                                                        IDR  {{isset($leadershipBonus) ? $leadershipBonus : 0}}</h3>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <div class="row">
                                    <div class="col-md-4 item">
                                        <div class="d-flex flex-column flex-xl-row mt-4 mt-md-0">
                                            <!-- <div class="icon icon-a text-white mr-3">
                                                <i class="ti-cup icon-lg ml-3"></i>
                                            </div> -->
                                            <div class="content text-white">
                                                <div class="d-flex flex-wrap align-items-center mb-2 mt-3 mt-xl-1">
                                                    <h3 class="regbultertext mr-2 mb-1 w-100"
                                                        style="font-size: 18pt">@lang('sidebar.profit_sharing')</h3>
                                                    <br><h3 class="mb-0 boldbultertext" style="font-size: 18pt">
                                                        IDR  {{isset($profitSharing) ? $profitSharing : 0}}</h3>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 item">
                                        <div class="d-flex flex-column flex-xl-row mt-5 mt-md-0">
                                            <!-- <div class="icon icon-b text-white mr-3">
                                                <i class="ti-bar-chart icon-lg ml-3"></i>
                                            </div> -->
                                            <div class="content text-white">
                                                <div class="d-flex flex-wrap align-items-center mb-2 mt-3 mt-xl-1">
                                                    <h3 class="regbultertext mr-2 mb-1 w-100"
                                                        style="font-size: 18pt">@lang('sidebar.trading_profit')</h3>
                                                    <br><h3 class="mb-0 boldbultertext" style="font-size: 18pt">
                                                        IDR  {{isset($tradingProfit) ? $tradingProfit : 0}}</h3>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 item">
                                        <div class="d-flex flex-column flex-xl-row mt-5 mt-md-0">
                                            <!-- <div class="icon icon-c text-white mr-3">
                                                <i class="ti-shopping-cart-full icon-lg ml-3"></i>
                                            </div> -->
                                            <div class="content text-white">
                                                <div class="d-flex flex-wrap align-items-center mb-2 mt-3 mt-xl-1">
                                                    <h3 class="regbultertext mr-2 mb-1 w-100"
                                                        style="font-size: 18pt">@lang('sidebar.unilevel')</h3>
                                                    <br><h3 class="mb-0 boldbultertext" style="font-size: 18pt">
                                                        IDR  {{isset($unilevel) ? $unilevel : 0}}</h3>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <a class="carousel-control-prev" href="#performanceOverview" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#performanceOverview" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Performance Overview Ends -->

    <div class="d-block mt-30"></div>

    <!-- Total Sales And Downline Starts -->
    <div class="row card-row">
        <div class="col-md-6 grid-margin grid-margin-md-0 stretch-card">
            <div class="card">
                <div class="card-body personal-profit">
                    <p class="card-title boldbultertext">@lang('dashboard.total_sales')</p>
                    
                    <canvas id="order-chart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6 stretch-card">
            <div class="card">
                <div class="card-body">
                    <p class="card-title boldbultertext">@lang('dashboard.total_personal_sales')</p>
                    <div id="sales-legend" class="chartjs-legend mt-4 mb-2"></div>
                    <canvas id="sales-chart"></canvas>
                </div>
            </div>
        </div>
    </div>
    <!-- Total Sales And Downline Ends -->

    <div class="d-block mt-5"></div>

    <!-- News & Events Starts -->
    <header class="section-title titlebottomline">
        <h2 class="hrowheading mobwidth">@lang('dashboard.news_events')</h2>
        <a href="{{route('news.all')}}" class="btn btn-primary pull-right"> @lang('dashboard.see_all')</a>
    </header>
    <div class="card-columns">
        @if($news)
            @foreach($news as $n)
                <div class="card">

                    <img class="card-img-top" src="{{asset('news_images')}}/{{$n->image}}" height="150"
                         width="150" alt="">
                    <div class="card-body">
                        <h4 class="card-title mt-3 boldbultertext">{{$n->title}}</h4>
                        <p class="card-text"><?php echo $n->details; ?></p>
                    </div>

                </div>
            @endforeach
        @else
            @lang('general.no_record')
        @endif
    </div>
    <div class="modal fade bs-example-modal-center" tabindex="-1" role="dialog" aria-labelledby="points-alert" aria-hidden="true" style="display: none;" id="points_alert">
        <div class="modal-dialog buyp modal-dialog-centered">
            <div class="modal-content  text-white">
                <div class="modal-header">
                    <h5 class="modal-title mt-0"><span class="mdi mdi-alert"></span> {{trans('dashboard.notice')}}!</h5>
                </div>
                <div class="modal-body">
                    <div class="font-16">
                        {!!trans('dashboard.choose_trader_message') !!}
                           <a href="{{route('choose-traders')}}" class="mtext-cred">{{trans('dashboard.click_to_choose_trader')}}</a>
                    </div>
                    
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
@endsection
@section('page_js')
@if(isset($showPopup) && $showPopup == 1)
<script type="text/javascript">
    $(document).ready(function(){
        $('#points_alert').modal({backdrop: 'static', keyboard: false});
        $('#points_alert').modal('show');
    })
</script>
@endif
<script>
var maxHeight = Math.max.apply(null, $(".card-columns .card").map(function (){
    return $(this).height();
}).get());
$(".card-columns .card").css('height', maxHeight);
</script>
@endsection
