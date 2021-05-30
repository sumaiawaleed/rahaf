<!-- Navigation start -->
<nav class="navbar navbar-expand-lg custom-navbar">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#retailAdminNavbar"
            aria-controls="retailAdminNavbar" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon">
						<i></i>
						<i></i>
						<i></i>
					</span>
    </button>
    <div class="collapse navbar-collapse" id="retailAdminNavbar">
        <ul class="navbar-nav m-auto">
            <li class="nav-item">
                <a class="nav-link @if(mb_strpos(request()->path(), 'home') !==false)  active-page @endif"
                   href="{{ route(env('DASH_URL').'.home') }}">
                    <i class="@lang('icons.home') nav-icon"></i>
                    @lang('site.home')
                </a>
            </li>


            @if (auth()->user()->hasPermission('users-read'))
                <li class="nav-item">
                    <a class="nav-link @if(mb_strpos(request()->path(), 'users') !==false)  active-page @endif"
                       href="{{ route(env('DASH_URL').'.users.index') }}">
                        <i class="@lang('icons.users') nav-icon"></i>
                        @lang('site.users')
                    </a>
                </li>
            @endif

            @if (auth()->user()->hasPermission('customers-read'))

                <li class="nav-item dropdown">
                    <a class="nav-link @if(mb_strpos(request()->path(), 'customer') !==false)  active-page @endif dropdown-toggle"
                       href="#" id="formsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true"
                       aria-expanded="false">
                        <i class="@lang('icons.customers') nav-icon"></i>
                        @lang('site.customers')
                    </a>
                    <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="formsDropdown">
                        <li>
                            <a class="dropdown-item"
                               href="{{ route(env('DASH_URL').'.customers.index') }}">@lang('site.customers')</a>
                        </li>
                        <li>
                            <a class="dropdown-item"
                               href="{{ route(env('DASH_URL').'.customer.report') }}">@lang('site.reports')</a>
                        </li>

                    </ul>
                </li>

            @endif


            @if (auth()->user()->hasPermission('categories-read'))

                <li class="nav-item dropdown">
                    <a class="nav-link @if(mb_strpos(request()->path(), 'cat') !==false)  active-page @endif dropdown-toggle"
                       href="#" id="formsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true"
                       aria-expanded="false">
                        <i class="@lang('icons.categories') nav-icon"></i>
                        @lang('site.categories')
                    </a>
                    <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="formsDropdown">
                        <li>
                            <a class="dropdown-item"
                               href="{{ route(env('DASH_URL').'.main_categories.index') }}">@lang('site.main_categories')</a>
                        </li>
                        <li>
                            <a class="dropdown-item"
                               href="{{ route(env('DASH_URL').'.categories.index') }}">@lang('site.categories')</a>
                        </li>

                    </ul>
                </li>
            @endif

            @if (auth()->user()->hasPermission('drivers-read'))
                <li class="nav-item dropdown">
                    <a class="nav-link @if(mb_strpos(request()->path(), 'driver') !==false)  active-page @endif dropdown-toggle"
                       href="#" id="formsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true"
                       aria-expanded="false">
                        <i class="@lang('icons.drivers') nav-icon"></i>
                        @lang('site.drivers')
                    </a>
                    <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="formsDropdown">
                        <li>
                            <a class="dropdown-item"
                               href="{{ route(env('DASH_URL').'.drivers.index') }}">@lang('site.drivers')</a>
                        </li>
                        <li>
                            <a class="dropdown-item"
                               href="{{ route(env('DASH_URL').'.driver.report') }}">@lang('site.reports')</a>
                        </li>

                    </ul>
                </li>
            @endif

            @if (auth()->user()->hasPermission('orders-read'))
                <li class="nav-item">
                    <a class="nav-link @if(mb_strpos(request()->path(), 'orders') !==false)  active-page @endif"
                       href="{{ route(env('DASH_URL').'.orders.index') }}">
                        <i class="@lang('icons.orders') nav-icon"></i>
                        @lang('site.orders')
                    </a>
                </li>
            @endif

            @if (auth()->user()->hasPermission('products-read'))
                <li class="nav-item dropdown">
                    <a class="nav-link @if(mb_strpos(request()->path(), 'products') !==false)  active-page @endif dropdown-toggle"
                       href="#" id="formsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true"
                       aria-expanded="false">
                        <i class="@lang('icons.ads') nav-icon"></i>
                        @lang('site.products')
                    </a>
                    <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="formsDropdown">
                        <li>
                            <a class="dropdown-item"
                               href="{{ route(env('DASH_URL').'.products.create') }}">@lang('site.add_product')</a>
                        </li>
                        <li>
                            <a class="dropdown-item"
                               href="{{ route(env('DASH_URL').'.products.index') }}">@lang('site.products')</a>
                        </li>
                        <li>
                            <a class="dropdown-item"
                               href="{{ route(env('DASH_URL').'.product.reports') }}">@lang('site.reports')</a>
                        </li>
                        <li>
                            <a class="dropdown-item"
                               href="{{ route(env('DASH_URL').'.ads.index') }}">@lang('site.ads')</a>
                        </li>
                        <li>
                            <a class="dropdown-item"
                               href="{{ route(env('DASH_URL').'.favourites.index') }}">@lang('site.favourites')</a>
                        </li>
                        <li>
                            <a class="dropdown-item"
                               href="{{ route(env('DASH_URL').'.ratings.index') }}">@lang('site.ratings')</a>
                        </li>
                    </ul>
                </li>
            @endif

            <li class="nav-item dropdown">
                <a class="nav-link @if(mb_strpos(request()->path(), 'cat') !==false)  active-page @endif dropdown-toggle"
                   href="#" id="formsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true"
                   aria-expanded="false">
                    <i class="@lang('icons.stores') nav-icon"></i>
                    @lang('site.other')
                </a>
                <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="formsDropdown">
                    @if (auth()->user()->hasPermission('brands-read'))
                        <li>
                            <a class="dropdown-item"
                               href="{{ route(env('DASH_URL').'.brands.index') }}">@lang('site.brands')</a>
                        </li>
                        <li>
                            <a class="dropdown-item"
                               href="{{ route(env('DASH_URL').'.brand.report') }}">@lang('site.reports')</a>
                        </li>
                    @endif
                    @if (auth()->user()->hasPermission('coupons-read'))

                        <li>
                            <a class="dropdown-item"
                               href="{{ route(env('DASH_URL').'.coupons.index') }}">@lang('site.coupons')</a>
                        </li>
                    @endif
                    @if (auth()->user()->hasPermission('colors-read'))

                        <li>
                            <a class="dropdown-item"
                               href="{{ route(env('DASH_URL').'.colors.index') }}">@lang('site.colors')</a>
                        </li>

                            <li>
                            <a class="dropdown-item"
                               href="{{ route(env('DASH_URL').'.flavors.index') }}">@lang('site.flavors')</a>
                        </li>
                    @endif

                    @if (auth()->user()->hasPermission('dollar_cost-read'))
                        <li>
                            <a class="dropdown-item"
                               href="{{ route(env('DASH_URL').'.dollars') }}">@lang('site.dollars')</a>
                        </li>
                    @endif

                    @if (auth()->user()->hasPermission('pages-read'))
                        <li>
                            <a class="dropdown-item"
                               href="{{ route(env('DASH_URL').'.pages.index') }}">@lang('site.pages')</a>
                        </li>
                    @endif
                </ul>
            </li>

            @if (auth()->user()->hasPermission('quantities-read'))

            <li class="nav-item dropdown">
                <a class="nav-link @if(mb_strpos(request()->path(), 'quantities') !==false)  active-page @endif dropdown-toggle"
                   href="#" id="formsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true"
                   aria-expanded="false">
                    <i class="@lang('icons.quantities') nav-icon"></i>
                    @lang('site.quantities')
                </a>
                <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="formsDropdown">
                    <li>
                        <a class="dropdown-item"
                           href="{{ route(env('DASH_URL').'.quantities.index') }}">@lang('site.quantities')</a>
                    </li>
                    <li>
                        <a class="dropdown-item"
                           href="{{ route(env('DASH_URL').'.sub_quantities.index') }}">@lang('site.sub_quantities')</a>
                    </li>
                </ul>
            </li>
            @endif

            <li class="nav-item dropdown">
                <a class="nav-link  dropdown-toggle" href="#" id="formsDropdown" role="button" data-toggle="dropdown"
                   aria-haspopup="true" aria-expanded="false">
                    <i class="icon-globe nav-icon"></i>
                    @lang('site.language')
                </a>
                <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="formsDropdown">

                    @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                        <li>
                            <a class="dropdown-item" rel="alternate" hreflang="{{ $localeCode }}"
                               href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
                                {{ $properties['native'] }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </li>

        </ul>
    </div>
</nav>
<!-- Navigation end -->
