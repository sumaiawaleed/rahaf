<nav id="main-nav">
    <div class="toggle-nav"><i class="fa fa-bars sidebar-bar"></i></div>
    <ul id="main-menu" class="sm pixelstrap sm-horizontal">
        <li>
            <div class="mobile-back text-right">Back<i class="fa fa-angle-right pl-2"
                                                       aria-hidden="true"></i></div>
        </li>
        <li>
            <a href="/" class="dark-menu-item">@lang('site.home')</a>
        </li>
        <li>
            <a href="{{ route('products') }}?offer=1" class="dark-menu-item">@lang('site.offers')</a>
        </li>
        <li>
            <a href="{{ route('products') }}" class="dark-menu-item">@lang('site.products')</a>
        </li>
        <li>
            <a href="{{ route('categories') }}" class="dark-menu-item">@lang('site.categories')</a>
        </li>


        @auth('customers')
            <li>
                <a href="#" class="dark-menu-item"><i class="icon-user"></i></a>
                <ul>
                    <li><a href="{{ route('user.profile') }}">@lang('site.my_account')</a></li>
                    <li><a href="{{ route('user/favorites') }}">@lang('site.favorites')</a></li>
                    <li><a href="{{ route('user/orders') }}">@lang('site.orders')</a></li>
                    <li><a href="{{ route('user/change_password') }}">@lang('site.change_password')</a></li>
                    <li><a href="#">@lang('site.logout')</a></li>
                </ul>
            </li>
        @endauth
    </ul>
</nav>
