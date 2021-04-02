@extends('layouts.app')

@section('content')

    <div class="breadcrumb-main ">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="breadcrumb-contain">
                        <div>
                            <h2>@lang('site.register')</h2>
                            <ul>
                                <li><a href="/">@lang('site.home')</a></li>
                                <li><i class="fa fa-angle-double-right"></i></li>
                                <li><a href="#">@lang('site.register')</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <section class="register-page section-big-py-space bg-light">
        <div class="custom-container">
            @php
                $form_data = auth('customers')->user();
                 $name = isset($form_data) ?  $form_data->name : old("name");
                 $phone = isset($form_data) ?  $form_data->phone : old("phone");
                 $country_code = isset($form_data) ?  $form_data->country_code : old("country_code");
                 $address = isset($form_data) ?  $form_data->address : old("address");
                 $lat = isset($form_data) ?  $form_data->lat :  env('PLAT');
                 $log = isset($form_data) ?  $form_data->log :  env('PLNG');
                 $gender = isset($form_data) ?  $form_data->gender : old("gender");
            @endphp

            <div class="row">
                <div class="col-xl-4 col-lg-6 col-md-8 offset-xl-4 offset-lg-3 offset-md-2">
                    <div class="theme-card">
                        <h3 class="text-center">@lang('site.register')</h3>
                        @if($errors->any())
                            {{ implode('', $errors->all('<div>:message</div>')) }}
                        @endif
                        <form method="post" class="theme-form" action="{{ route('register')}}">
                            {{ method_field('post') }}
                            {{ csrf_field() }}
                            <div class="form-row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="name">@lang('site.username')</label>
                                        <input type="text" class="form-control" id="name" value="{{ $name }}" name="name"
                                               placeholder="@lang('site.username')" required="">
                                        <span class="form_error" id="name_error"></span>
                                    </div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="email">@lang('site.gender')</label>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="radio-option paypal">
                                                    <input {{ $gender == 1 ? "checked" : "" }} type="radio" name="gender"
                                                           id="male" value="1">
                                                    <label for="male">@lang('site.male')</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="radio-option paypal">
                                                    <input {{ $gender == 2 ? "checked" : "" }} type="radio" name="gender"
                                                           id="female" value="2">
                                                    <label for="female">@lang('site.female')</label>
                                                </div>
                                            </div>
                                        </div>
                                        <span class="form_error" id="gender_error"></span>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="review">@lang('site.address')</label>
                                        <input type="text" class="form-control" name="address" id="review"
                                               placeholder="@lang('site.address')" value="{{ $address }}" required="">
                                    </div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label for="country_code">@lang('site.country_code')</label>
                                            <input name="country_code" value="{{ $country_code }}" type="text"
                                                   class="form-control" id="country_code"
                                                   placeholder="@lang('site.country_code')" required="">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label for="country_code">@lang('site.phone')</label>
                                            <input name="phone" value="{{ $phone }}" type="text" class="form-control"
                                                   id="phone" placeholder="@lang('site.phone')" required="">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label for="password">@lang('site.password')</label>
                                            <input name="password"  type="password" class="form-control"
                                                   id="password" placeholder="@lang('site.password')" required="">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label for="password_confirmation">@lang('site.password_confirmation')</label>
                                            <input name="password_confirmation"  type="password" class="form-control"
                                                   id="password_confirmation" placeholder="@lang('site.password')" required="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-normal">@lang('site.register')</button>
                            <a class="float-right txt-default mt-2" href="{{ route('register') }}"
                               id="fgpwd">@lang('site.register')</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    </div>
@endsection

