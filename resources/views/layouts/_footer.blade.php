<!--contact banner start-->
<section class="contact-banner contact-banner-inverse">
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="contact-banner-contain">
                    <div class="contact-banner-img"><img src="{{ asset('public/assets/images/layout-1/call-img.png') }}"
                                                         class="  img-fluid" alt="call-banner"></div>
                    <div><h3>@lang('site.contact_details')</h3></div>
                    <div><h2>@lang('settings.phone')</h2></div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--contact banner end-->

<!--footer start-->
<footer class="footer-2">
    <div class="container ">
        <div class="row">
            <div class="col-12">
                <div class="footer-main-contian">
                    <div class="row ">
                        <div class="col-lg-4 col-md-12 ">
                            <div class="footer-left">
                                <div class="footer-logo">
                                    <img height=60" src="{{ asset('public/r_logo.png') }}" class="img-fluid  "
                                         alt="logo">
                                </div>
                                <div class="footer-detail">
                                    <p>@lang('settings.description')</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-8 col-md-12 ">
                            <div class="footer-right">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="subscribe-section">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class=account-right>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="footer-box">
                                                        <div class="footer-title">
                                                            <h5>@lang('site.quick_links')</h5>
                                                        </div>
                                                        <div class="footer-contant">
                                                            <ul>
                                                                @foreach($data['general']['pages'] as $page)
                                                                    <li>
                                                                        <a href="{{ route($page->link) }}">{{ $page->getTranslateName() }}</a>
                                                                    </li>
                                                                @endforeach
                                                                <li>
                                                                    <a href="{{ route('contact-us') }}">@lang('site.contact')</a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="footer-box">
                                                        <div class="footer-title">
                                                            <h5>@lang('site.categories')</h5>
                                                        </div>
                                                        <div class="footer-contant">
                                                            <ul>
                                                                @foreach($data['general']['footer_categories'] as $cat)
                                                                    <li><a href="{{ route('products',['main_category' => $cat->id]) }}">{{ $cat->getTranslateName() }}</a></li>
                                                                @endforeach
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-5">
                                                    <div class="footer-box footer-contact-box">
                                                        <div class="footer-title">
                                                            <h5>@lang('site.contact')</h5>
                                                        </div>
                                                        <div class="footer-contant">
                                                            <ul class="contact-list">
                                                                <li><i class="fa fa-map-marker"></i><span>@lang('settings.address')</span>
                                                                </li>
                                                                <li><i class="fa fa-phone"></i><span>@lang('settings.phone')</span>
                                                                </li>
                                                                <li><i class="fa fa-envelope-o"></i><span>@lang('settings.email')</span>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="app-link-block  bg-transparent">
        <div class="container">
            <div class="row">
                <div class="app-link-bloc-contain app-link-bloc-contain-1">
                    <div class="app-item-group">
                        <div class="app-item">
                            <a href="@lang('settings.android')">
                                <img src="{{ asset('public/assets/images/layout-1/app/1.png') }}" class="img-fluid"
                                 alt="app-banner">
                            </a>
                        </div>
                        <div class="app-item">
                            <a href="@lang('settings.ios')">
                            <img src="{{ asset('public/assets/images/layout-1/app/2.png') }}" class="img-fluid"
                                 alt="app-banner">
                            </a>
                        </div>
                    </div>
                    <div class="app-item-group ">
                        <div class="sosiyal-block">
                            <ul class="sosiyal">
                                <li><a target="_blank" href="@lang('settings.facebook')"><i class="fa fa-facebook"></i></a></li>
                                <li><a target="_blank" href="@lang('settings.twitter')"><i class="fa fa-twitter"></i></a></li>
                                <li><a target="_blank" href="@lang('settings.instagram')"><i class="fa fa-instagram"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="sub-footer">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="sub-footer-contain">
                        <p>@lang('settings.copy')</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
<!--footer end-->

<!-- latest jquery-->
<script src="{{ asset('public/assets/js/jquery-3.3.1.min.js') }}"></script>

<!-- slick js-->
<script src="{{ asset('public/assets/js/slick.js') }}"></script>

<!-- popper js-->
<script src="{{ asset('public/assets/js/popper.min.js') }}"></script>

<!-- Timer js-->
<script src="{{ asset('public/assets/js/menu.js') }}"></script>

<!-- Bootstrap js-->
<script src="{{ asset('public/assets/js/bootstrap.js') }}"></script>

<!-- Bootstrap js-->
<script src="{{ asset('public/assets/js/bootstrap-notify.min.js') }}"></script>

<!-- Theme js-->
<script src="{{ asset('public/assets/js/script.js?v=2') }}"></script>
<script src="{{ asset('public/assets/js/modal.js') }}"></script>
@include('layouts.partials.general_js')

@auth('customers')
    @include('layouts.partials.modals.wish_list')
    @include('layouts.partials.modals.cart')
@else
    @include('layouts.partials.modals.login')
@endauth

@stack('scripts')

</body>
</html>
