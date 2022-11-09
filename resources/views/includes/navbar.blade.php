<nav class="navbar col-lg-12 col-12 p-0 fixed-top1 d-flex1 flex-row1">
    <div class="navbar-brand-wrapper d-flex align-items-center justify-content-center">
    </div>
    <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
<button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
            <span class="ti-layout-grid2"></span>
        </button>       
       <ul class="navbar-nav ml-auto">
            <!-- Authentication Links -->
            <li class="nav-item dropdown">
                @php $locale = session()->get('locale'); @endphp
                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        <span class="caret">
                         @switch($locale)
                                @case('id')
                                <i class="flag-icon flag-icon-id" title="id" id="id"></i>Indonesian
                                @break
                                @default
                                <i class="flag-icon flag-icon-us" title="us" id="us"></i>English
                            @endswitch
                        </span>
                </a>
                <div class="dropdown-menu dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="{{url('lang/en')}}"><i
                            class="flag-icon flag-icon-us" title="us" id="us"></i> &nbsp;English</a>
                    <a class="dropdown-item" href="{{url('lang/id')}}">
                        <i class="flag-icon flag-icon-id" title="od" id="id"></i> &nbsp;Indonesian</a>
                </div>
            </li>
        </ul>

        <ul class="navbar-nav navbar-nav-right">
            
            <!-- <li class="nav-item dropdown mr-1">
                <a class="nav-link count-indicator dropdown-toggle d-flex justify-content-center align-items-center" id="messageDropdown" href="#" data-toggle="dropdown">
                    <i class="ti-email mx-0"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="messageDropdown">
                    <p class="mb-0 font-weight-normal float-left dropdown-header">Messages</p>
                    <a class="dropdown-item preview-item">
                        <div class="preview-thumbnail">
                            <img src="https://via.placeholder.com/36x36" alt="image" class="profile-pic">
                        </div>
                        <div class="preview-item-content flex-grow">
                            <h6 class="preview-subject ellipsis">David Grey
                            </h6>
                            <p class="font-weight-light small-text text-muted mb-0">
                                The meeting is cancelled
                            </p>
                        </div>
                    </a>
                    <a class="dropdown-item preview-item">
                        <div class="preview-thumbnail">
                            <img src="https://via.placeholder.com/36x36" alt="image" class="profile-pic">
                        </div>
                        <div class="preview-item-content flex-grow">
                            <h6 class="preview-subject ellipsis">Tim Cook
                            </h6>
                            <p class="font-weight-light small-text text-muted mb-0">
                                New product launch
                            </p>
                        </div>
                    </a>
                    <a class="dropdown-item preview-item">
                        <div class="preview-thumbnail">
                            <img src="https://via.placeholder.com/36x36" alt="image" class="profile-pic">
                        </div>
                        <div class="preview-item-content flex-grow">
                            <h6 class="preview-subject ellipsis"> Johnson
                            </h6>
                            <p class="font-weight-light small-text text-muted mb-0">
                                Upcoming board meeting
                            </p>
                        </div>
                    </a>
                </div>
            </li> -->
            
            <li class="nav-item dropdown">
                <a class="nav-link count-indicator dropdown-toggle notification" id="notificationDropdown" href="#" data-toggle="dropdown">
                <!-- <a class="nav-link count-indicator notification" id="notificationDropdown" href="#" > -->
                    <i class="ti-bell mx-0"></i>
                    <span class="badge">{{ isset($supportUnreadCount) ? ($supportUnreadCount) : 0 }}</span>
                </a>

                <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="notificationDropdown">
                    <p class="mb-0 font-weight-normal float-left dropdown-header">Notifications</p>

                    @if(isset($supportTicket) && count($supportTicket) > 0)
                        @foreach($supportTicket as $val)
                             @php $supportId = encrypt($val->support_id) @endphp
                            <div class="dropdown-item preview-item" onclick="window.location.href='{{url('reply-tickets')}}/{{$supportId}}'">
                                <div class="preview-thumbnail">
                                    <div class="preview-icon bg-success">
                                        <i class="ti-info-alt mx-0" style="color:red;"></i>
                                    </div>
                                </div>
                                <div class="preview-item-content">
                                    <h6 class="preview-subject" style="color: #b1b1b5;">{{str_limit(@$val->support->titles->title,40)}}</h6>
                                    <p class="text-white">{{str_limit($val->messages,40)}}</p>
                                </div>
                            </div>
                        @endforeach
                    @else
                    <a class="dropdown-item preview-item">
                        <h6 class="preview-subject" style="color: #b1b1b5;">No Notification available</h6>
                    </a>
                    @endif

                   <!--  <a class="dropdown-item preview-item">
                        <div class="preview-thumbnail">
                            <div class="preview-icon bg-warning">
                                <i class="ti-settings mx-0"></i>
                            </div>
                        </div>
                        <div class="preview-item-content">
                            <h6 class="preview-subject">Settings</h6>
                            <p class="font-weight-light small-text mb-0 text-muted">
                                Private message
                            </p>
                        </div>
                    </a>
                
                    <a class="dropdown-item preview-item">
                        <div class="preview-thumbnail">
                            <div class="preview-icon bg-info">
                                <i class="ti-user mx-0"></i>
                            </div>
                        </div>
                        <div class="preview-item-content">
                            <h6 class="preview-subject">New user registration</h6>
                            <p class="font-weight-light small-text mb-0 text-muted">
                                2 days ago
                            </p>
                        </div>
                    </a> -->
                
                </div>
            </li>
            <!-- <li class="nav-item nav-profile dropdown">
                <a class="nav-link" href="#" data-toggle="dropdown" id="profileDropdown">
                    @if(isset(auth::user()->profile_picture))
                        <img src="{{asset('/userProfile')}}/{{auth::user()->profile_picture}}" alt="profile">
                    @else
                        <img src="{{asset('/supports_attachments')}}/demo_profile.png" alt="profile">
                    @endif
                </a>
            </li> -->
            
        </ul>

        
    </div>
</nav>
