<!DOCTYPE html>
<html lang="en">
<head>
    <title>@lang('settings.title') | {{ $data['title'] }} </title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="description" content="@lang('settings.title')">
    <meta name="keywords" content="@lang('settings.description')">
    <meta name="author" content="@lang('settings.author')">
    <link rel="icon" href="{{ asset('public/favicon.ico') }}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ asset('public/favicon.ico') }}" type="image/x-icon">

    <!--Google font-->
    <link href="https://fonts.googleapis.com/css?family=PT+Sans:400,700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Raleway&display=swap" rel="stylesheet">

    <!--icon css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('public/assets/css/font-awesome.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('public/assets/css/themify.css') }}">

    <!--Slick slider css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('public/assets/css/slick.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('public/assets/css/slick-theme.css') }}">

    <!--Animate css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('public/assets/css/animate.css') }}">
    <!-- Bootstrap css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('public/assets/css/bootstrap.css') }}">

    <!-- Theme css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('public/assets/css/color2.css?v=4') }}" media="screen"
          id="color">
    <style>

        @font-face {
            font-family: "STC";
            src: url("//db.onlinewebfonts.com/t/157bc09a1cd0a9c9a52fe4287c0e1d31.eot");
            src: url("//db.onlinewebfonts.com/t/157bc09a1cd0a9c9a52fe4287c0e1d31.eot?#iefix") format("embedded-opentype"), url("//db.onlinewebfonts.com/t/157bc09a1cd0a9c9a52fe4287c0e1d31.woff2") format("woff2"), url("//db.onlinewebfonts.com/t/157bc09a1cd0a9c9a52fe4287c0e1d31.woff") format("woff"), url("//db.onlinewebfonts.com/t/157bc09a1cd0a9c9a52fe4287c0e1d31.ttf") format("truetype"), url("//db.onlinewebfonts.com/t/157bc09a1cd0a9c9a52fe4287c0e1d31.svg#STC Forward") format("svg");
        }

        * {
            font-family: STC;
        }

        body, h1, h2, h3, h4, h5, h6 {
            font-family: 'STC', sans-serif !important;
        }
    </style>
</head>
<body class="bg-light {{ app()->getLocale() == 'ar' ? 'rtl' :'' }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' :'' }}">

<!-- loader start -->
<div class="loader-wrapper">
    <div>
        <img src="{{ asset('public/assets/images/loader.gif') }}" alt="loader">
    </div>
</div>
<!-- loader end -->

<!--header start-->
<header>
    <div class="mobile-fix-option"></div>
    <div class="top-header">
        <div class="custom-container">
            <div class="row">
                <div class="col-xl-5 col-md-7 col-sm-6">
                    <div class="top-header-left">
                        <div class="shpping-order">
                            <h6>@lang('site.shipping')</h6>
                        </div>
                        <div class="app-link">
                            <h6>
                                @lang('site.download_app')
                            </h6>
                            <ul>
                                <li><a href="@lang('settings.android')"><i class="fa fa-apple"></i></a></li>
                                <li><a href="@lang('settings.ios')"><i class="fa fa-android"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-xl-7 col-md-5 col-sm-6">
                    <div class="top-header-right">
                        <div class="language-block">
                            <div class="language-dropdown">
                  <span class="language-dropdown-click">
                    {{ app()->getLocale() }} <i class="fa fa-angle-down" aria-hidden="true"></i>
                  </span>
                                <ul class="language-dropdown-open">
                                    @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                                        <li>
                                            <a hreflang="{{ $localeCode }}"
                                               href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
                                                {{ $properties['native'] }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="curroncy-dropdown">
                                @php
                                    $currency = ( session()->has('currency')and  session()->get('currency') == 1) ? __('site.dollar')  : __('site.ryal') ;
                                @endphp
                                <span class="curroncy-dropdown-click" id="current_currency">
                        {{ $currency }}<i class="fa fa-angle-down" aria-hidden="true"></i>
                      </span>
                                <ul class="curroncy-dropdown-open">
                                    <form id="dollar" class="currency_form" action="{{ route('change_currency') }}"
                                          method="POST"
                                          style="display: none;">
                                        @csrf
                                        <input name="id" value="1">
                                    </form>
                                    <form id="ryal" class="currency_form" action="{{ route('change_currency') }}"
                                          method="POST"
                                          style="display: none;">
                                        @csrf
                                        <input name="id" value="2">
                                    </form>
                                    <li><a onclick="event.preventDefault();
                                                 document.getElementById('dollar').submit();"><i
                                                class="fa fa-usd"></i>@lang('site.dollar')</a>
                                    </li>
                                    <li><a onclick="event.preventDefault();
                                                 document.getElementById('ryal').submit();" href="#"><i
                                                class="fa fa-eur"></i>@lang('site.ryal')</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="layout-header2">
        <div class="container">
            <div class="col-md-12">
                <div class="main-menu-block">
                    <div class="sm-nav-block">
                        <span class="sm-nav-btn"><i class="fa fa-bars"></i></span>
                        <ul class="nav-slide">
                            <li>
                                <div class="nav-sm-back">
                                    back <i class="fa fa-angle-right pl-2"></i>
                                </div>
                            </li>
                            <li>
                                <a class="mor-slide-click">
                                    @lang('site.categories')
                                    <i class="fa fa-angle-down pro-down"></i>
                                    <i class="fa fa-angle-up pro-up"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="logo-block">
                        <a href="/"><img src="{{ asset('public/main_logo.png') }}" class="img-fluid  "
                                         alt="logo"></a>
                    </div>
                    <div class="input-block">
                        <div class="input-box">
                            <form class="big-deal-form" method="get" action="{{ route('products') }}">
                                <div class="input-group ">
                                    <div class="input-group-prepend">
                                        <span class="search"><i class="fa fa-search"></i></span>
                                    </div>
                                    <input name="secrh" type="text" class="form-control"
                                           placeholder="@lang('site.search')">

                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="cart-block cart-hover-div " onclick="openCart()">
                        <div class="cart ">
                            @php
                                if (session()->has('cart')) {
                   $cart = new \App\Cart(session()->get('cart'));
               } else {
                   $cart = new \App\Cart();
               }
                            @endphp
                            <span class="cart-product" id="count_cart_items">{{ $cart->totalQty }}</span>
                            <ul>
                                <li class="mobile-cart  ">
                                    <a href="{{ route('view_cart') }}">
                                        <i class="icon-shopping-cart "></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="cart-item">
                            <a href="{{ route('view_cart') }}">
                                <h5>@lang('site.cart')</h5>
                            </a>
                        </div>
                    </div>
                    <div class="menu-nav">
              <span class="toggle-nav">
                <i class="fa fa-bars "></i>
              </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="category-header-2">
        <div class="custom-container">
            <div class="row">
                <div class="col">
                    <div class="navbar-menu">
                        <div class="category-left">
                            <div class="nav-block">
                                <div class="nav-left">
                                    <nav class="navbar" data-toggle="collapse"
                                         data-target="#navbarToggleExternalContent">
                                        <button class="navbar-toggler" type="button">
                                            <span class="navbar-icon"><i class="fa fa-arrow-down"></i></span>
                                        </button>
                                        <h5 class="mb-0  text-white title-font">@lang('site.categories')</h5>
                                    </nav>
                                    <div class="collapse  nav-desk" id="navbarToggleExternalContent">
                                        <ul class="nav-cat title-font">
                                            @foreach($data['general']['main_categories'] as $g)
                                                <li><a href="{{ route('products',['categories[]',$g->id]) }}">
                                                        <img width="40" height="40" src="{{ $g->getImageSize(40,40) }}"
                                                             alt="category-product">
                                                        {{ $g->getTranslateName() }}</a></li>
                                            @endforeach

                                            <li>
                                                <a class="mor-slide-click">@lang('site.all_categories') <i
                                                        class="fa fa-angle-down pro-down"></i><i
                                                        class="fa fa-angle-up pro-up"></i></a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="menu-block">
                                @include('layouts._menu')
                            </div>
                            <div class="icon-block">
                                <ul>
                                    @auth('customers')
                                    @else
                                        <li class="mobile-user onhover-dropdown" onclick="openAccount()">
                                            <a href="#"><i class="icon-user"></i>
                                            </a>
                                        </li>
                                    @endauth
                                    <li class="mobile-wishlist">
                                        <a href="{{ route('user/favorites') }}"><i class="icon-heart"></i>
                                            <div class="cart-item">
                                                @php $fav = 0;@endphp
                                                @auth('customers')
                                                    @php
                                                        $fav = \App\Favourite::where('user_id',auth('customers')->user()->id)->get()->count();
                                                    @endphp
                                                @endauth
                                                <div>{{ $fav }} @lang('site.item')<span>@lang('site.wishlist')</span>
                                                </div>
                                            </div>
                                        </a></li>
                                    <li class="mobile-search"><a href="#"><i class="icon-search"></i></a>
                                        <div class="search-overlay">
                                            <div>
                                                <span class="close-mobile-search">×</span>
                                                <div class="overlay-content">
                                                    <div class="container">
                                                        <div class="row">
                                                            <div class="col-xl-12">
                                                                <form method="get" action="{{ route('products') }}">
                                                                    <div class="form-group"><input type="text"
                                                                                                   class="form-control"
                                                                                                   id="exampleInputPassword1"
                                                                                                   name="search"
                                                                                                   placeholder="@lang('site.search')">
                                                                    </div>
                                                                    <button type="submit" class="btn btn-primary"><i
                                                                            class="fa fa-search"></i></button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="mobile-setting mobile-setting-hover" onclick="openSetting()"><a href="#"><i
                                                class="icon-settings"></i></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="category-right">
                            <div class="contact-block">
                                <div>
                                    <i class="fa fa-volume-control-phone"></i>
                                    <span>call us<span>123-456-76890</span></span>
                                </div>
                            </div>
                            <div class="btn-group">
                                <div class="gift-block">
                                    <a href="{{ route('products') }}?offer=1">
                                        <div class="grif-icon">
                                            <i class="icon-gift text-white"></i>
                                        </div>
                                    </a>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<!--header end-->


