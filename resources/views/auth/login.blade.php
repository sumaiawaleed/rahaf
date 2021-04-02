@extends('layouts.app')

@section('content')

    <div class="breadcrumb-main ">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="breadcrumb-contain">
                        <div>
                            <h2>@lang('site.login')</h2>
                            <ul>
                                <li><a href="/">@lang('site.home')</a></li>
                                <li><i class="fa fa-angle-double-right"></i></li>
                                <li><a href="#">@lang('site.login')</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <section class="login-page section-big-py-space bg-light">
        <div class="custom-container">
            <div class="row">
                <div class="col-xl-4 col-lg-6 col-md-8 offset-xl-4 offset-lg-3 offset-md-2">
                    <div class="theme-card">
                        <h3 class="text-center">@lang('site.login')</h3>
                        <form method="post" class="theme-form login_form" action="{{ route('postLogin')}}">
                            {{ method_field('post') }}
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="email">@lang('site.phone')</label>
                                <input type="text" class="form-control" id="phone" name="phone"
                                       placeholder="@lang('site.phone')" required="">
                            </div>
                            <div class="form-group">
                                <label for="review">Password</label>
                                <input type="password" class="form-control" name="password" id="review"
                                       placeholder="@lang('site.password')" required="">
                            </div>

                            <button type="submit" class="btn btn-normal">@lang('site.login')</button>
                            <a class="float-right txt-default mt-2" href="{{ route('register') }}"
                               id="fgpwd">@lang('site.new_user_message')</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    </div>
@endsection

