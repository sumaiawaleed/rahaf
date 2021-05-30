@extends('layout.dashboard.app')
@section('content')
    <div class="main-container">
        <div class="page-title">
            <div class="row gutters">
                <div class="col-md-9">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#"><i class="@lang('icons.brands')"></i></a></li>
                            <li class="breadcrumb-item"><a
                                    href="{{ route(env('DASH_URL').'.home') }}">@lang('site.home')</a></li>
                            <li class="breadcrumb-item active" aria-current="page">@lang('site.brands')</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="content-wrapper">
            <div class="row gutters" id="data">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive" id="table_data">
                                @include('dashboard.brands.partials._report_data')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection



@push('scripts')
    @include('layout.dashboard.partials._pagination_data')

@endpush
