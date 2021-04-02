<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Meta -->
    <meta name="description" content="@lang('settings.description')">
    <meta name="author" content="rahaf">
    <link rel="shortcut icon" href="{{ asset('public/favicon.ico') }}"/>

    <!-- Title -->
    <title>@lang('site.title') | {{ __('Login') }}</title>

    <!-- *************
        ************ Common Css Files *************
        ************ -->
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('public/dash_assets/css/bootstrap.min.css') }}"/>

    <!-- Master CSS -->
    <link rel="stylesheet" href="{{ asset('public/dash_assets/css/main.css')}}"/>

</head>

<body class="authentication">

<!-- Container start -->
<div class="container">

    <form method="post" action="{{ route(env('DASH_URL').'/loginProcess') }}" class="was-validated">
        @csrf

        <div class="row justify-content-md-center">
            <div class="col-xl-4 col-lg-5 col-md-6 col-sm-12">
                <div class="login-screen">
                    <div class="login-box text-center">
                        <a class="login-logo">
                            <img height="100px" src="{{ asset('public/r_logo.png') }}">
                        </a>
                        <div class="form-group">
                            <input type="email" name="email" class="form-control" placeholder="{{ __('E-Mail Address') }}" required/>
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <input type="password" name="password" class="form-control" placeholder="@lang('site.password')" required/>
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                        <label class="text-right">
                            <input type="checkbox" name="remember">remember me
                        </label>
                        <div class="actions">
{{--                            <a href="forgot-pwd.html">Recover password</a>--}}
                            <button type="submit" class="btn btn-info">@lang('auth.login')</button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </form>

</div>
<!-- Container end -->

</body>
</html>
