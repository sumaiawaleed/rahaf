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
                            <li class="breadcrumb-item active" aria-current="page">{{ $data['title'] }}
                                ({{ $data['products']->total() }})
                            </li>
                        </ol>
                    </nav>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12 text-right">
                    @if (auth()->user()->hasPermission('products-create'))
                        <a href="{{ route(env('DASH_URL').'.products.create') }}"
                           class="btn btn-success mb-2 pull-right">@lang('site.add_products')</a>
                    @endif
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
                                                <input value="{{ $request->search }}" id="search" name="search"
                                                       type="text"
                                                       class="form-control"
                                                       placeholder="@lang('site.key_word')">
                                            </div>

                                            <div class="form-group mx-sm-3 mb-2">
                                                <label for="search" class="sr-only">@lang('site.key_word')</label>

                                            </div>

                                            <button type="submit"
                                                    class="btn btn-primary mb-2">@lang('site.search')</button>
                                        </div>
                                    </form>

                                </div>
                                <div class="col-md-4">
                                    <div class="form-group mx-sm-3 mb-2">
                                        <button onclick="$('#basicModal').modal('show');"
                                                class="btn btn-primary mb-2">@lang('site.search_filter')</button>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <form enctype="multipart/form-data" id="add_excel_form"
                                          action="{{ route(env('DASH_URL').'.save_excel') }}" method="post">
                                        {{ csrf_field() }}
                                        {{ method_field('post') }}
                                        <div class="form-group mx-sm-3 mb-2">
                                            <input name="file" onchange="$('#add_excel_form').submit()" type="file"
                                                   style="display: none;" id="excel_file">
                                            <button type="button" onclick="$('#excel_file').click();"
                                                    class="btn btn-primary mb-2">@lang('site.add_excel')</button>

                                        </div>
                                    </form>
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
                                    @include('dashboard.products.partials._pagination_data')
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="card">
                            <div class="card-body">
                                <nav aria-label="Page navigation example">
                                    {{ $data['products']->appends(request()->query())->links() }}
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

            <div class="modal fade" id="basicModal" tabindex="-1" role="dialog" aria-labelledby="basicModalLabel"
                 aria-hidden="true" style="display: none;">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="basicModalLabel">@lang('site.search')</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <form id="search_form" action="{{ route(env('DASH_URL').'.products.index') }}">

                            <div class="modal-body">
                                <div class="col-xl-12 col-lg lg-12 col-md-12 col-sm-12 col-12">
                                    <div class="form-group">
                                        <label>@lang('site.name')</label>
                                        <input value="{{ \Illuminate\Support\Facades\Cache::get('search') }}" name="search" type="text"
                                               class="form-control" placeholder="@lang('site.search')">
                                    </div>
                                </div>

                                <div class="col-xl-4 col-lglg-4 col-md-4 col-sm-4 col-12">
                                    <div class="form-group">
                                        <label for="sku">sku</label>
                                        <input  value="{{ \Illuminate\Support\Facades\Cache::get('sku') }}" name="sku" type="text" class="form-control"
                                               placeholder="sku"></div>
                                </div>


                                <div class="form-group row">
                                    <div class="col-12">
                                        <label for="inputName">@lang('site.status')</label>
                                    </div>
                                    <div class="col-6">
                                        <input {{ \Illuminate\Support\Facades\Cache::get('status') == 1 ? "checked" : "" }} type="radio" {{ $request->status == 1 ? "checked" : "" }} name="status"
                                               value="1">متاح
                                    </div>
                                    <div class="col-6">
                                        <input {{ \Illuminate\Support\Facades\Cache::get('status') == 2 ? "checked" : "" }} type="radio" {{ $request->status == 2 ? "checked" : "" }} name="status"
                                               value="2">غير متاح
                                    </div>
                                </div>

                                <hr>
                                <div class="form-group row">
                                    <div class="col-12">
                                        <label for="inputName">@lang('site.var_type')</label>
                                    </div>
                                    <div class="col-4">
                                        <input {{ \Illuminate\Support\Facades\Cache::get('var_type') == 1 ? "checked" : "" }} type="radio" name="var_type"
                                               value="1">@lang('site.color')
                                    </div>
                                    <div class="col-4">
                                        <input type="radio" {{ \Illuminate\Support\Facades\Cache::get('var_type') == 2 ? "checked" : "" }} name="var_type"
                                               value="2">@lang('site.flever')
                                    </div>
                                    <div class="col-4">
                                        <input type="radio" {{ \Illuminate\Support\Facades\Cache::get('var_type') == 3 ? "checked" : "" }} name="var_type"
                                               value="3">@lang('site.all')
                                    </div>
                                </div>
                                <hr>

                                <div class="col-xl-4 col-lglg-4 col-md-4 col-sm-4 col-12">
                                    <div class="form-group">
                                        <label for="inputName">@lang('site.less_7')</label>
                                        <input value="{{ \Illuminate\Support\Facades\Cache::get('quantity')}}" type="text" name="q" class="form-control">
                                    </div>
                                </div>


                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">@lang('site.search')</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

    @endpush
