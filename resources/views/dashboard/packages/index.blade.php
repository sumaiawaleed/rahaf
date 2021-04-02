@extends('layout.dashboard.app')
@section('content')
    <div class="main-container">
        <div class="page-title">
            <div class="row gutters">
                <div class="col-xl-9 col-lg-9 col-md-9 col-sm-12 col-12">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#"><i class="@lang('icons.packages')"></i></a></li>
                            <li class="breadcrumb-item"><a href="#">@lang('site.home')</a></li>
                            <li class="breadcrumb-item active" aria-current="page">@lang('site.packages')</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12 text-right">
                    <a href="{{ route(env('DASH_URL').'.packages.create') }}"
                       class="btn btn-success mb-2 pull-right">@lang('site.add_package')</a>
                </div>
            </div>
        </div>

        <div class="content-wrapper">


            <!-- Row start -->
            <div class="row gutters">
                @foreach($data['packages'] as $index=>$package)
                    <div class="col-lg-4 col-md-4 col-sm-12">
                        <div class="pricing-plan">
                            <div class="pricing-header">
                                <h4 class="pricing-title">{{ $package->getTranslateName(app()->getLocale()) }}</h4>
                                <div class="pricing-cost">{{ $package->fees }}</div>
                                <div class="pricing-save">{{ $package->total_ads }}</div>
                            </div>
                            @php
                                $ad_packages = explode(',',$package->getTranslateFeatures(app()->getLocale()));
                            @endphp
                            <ul class="pricing-features">
                                @foreach($ad_packages as $p)
                                    <li>{{ $p }}</li>
                                @endforeach
                            </ul>
                            <div class="pricing-footer">
                                <a href="#" class="btn btn-warning btn-sm">@lang('site.edit')</a>
                                <a href="#" class="btn btn-danger btn-sm">@lang('site.delete')</a>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
            <!-- Row end -->


        </div>
        @endsection

        @push('styles')
            <link rel="stylesheet" href="{{ asset('public/dash_assets/css/pricing.css') }}">
    @endpush

