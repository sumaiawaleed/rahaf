@extends('layout.dashboard.app')
@section('content')
    <div class="main-container">
        <div class="page-title">
            <div class="row gutters">
                <div class="col-xl-9 col-lg-9 col-md-9 col-sm-12 col-12">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#"><i class="@lang('icons.categories')"></i></a></li>
                            <li class="breadcrumb-item"><a href="{{ route(env('DASH_URL').'.home') }}">@lang('site.home')</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $data['title'] }}</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12 text-right">
                    <a href="{{ route(env('DASH_URL').'.sub_categories.create') }}"
                       class="btn btn-success mb-2 pull-right">@lang('site.add_sub_categories')</a>
                </div>
            </div>
        </div>
        <div class="content-wrapper">
            <div class="row gutters">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="card">
                        <div class="card-body">

                            <form id="search_form" action="{{ route(env('DASH_URL').'.sub_categories.index') }}">
                                <div class="form-inline">
                                    <div class="form-group mx-sm-3 mb-2">
                                        <label for="search" class="sr-only">@lang('site.key_word')</label>
                                        <input value="{{ $request->search }}" id="search" name="search" type="text" class="form-control"
                                               placeholder="@lang('site.key_word')">
                                    </div>

                                    <div class="form-group mx-sm-3 mb-2">
                                        <label for="search" class="sr-only">@lang('site.key_word')</label>
                                        <select name="cat_id" class="form-control selectpicker" data-live-search="true">
                                            <option selected>@lang('site.select')</option>
                                            @foreach( $data['categories'] as $m)
                                                <option value="{{ $m->id }}">{{ $m->getTranslateName(app()->getLocale()) }}</option>
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
                @if($data['sub_categories']->count() > 0)
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

                        <div class="card">
                            <div class="card-body">

                                <div class="table-responsive" id="table_data">
                                    @include('dashboard.sub_category.partials._pagination_data')
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="card">
                            <div class="card-body">
                                <nav aria-label="Page navigation example">
                                    {{ $data['sub_categories']->appends(request()->query())->links() }}
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
