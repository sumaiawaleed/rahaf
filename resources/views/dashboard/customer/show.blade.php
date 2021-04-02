@extends('layout.dashboard.app')
@section('content')
    <div class="content-wrapper">



        <div class="row gutters">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

                <div class="card custom-default">
                    <div class="card-header">
                        <ul class="nav nav-tabs" id="myTab4" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="home-tab4" data-toggle="tab" href="#home4" role="tab"
                                   aria-controls="home4" aria-selected="true"><i
                                        class="icon-pencil block"></i>@lang('site.edit_customer')</a>
                            </li>

{{--                            <li class="nav-item">--}}
{{--                                <a class="nav-link" id="contact-tab4" data-toggle="tab" href="#contact4" role="tab"--}}
{{--                                   aria-controls="contact4" aria-selected="false"><i--}}
{{--                                        class="icon-lock-open block"></i>@lang('site.change_password')</a>--}}
{{--                            </li>--}}

{{--                            <li class="nav-item">--}}
{{--                                <a class="nav-link" id="products-tab5" data-toggle="tab" href="#products" role="tab"--}}
{{--                                   aria-controls="products" aria-selected="false"><i--}}
{{--                                        class="@lang('icons.ads') block"></i>@lang('site.products')</a>--}}
{{--                            </li>--}}
                            <li class="nav-item">
                                <a class="nav-link" id="favorits-tab5" data-toggle="tab" href="#favorits" role="tab"
                                   aria-controls="favorits" aria-selected="false"><i
                                        class="@lang('icons.ads') block"></i>@lang('site.favorites')</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="ratings-tab5" data-toggle="tab" href="#ratings" role="tab"
                                   aria-controls="products" aria-selected="false"><i
                                        class="@lang('icons.ratings') block"></i>@lang('site.ratings')</a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body pt-0">
                        <div class="tab-content" id="myTabContent4">
                            <div class="tab-pane fade  show active" id="home4" role="tabpanel"
                                 aria-labelledby="home-tab4">
                                @include('dashboard.customer.pages.edit_form')
                            </div>

{{--                            <div class="tab-pane fade" id="contact4" role="tabpanel" aria-labelledby="contact-tab4">--}}
{{--                                @include('dashboard.customer.pages.chang_password')--}}
{{--                            </div>--}}
{{--                            <div class="tab-pane fade" id="products" role="tabpanel" aria-labelledby="products-tab5">--}}
{{--                                @include('dashboard.customer.pages.products')--}}
{{--                            </div>--}}

                            <div class="tab-pane fade" id="favorits" role="tabpanel" aria-labelledby="favorits-tab6">
                                @include('dashboard.customer.pages.favorits')
                            </div>

                            <div class="tab-pane fade" id="ratings" role="tabpanel" aria-labelledby="ratings-tab6">
                                @include('dashboard.customer.pages.ratings')
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>


    </div>
@endsection

@push('scripts')
    @include('layout.dashboard.partials._edit_form')
    @include('dashboard.customer.partials._map')
@endpush
