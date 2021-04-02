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
    <section class="about-page section-big-py-space">
        <div class="custom-container">
            <div class="row">
                <div class="col-lg-12">
                    <h4>{{ $data['page']->getTranslateName() }}</h4>
                    <p class="mb-2"> {!! $data['page']->getTranslateDetail()!!}</p>
                </div>
            </div>
        </div>
    </section>
@endsection
