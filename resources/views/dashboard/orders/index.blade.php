@extends('layout.dashboard.app')
@section('content')
    <div class="main-container">
        <div class="page-title">
            <div class="row gutters">
                <div class="col-xl-9 col-lg-9 col-md-9 col-sm-12 col-12">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#"><i class="@lang('icons.orders')"></i></a></li>
                            <li class="breadcrumb-item"><a
                                    href="{{ route(env('DASH_URL').'.home') }}">@lang('site.home')</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">@lang('site.orders')</li>
                        </ol>
                    </nav>
                </div>

            </div>
        </div>
        <div class="content-wrapper">
            <div class="row gutters">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="card">
                        <div class="card-body">

                            <form id="search_form" action="{{ route(env('DASH_URL').'.orders.index') }}">
                                <div class="form-inline">
                                    <div class="form-group mx-sm-3 mb-2">
                                        <label for="search" class="sr-only">@lang('site.from')</label>
                                        <input name="from_date" type="date" class="form-control">
                                    </div>

                                    <div class="form-group mx-sm-3 mb-2">
                                        <label for="search" class="sr-only">@lang('site.to')</label>
                                        <input name="to_date" type="date" class="form-control">
                                    </div>

                                    <div class="form-group mx-sm-3 mb-2">
                                        <label for="search" class="sr-only">@lang('site.driver')</label>
                                        <select name="driver" class="form-control">
                                            <option value="">@lang('site.select_driver')</option>
                                            @foreach($data['drivers'] as $driver)
                                                <option value="{{ $driver->id }}">{{ $driver->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group mx-sm-3 mb-2">
                                        <label for="search" class="sr-only">@lang('site.status')</label>
                                        <select name="status" class="form-control">
                                            @foreach(__('orders') as $index=>$order)
                                                <option value="{{ $index }}">{{ $order }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <button type="submit" class="btn btn-primary mb-2">@lang('site.search')</button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
            <div class="row gutters" id="data">
                @if($data['orders']->count() > 0)
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

                        <div class="card">
                            <div class="card-body">

                                <div class="table-responsive" id="table_data">
                                    @include('dashboard.orders.partials._pagination_data')
                                </div>
                            </div>
                        </div>
                    </div>

                @else
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="card">
                            <div class="card-body">
                                <h3 class="text-center">@lang('site.no_data')</h3>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
        @endsection

        @push('scripts')
           @include('layout.dashboard.partials._pagination')
    @endpush
