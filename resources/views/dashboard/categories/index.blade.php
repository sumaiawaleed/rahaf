@extends('layout.dashboard.app')
@section('content')
    <div class="main-container">
        <div class="page-title">
            <div class="row gutters">
                <div class="col-xl-9 col-lg-9 col-md-9 col-sm-12 col-12">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#"><i class="@lang('icons.categories')"></i></a></li>
                            <li class="breadcrumb-item"><a href="#">@lang('site.home')</a></li>
                            <li class="breadcrumb-item active" aria-current="page">@lang('site.users')</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12 text-right">
                    <a href="{{ route(env('DASH_URL').'.categories.create') }}"
                       class="btn btn-success mb-2 pull-right">@lang('site.add_category')</a>
                </div>
            </div>
        </div>
        <div class="content-wrapper">
            <div class="row gutters">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="card">
                        <div class="card-body">

                           <form id="search_form" action="{{ route(env('DASH_URL').'.categories.index') }}">
                               <div class="form-inline">
                                   <div class="form-group mx-sm-3 mb-2">
                                       <label for="search" class="sr-only">@lang('site.key_word')</label>
                                       <input id="search" name="search" type="text" class="form-control"
                                              placeholder="@lang('site.key_word')">
                                   </div>

                                   <div class="form-group mx-sm-3 mb-2">
                                       <label for="search" class="sr-only">@lang('site.key_word')</label>
                                       <select onchange="load_subs(value)" name="category_id" class="form-control selectpicker" data-live-search="true">
                                           <option selected>@lang('site.select')</option>
                                           @foreach( $data['main_categories'] as $m)
                                               <option value="{{ $m->id }}">{{ $m->getTranslateName(app()->getLocale()) }}</option>
                                           @endforeach
                                       </select>
                                   </div>

                                   <div class="form-group mx-sm-3 mb-2">
                                       <label for="search" class="sr-only">@lang('site.key_word')</label>
                                       <select id="sub_categories" class="form-control" name="category_id"></select>
                                   </div>


                                   <button type="submit" class="btn btn-primary mb-2">@lang('site.search')</button>
                               </div>
                           </form>

                        </div>
                    </div>
                </div>
            </div>
            <div class="row gutters" id="data">
                @include('dashboard.categories._customer_data')
            </div>
        </div>
        @endsection

        @push('styles')
            <link rel="stylesheet" href="{{ asset('public/dash_assets/vendor/bs-select/bs-select.css') }}" />
        @endpush
        @push('scripts')
            <script src="{{ asset('public/dash_assets/vendor/bs-select/bs-select.min.js')}}"></script>

@include('layout.dashboard.partials._load_catgeories')

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
                        },

                    });

                });
                $(".pagination").addClass("justify-content-center");
                $(".pagination").addClass("info");
                var page_item_class;
                $(document).ready(function () {
                    $(document).on('click', '.pagination a', function (event) {
                        event.preventDefault();
                        page_item_class = $(this).parent('li');
                        var page = $(this).attr('href').split('page=')[1];
                        featch_data(page);
                    });

                    function featch_data(page) {
                        $.ajax({
                            data:$("#search_form").serialize(),
                            url: "{{ route(env('DASH_URL').'.categories.index') }}" + "?page=" + page,
                            success: function (data) {
                                $('#table_data').html(data);
                                $('.page-item').removeClass('active');
                                page_item_class.addClass('active');
                            }
                        });
                    }
                });

            </script>
    @endpush
