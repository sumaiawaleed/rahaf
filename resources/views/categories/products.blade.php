@extends('layouts.app')
@section('content')
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
    <section class="section-big-pt-space ratio_asos bg-light">
        <div class="collection-wrapper">
            <div class="custom-container">
                <div class="row">
                    @include('categories.partials._left_aside')
                    <div class="collection-content col">
                        <div class="page-main-content">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="collection-product-wrapper">
                                        <div class="product-top-filter">
                                            <div class="row">
                                                <div class="col-xl-12">
                                                    <div class="filter-main-btn"><span class="filter-btn  "><i
                                                                class="fa fa-filter"
                                                                aria-hidden="true"></i> Filter</span></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="product-wrapper-grid">
                                            <div class="row">
                                                @foreach($data['products'] as $row)
                                                    @include('categories.partials._product_row')
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="product-pagination">
                                            <div class="theme-paggination-block">
                                                <div class="row">
                                                    <div class="col-xl-12 col-md-12 col-sm-12">
                                                        <nav aria-label="Page navigation">
                                                            {{ $data['products']->appends(request()->query())->links() }}
                                                        </nav>
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
    </section>
@endsection

@push('scripts')
    @include('layout.dashboard.partials._load_catgeories')
@endpush
