
    <!-- partial:../../partials/_navbar.html -->
    <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
        <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
            <!------------------------changes add logo-->
            <a class="navbar-brand brand-logo" href="{{route('admin.dashboard')}}">
                <img src="{{asset('images/logo.png')}}" style="height:auto;" width="100%" class="" alt="logo"/>
            </a>
        </div>
        <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">

            <ul class="navbar-nav navbar-nav-right">
                
                <li class="nav-item dropdown">
                    <a class="nav-link count-indicator dropdown-toggle notification" id="notificationDropdown" href="#" data-toggle="dropdown">
                        <i class="ti-bell mx-0"></i>
                        <span class="badge">{{ isset($supportUnreadCount) ? ($supportUnreadCount) : 0 }}</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="notificationDropdown">
                        <p class="mb-0 font-weight-normal float-left dropdown-header">Notifications</p>
                        
                        @if(isset($supportTicket) && count($supportTicket) > 0)
                            @foreach($supportTicket as $val)
                                <a class="dropdown-item preview-item" href="{{route('admin-supports')}}">
                                    <div class="preview-thumbnail">
                                        <div class="preview-icon bg-success">
                                            <i class="ti-info-alt mx-0" style="color:red;"></i>
                                        </div>
                                    </div>
                                    <div class="preview-item-content" onclick="{{route('reply-tickets',[$val->support_id])}}">
                                        <h6 class="preview-subject" style="color:#b1b1b5;">{{$val->user->user_name}}</h6>
                                        <p class="font-weight-light small-text mb-0 text-muted">{{str_limit(@$val->support->titles->title,40)}}</p>
                                        <p class="font-weight-light small-text mb-0 text-muted">
                                            {{str_limit($val->messages,40)}}
                                        </p>
                                    </div>
                                </a>
                            @endforeach
                        @endif
                        <!-- <a class="dropdown-item preview-item" href="#" onMouseOver="this.style.color='#b1b1b5'">
                            <div class="preview-thumbnail">
                                <div class="preview-icon bg-warning">
                                    <i class="ti-settings mx-0"></i>
                                </div>
                            </div>
                            <div class="preview-item-content">
                                <h6 class="preview-subject font-weight-normal">Settings</h6>
                                <p class="font-weight-light small-text mb-0 text-muted">
                                    Private message
                                </p>
                            </div>
                        </a>
                        <a class="dropdown-item preview-item" href="#" onMouseOver="this.style.color='#b1b1b5'">
                            <div class="preview-thumbnail">
                                <div class="preview-icon bg-info">
                                    <i class="ti-user mx-0"></i>
                                </div>
                            </div>
                            <div class="preview-item-content">
                                <h6 class="preview-subject font-weight-normal">New user registration</h6>
                                <p class="font-weight-light small-text mb-0 text-muted">
                                    2 days ago
                                </p>
                            </div>
                        </a> -->
                    </div>
                </li>
                <li class="nav-item nav-profile dropdown">
                    <a class="nav-link" href="#" data-toggle="dropdown" id="profileDropdown">
                        <img src="{{asset('images/demo/default-user.jpg')}}" alt="profile"/>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
                        <a class="dropdown-item" href="{{route('settings')}}" onMouseOver="this.style.color='#b1b1b5'">
                            <i class="ti-settings text-primary"></i>
                            Settings
                        </a>
                        <a class="dropdown-item"  href="{{ route('admin_logout') }}"   onMouseOver="this.style.color='#b1b1b5'" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                            <i class="ti-power-off text-primary"></i>Logout
                        </a>
                        <form id="logout-form" action="{{ route('admin_logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
    <!-- partial -->