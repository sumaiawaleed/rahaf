@extends('layout.dashboard.app')
@section('content')
    <div class="main-container">
        <div class="page-title">
            <div class="row gutters">
                <div class="col-md-9">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#"><i class="@lang('icons.stores')"></i></a></li>
                            <li class="breadcrumb-item"><a href="{{ route(env('DASH_URL').'.home') }}">@lang('site.home')</a></li>
                            <li class="breadcrumb-item"><a href="{{ route(env('DASH_URL').'.stores.index') }}">@lang('site.stores')</a></li>
                            <li class="breadcrumb-item active" aria-current="page">@lang('site.archive')</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-md-3">

                </div>
            </div>
        </div>
        <div class="content-wrapper">
            <div class="row gutters">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="card">
                        <div class="card-body">
                            <form id="search_form" action="{{ route(env('DASH_URL').'.store/archive')}}">
                                <div class="form-inline">
                                    <div class="form-group mx-sm-3 mb-2">
                                        <label for="query" class="sr-only">@lang('site.key_word')</label>
                                        <input id="query" type="text" class="form-control" name="search"
                                               placeholder="@lang('site.key_word')">
                                    </div>
                                    <div class="form-group mx-sm-3 mb-2">
                                        <label for="query" class="sr-only">@lang('site.category')</label>
                                        <select class="form-control" name="category_id">
                                            <option value="">@lang('site.select')</option>
                                            @foreach($data['categories'] as $c)
                                                <option value="{{ $c->id }}">{{ $c->getTranslateName(app()->getLocale()) }}</option>
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
                @include('dashboard.stores._store_data')
            </div>
        </div>
        @endsection



        @push('scripts')
            <script>
                $("#search_form").submit(function (e) {
                    e.preventDefault();
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    var actionurl = e.currentTarget.action;
                    $.ajax({
                        url: actionurl,
                        data: $("#search_form").serialize(),
                        dataType: 'text',
                        processData: false,
                        contentType: false,
                        success: function (data) {
                            $('#data').html(data);
                            $(".pagination").addClass("justify-content-center");
                            $(".pagination").addClass("info");
                            $('.page-item.active').html('<a class="page-link" href="{{ route(env('DASH_URL').'.store/archive')}}?page=1">1</a>');

                        },

                    });

                });
                $(".pagination").addClass("justify-content-center");
                $(".pagination").addClass("info");
                var page_item_class;
                $(document).ready(function () {
                    $(document).on('click','.pagination a',function (event) {
                        event.preventDefault();
                        page_item_class =  $(this).parent('li');
                        var page = $(this).attr('href').split('page=')[1];
                        featch_data(page);
                    });

                    function featch_data(page) {
                        $.ajax({
                            data:$("#search_form").serialize(),
                            url: "{{ route(env('DASH_URL').'.store/archive')}}"+"?page="+page,
                            success:function (data) {
                                $('#table_data').html(data);
                                $('.page-item').removeClass('active');
                                page_item_class.addClass('active');
                            }
                        });
                    }
                });
            </script>
    @endpush
