@extends('layouts.app')
@section('content')
<!-- breadcrumb start -->
<div class="breadcrumb-main ">
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="breadcrumb-contain">
                    <div>
                        <h2>{{ $data['title'] }}</h2>
                        <ul>
                            <li><a href="/">@lang('site.home')</a></li>
                            <li><i class="fa fa-angle-double-right"></i></li>
                            <li><a href="#">{{ $data['title'] }}</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- breadcrumb End -->

<!--section start-->
<section class="contact-page section-big-py-space bg-light">
    <div class="custom-container">
        <div class="row section-big-pb-space">
            <div class="col-xl-6 offset-xl-3">
                <h3 class="text-center mb-3">{{ $data['title']}}</h3>
                <form class="theme-form rahaf_form" action="{{ route('send_message') }}" method="post">
                    {{ csrf_field() }}
                    {{ method_field('post') }}
                    <input type="text" style="display: none;" name="name_of_sender" id="name_of_sender"
                           value="{{ csrf_token() }}">
                    <div class="form-row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="name">@lang('site.name')</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="@lang('site.name')" required="">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email">@lang('site.email')</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="@lang('site.email')" required="">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email">@lang('site.subject')</label>
                                <input type="text" class="form-control" id="subject" name="subject" placeholder="@lang('site.subject')" required="">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div>
                                <label for="review">@lang('site.message')</label>
                                <textarea class="form-control" placeholder="@lang('site.message')" id="exampleFormControlTextarea1" name="message" rows="2"></textarea>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <button class="btn btn-normal" type="submit">@lang('site.send')</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 map">
                <div class="theme-card">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d15393.746290994017!2d44.1941861!3d15.2984917!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xb49abf120dd3674e!2z2LHZh9mBINiz2KrZiNix!5e0!3m2!1sen!2s!4v1609359826991!5m2!1sen!2s" width="600" height="450" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>                </div>
            </div>
        </div>
    </div>
</section>
<!--Section ends-->
@endsection
