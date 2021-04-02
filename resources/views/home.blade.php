@extends('layouts.app')
@section('content')
    <section class="theme-slider section-big-py-space bg-light">
        <div class="custom-container">
            <div class="row">
                <div class="col">
                    <div class="slide-1 no-arrow">
                        <div>
                            <div class="slider-banner p-center slide-banner-1">
                                <div class="slider-img">
                                    <img src="{{ asset('public/uploads/slider/2.jpg') }}" class=" bg-img   "
                                         alt="slider">
                                </div>
                                <div class="slider-banner-contain">
                                    <div>
                                        <h1><span>@lang('site.beauty_products')</span></h1>
                                        <a href="{{ route('products') }}" class="btn btn-normal">
                                            @lang('site.shop_now')
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="slider-banner p-center slide-banner-1">
                                <div class="slider-img">
                                    <img src="{{ asset('public/uploads/slider/3.jpg') }}" class=" bg-img   "
                                         alt="slider">
                                </div>
                                <div class="slider-banner-contain">
                                    <div>
                                        <h1><span>@lang('site.beauty_products')</span></h1>
                                        <a href="{{ route('products') }}" class="btn btn-normal">
                                            @lang('site.shop_now')
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="discount-banner">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="discount-banner-contain">
                        <h1><span>@lang('site.banner_1')</span> <span>@lang('site.banner_2')</span></h1>
                        <a href="{{ route('products',['offer' => 1]) }}">
                            <div class="rounded-contain rounded-inverse">
                                <div class="rounded-subcontain">
                                    @lang('site.banner_3')
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--discount banner end-->


    <!--title start-->
    <div class="title1 section-my-space">
        <h4>@lang('site.offers')</h4>
    </div>
    <!--title end-->


    <!--product start-->
    <section class="product section-big-pb-space">
        <div class="custom-container">
            <div class="row ">
                <div class="col pr-0">
                    <div class="product-slide-6 no-arrow mb--10">
                        @foreach($data['offers'] as $row)
                            @include('categories.partials._home_product_row')
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--product end-->




    <section class="box-category section-big-py-space bg-light">
        <div class="container-fluid ">
            <div class="row">
                <div class="col pl-0">
                    <div class="slide-10 no-arrow">
                        @foreach($data['general']['brands'] as $b)
                        <div>
                            <a href="{{ route('products',['brand_id' => $b->id]) }}">
                                <div class="box-category-contain">
                                    <h4>{{ $b->getTranslateName() }}</h4>
                                </div>
                            </a>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>



    @include('partials.home.categories')

@endsection

@push('scripts')
    <script src="{{ asset('public/assets/js/slider-animat.js') }}"></script>
@endpush
