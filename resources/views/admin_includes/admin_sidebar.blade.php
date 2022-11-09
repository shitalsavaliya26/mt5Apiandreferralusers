<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item">
            <a class="nav-link" href="{{route('admin.dashboard')}}">
                <i class="ti-home menu-icon"></i>
                <span class="menu-title">Dashboard</span>
            </a>
        </li>

        <li class="nav-item">
            @can('manage_users')
            <a class="nav-link" href="#ui-funding" data-toggle="collapse" aria-expanded="false">
                <i class="ti-user menu-icon"></i>
                <span class="menu-title">Users</span>
                <i class="menu-arrow"></i>
            </a>
            @endcan
            <div class="collapse" id="ui-funding">
                <ul class="nav flex-column sub-menu">
                    @can('manage_all_users')
                        <li class="nav-item"><a class="nav-link" href="{{route('admin.users')}}">Users</a></li>
                    @endcan
                    @can('manage_support')
                        <li class="nav-item"><a class="nav-link" href="{{route('admin-supports')}}">Support</a></li>
                    @endcan
                    @can('manage_roles')
                        <li class="nav-item"><a class="nav-link" href="{{route('roles.index')}}">Roles</a></li>
                    @endcan
                    @can('manage_staff_users')
                        <li class="nav-item"><a class="nav-link" href="{{route('staff-users.index')}}">Staff Users</a>
                        </li>
                    @endcan
                </ul>
            </div>
        </li>
        <li class="nav-item">
            @can('manage_wallet')
            <a class="nav-link" href="#ui-wallet" data-toggle="collapse" aria-expanded="false">
                <i class="ti-money menu-icon"></i>
                <span class="menu-title">Wallet</span>
                <i class="menu-arrow"></i>
            </a>
            @endcan
            <div class="collapse" id="ui-wallet">
                <ul class="nav flex-column sub-menu">
                    @can('manage_ownership')
                        <li class="nav-item"><a class="nav-link" href="{{route('capital-withdraw.index')}}">Capital Withdraw
                                Request</a></li>
                    @endcan

                    @can('manage_credit_request')
                        <li class="nav-item"><a class="nav-link" href="{{route('get-topup-request')}}">Bank Credit
                                Request</a></li>
                    @endcan

                    @can('manage_withdraw_request')

                        <li class="nav-item"><a class="nav-link" href="{{route('get-withdraw-request')}}">Withdraw
                                Request</a></li>
                    @endcan
                    @can('manage_trading_profits')
                        <li class="nav-item"><a class="nav-link" href="{{route('admin.trading_profit.index')}}">Trading
                                Profit</a></li>
                    @endcan
                        @can('manage_ownership')
                            <!-- <li class="nav-item"><a class="nav-link" href="{{route('admin.ownership.index')}}">Ownership
                                    Profit</a></li> -->
                        @endcan
                </ul>
            </div>
        </li>
        @role('admin')
        <li class="nav-item">
            <a class="nav-link" href="#ui-share-holder" data-toggle="collapse" aria-expanded="false">
                <i class="ti-pie-chart menu-icon"></i>
                <span class="menu-title">ShareHolder Report</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-share-holder">
                <ul class="nav flex-column sub-menu">
                        <li class="nav-item"><a class="nav-link" href="{{route('share-holder.index')}}">ShareHolder List</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{route('share-holder.earning')}}">Income Report</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{route('share-holder.profit')}}">ShareHolder Trading Profit</a></li>
                </ul>
            </div>
        </li>
        @endrole
        <li class="nav-item">
            <a class="nav-link" href="{{route('admin-all-reports')}}">
                <i class="ti-bar-chart menu-icon"></i>
                <span class="menu-title">Reports</span>
            </a>
        </li>
        @can('manage_ranks')
            <li class="nav-item">
                <a class="nav-link" href="{{route('ranks.index')}}">
                    <i class="ti-palette menu-icon"></i>
                    <span class="menu-title">Ranks</span>
                </a>
            </li>
        @endcan
        {{--<li class="nav-item">
            <a class="nav-link" href="{{route('packages.index')}}">
                <i class="ti-view-list menu-icon"></i>
                <span class="menu-title">Packages</span>
            </a>
        </li>--}}
        @can('manage_news')
            <li class="nav-item">
                <a class="nav-link" href="{{route('news.index')}}" aria-expanded="false" aria-controls="form-elements">
                    <i class="ti-blackboard  menu-icon"></i>
                    <span class="menu-title">News</span>
                </a>
            </li>
        @endcan
        @can('manage_cms')
           <!--  <li class="nav-item">
                <a class="nav-link" href="{{route('cms.index')}}">
                    <i class="ti-eraser menu-icon"></i>
                    <span class="menu-title">CMS</span>
                </a>
            </li> -->
        @endcan
        @can('manage_traders')
            <li class="nav-item">
                <a class="nav-link" href="{{route('traders.index')}}">
                    <i class="ti-id-badge menu-icon"></i>
                    <span class="menu-title">Traders</span>
                </a>
            </li>
        
            <li class="nav-item">
                <a class="nav-link" href="{{route('traders-history')}}">
                    <i class="ti-layout-accordion-merged menu-icon"></i>
                    <span class="menu-title">Traders History</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('trader_report')}}">
                    <i class="ti-align-justify menu-icon"></i>
                    <span class="menu-title">Traders Report</span>
                </a>
            </li>
            @endcan
        @can('manage_settings')
            {{--<li class="nav-item">
                <a class="nav-link" href="{{route('admin-supports')}}">
                    <i class="ti-comment menu-icon"></i>
                    <span class="menu-title">Supports</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#tables" aria-expanded="false" aria-controls="tables">
                    <i class="ti-layout menu-icon"></i>
                    <span class="menu-title">FAQ</span>
                </a>
            </li>--}}

            <li class="nav-item">
                <a class="nav-link" href="{{route('settings')}}">
                    <i class="ti-settings menu-icon"></i>
                    <span class="menu-title">Settings</span>
                </a>
            </li>
        @endcan
        @can('manage_report')
            <li class="nav-item">
                <a class="nav-link" href="{{route('payout-report')}}">
                    <i class="ti-list menu-icon"></i>
                    <span class="menu-title">Payout Report</span>
                </a>
            </li>
        @endcan
    </ul>
</nav>
