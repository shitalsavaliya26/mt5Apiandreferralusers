<nav class="sidebar sidebar-offcanvas pt-3 pt-lg-5 pb-3 pb-lg-3" id="sidebar">
    <img src="{{asset('/images/logo-v2.png')}}" alt="image" class="img-fluid logov2">
    <div class="hrline"></div>
    <ul class="nav">
        <li class="nav-item">
            <a class="nav-link" href="{{route('home')}}">
                <i class="ti-layout-grid2 menu-icon"></i>
                <span class="menu-title">@lang('sidebar.dashboard')</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{route('my-profile')}}">
                <i class="ti-user menu-icon"></i>
                <span class="menu-title">@lang('sidebar.my_profile')</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{route('network-tree')}}">
                <i class="ti-bar-chart-alt menu-icon"></i>
                <span class="menu-title">@lang('sidebar.network_tree')</span>
            </a>
        </li>
        @if(auth()->user()->userwallet!== null && auth()->user()->userwallet->topup_fund > 0 || @$previousFunding != 0)
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#ui-funding" aria-expanded="false" aria-controls="ui-funding">
                <i class="fa fa-money menu-icon"></i>
                <span class="menu-title">@lang('sidebar.funding')</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-funding">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="{{route('getTopupFunds')}}">@lang('sidebar.funding')</a></li>
                    
                        <li class="nav-item"> <a class="nav-link" href="{{route('choose-traders')}}">@lang('sidebar.choose_traders')</a></li>
                    
                </ul>
            </div>
        </li>
        @else
        <li class="nav-item">
            <a class="nav-link" href="{{route('getTopupFunds')}}">
                <i class="fa fa-money menu-icon"></i>
                <span class="menu-title">@lang('sidebar.funding')</span>
            </a>
        </li>
        @endif
        @if(auth()->user()->userwallet!== null && auth()->user()->userwallet->topup_fund > 0 || @$previousFunding != 0)
        <li class="nav-item">
            <a class="nav-link" href="{{route('withdraw-request-form')}}">
                <i class="ti-bar-chart menu-icon"></i>
                <span class="menu-title">@lang('sidebar.earnings')</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{route('capital-withdrawal.index')}}">
                <i class="ti-pulse menu-icon"></i>
                <span class="menu-title">@lang('sidebar.capital_withdrawal')</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
                <i class="fa fa-money menu-icon"></i>
                <span class="menu-title">@lang('sidebar.report')</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-basic">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"><a class="nav-link" href="{{route('trading-profit')}}">@lang('sidebar.trading_profit')</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{route('unilevel')}}">@lang('sidebar.unilevel')</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{route('profit-sharing')}}">@lang('sidebar.profit_sharing')</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{route('leadership-bonus')}}">@lang('sidebar.leadership_bonus')</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{route('ownership-bonus')}}">@lang('sidebar.ownership_bonus')</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{route('total-report')}}">@lang('sidebar.total')</a></li>
                </ul>
            </div>
        </li>
        @endif
        <li class="nav-item">
            <a class="nav-link" href="{{route('news.all')}}">
                <i class="fa fa-newspaper-o menu-icon"></i>
                <span class="menu-title">@lang('sidebar.news')</span>
            </a>
        </li>

       <!--  <li class="nav-item">
            <a class="nav-link" href="{{route('cms.all')}}">
                <i class="fa fa-area-chart menu-icon"></i>
                <span class="menu-title">CMS</span>
            </a>
        </li> -->

        <li class="nav-item">
            <a class="nav-link" href="{{route('faq')}}">
                <i class="fa fa-question-circle menu-icon"></i>
                <span class="menu-title">@lang('sidebar.faq')</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{route('supports')}}">
                <i class="fa fa-user-md menu-icon"></i>
                <span class="menu-title">@lang('sidebar.support')</span>
            </a>
        </li>
    </ul>
    <div class="logoutbtndiv d-block">
        <a class="logoutbtn d-block" href="{{ route('logout') }}"
           onclick="event.preventDefault();document.getElementById('logout-form').submit();">
            @lang('sidebar.logout')</a>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </div>
</nav>
