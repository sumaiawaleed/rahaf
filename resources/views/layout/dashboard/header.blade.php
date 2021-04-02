<!-- Header start -->
<header class="header">
    <!-- Row start -->
    <div class="row gutters">
        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-6">
            <a href="\" class="logo">
                <img  height="60" src="{{ asset('public/logo.png') }}">
            </a>
        </div>
        <div class="col-xl-8 col-lg-8 col-md-6 col-sm-6 col-6">
            <!-- Header actions start -->
            <ul class="header-actions">
                <li class="dropdown">
                    <a href="#" id="userSettings" class="user-settings" data-toggle="dropdown" aria-haspopup="true">
                        <span class="user-name">{{ auth()->user()->name }}</span>
                        <span class="avatar">
                            {{ substr(auth()->user()->name,0,1) }}
                        </span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userSettings">
                        <div class="header-profile-actions">
                            <div class="header-user-profile">
                                <h5>{{ auth()->user()->name }}</h5>
                            </div>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                  style="display: none;">
                                @csrf
                            </form>
                           <a onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();" href="{{ route('logout') }}"><i class="icon-log-out1"></i> @lang('site.logout') </a>
                        </div>
                    </div>
                </li>
            </ul>
            <!-- Header actions end -->
        </div>
    </div>
    <!-- Row end -->
</header>
<!-- Header end -->
