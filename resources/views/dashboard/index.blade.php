@extends('layout.dashboard.app')
@section('content')
    <div class="main-container">




        <!-- Content wrapper start -->
        <div class="content-wrapper">
            <div class="row gutters justify-content-center">
                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">

                    <div class="daily-sales">
                        <div class="activity-icon blue">
                            <i class="@lang('icons.customers')"></i>
                        </div>
                        <h6>@lang('site.customers')</h6>
                        <h1>{{ $data['customers'] }}</h1>
                    </div>

                </div>

                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">

                    <div class="daily-sales">
                        <div class="activity-icon pink">
                            <i class="@lang('icons.ads')"></i>
                        </div>
                        <h6>@lang('site.ads')</h6>
                        <h1> {{ $data['ads'] }}</h1>
                    </div>

                </div>
                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">

                    <div class="daily-sales">
                        <div class="activity-icon violet">
                            <i class="@lang('icons.orders')"></i>
                        </div>
                        <h6>@lang('site.orders')</h6>
                        <h1>{{ $data['orders'] }}</h1>
                    </div>

                </div>
            </div>

            <div class="row gutters">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">


                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">@lang('site.revenue')</div>
                        </div>
                        <div class="card-body">
                            <div id="basic-column-graph" class="primary-graph"></div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
@endsection

@push('scrips')
    <script src="{{ asset('public/dash_assets/vendor/apex/apexcharts.min.js') }}"></script>
    <script src="{{ asset('public/dash_assets/vendor/apex/examples/column/basic-column-graph.js') }}"></script>
    <script src="{{ asset('public/dash_assets/vendor/apex/examples/column/basic-column-graph-datalables.js') }}"></script>
    <script src="{{ asset('public/dash_assets/vendor/apex/examples/column/basic-column-stack-graph.js') }}"></script>
    <script src="{{ asset('public/dash_assets/vendor/apex/examples/column/basic-column-stack-graph-fullheight.js') }}"></script>
    <script src="{{ asset('public/dash_assets/vendor/apex/examples/column/basic-column-graph-rotated-labels.js') }}"></script>
@endpush
