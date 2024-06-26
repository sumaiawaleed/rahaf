@extends('layout.dashboard.app')
@section('content')
    <div class="main-container">
        <div class="page-title">
            <div class="row gutters">
                <div class="col-xl-9 col-lg-9 col-md-9 col-sm-12 col-12">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#"><i class="@lang('icons.drivers')"></i></a></li>
                            <li class="breadcrumb-item"><a href="{{ route(env('DASH_URL').'.home') }}">@lang('site.home')</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">@lang('site.drivers')</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12 text-right">
                    <a href="{{ route(env('DASH_URL').'.drivers.create') }}"
                       class="btn btn-success mb-2 pull-right">@lang('site.add_drivers')</a>
                </div>
            </div>
        </div>
        <div class="content-wrapper">
            <div class="row gutters">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="card">
                        <div class="card-body">

                            @php
                            $search = $request->search;
                            $from = ($request->from) ? date('Y-m-d',strtotime($request->from)) : "";
                            $to = ($request->to) ? date('Y-m-d',strtotime($request->to)) : "";
                            @endphp

                            <form id="search_form" action="{{ route(env('DASH_URL').'.drivers.index') }}">
                                <div class="form-inline">
                                    <div class="form-group mx-sm-3 mb-2">
                                        <label for="search" class="sr-only">@lang('site.key_word')</label>
                                        <input value="{{ $search }}" id="search" name="search" type="text" class="form-control"
                                               placeholder="@lang('site.key_word')">
                                    </div>


                                    <div class="form-group mx-sm-3 mb-2">
                                        <label for="from" class="sr-only">@lang('site.from')</label>
                                        <input id="from" value="{{ $from }}" name="from" type="date" class="form-control"
                                               placeholder="@lang('site.from')">
                                    </div>


                                    <div class="form-group mx-sm-3 mb-2">
                                        <label for="to" class="sr-only">@lang('site.to')</label>
                                        <input id="to" value="{{ $to }}" name="to" type="date" class="form-control"
                                               placeholder="@lang('site.to')">
                                    </div>


                                    <button type="submit" class="btn btn-primary mb-2">@lang('site.search')</button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
            <div class="row gutters" id="data">
                @if($data['drivers']->count() > 0)
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

                        <div class="card">
                            <div class="card-body">

                                <div class="table-responsive" id="table_data">
                                    @include('dashboard.drivers.partials._pagination_data')
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="card">
                            <div class="card-body">
                                <nav aria-label="Page navigation example">
                                    {{ $data['drivers']->appends(request()->query())->links() }}
                                </nav>
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
