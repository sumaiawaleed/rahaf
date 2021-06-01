@extends('layout.dashboard.app')
@section('content')
    <div class="main-container">
        <div class="page-title">
            <div class="row gutters">
                <div class="col-xl-9 col-lg-9 col-md-9 col-sm-12 col-12">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#"><i class="@lang('icons.categories')"></i></a></li>
                            <li class="breadcrumb-item"><a
                                    href="{{ route(env('DASH_URL').'.home') }}">@lang('site.home')</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $data['title'] }}</li>
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
                            <div class="row">
                                <div class="col-md-8">
                                    <form id="search_form" action="{{ route(env('DASH_URL').'.products.index') }}">
                                        <div class="form-inline">
                                            <div class="form-group mx-sm-3 mb-2">
                                                <label for="search" class="sr-only">@lang('site.key_word')</label>
                                                <input value="{{ $request->search }}" id="search" name="search" type="text"
                                                       class="form-control"
                                                       placeholder="@lang('site.key_word')">
                                            </div>

                                            <div class="form-group mx-sm-3 mb-2">
                                                <label for="search" class="sr-only">@lang('site.key_word')</label>

                                            </div>

                                            <button type="submit" class="btn btn-primary mb-2">@lang('site.search')</button>
                                        </div>
                                    </form>

                                </div>
                                <div class="col-md-4">
                                    <div class="form-group mx-sm-3 mb-2">
                                        <button onclick="$('#basicModal').modal('show');"
                                                class="btn btn-primary mb-2">@lang('site.search_filter')</button>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row gutters" id="data">
                @if($data['products']->count() > 0)
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

                        <div class="card">
                            <div class="card-body">

                                <div class="table-responsive" id="table_data">
                                    @include('dashboard.products.partials._report_page')
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
          @php $search_url = route(env('DASH_URL').'.product.reports'); @endphp
          @include('dashboard.products.partials._search')
    @endpush
