@extends('layout.dashboard.app')
@section('content')
    <div class="main-container">
        <div class="page-title">
            <div class="row gutters">
                <div class="col-xl-9 col-lg-9 col-md-9 col-sm-12 col-12">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#"><i class="@lang('icons.favorites')"></i></a></li>
                            <li class="breadcrumb-item"><a href="{{ route(env('DASH_URL').'.index') }}">@lang('site.home')</a></li>
                            <li class="breadcrumb-item"><a href="{{ route(env('DASH_URL').'.favorites.index') }}">@lang('site.favorites')</a></li>
                            <li class="breadcrumb-item active" aria-current="page">@lang('site.archive')</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="content-wrapper">
            <div class="row gutters" id="data">
                @include('dashboard.favorites._favorite_data')
            </div>
        </div>
        @endsection

        @push('styles')
            <link rel="stylesheet" href="{{ asset('public/dash_assets/vendor/bs-select/bs-select.css') }}" />
        @endpush
        @push('scripts')
            <script src="{{ asset('public/dash_assets/vendor/bs-select/bs-select.min.js')}}"></script>


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
                $('.page-item.active').html('<a class="page-link" href="{{ env('APP_URL') }}/ads?page=1">1</a>');

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
                            url: "{{ route(env('DASH_URL').'.favorites.archive') }}" + "?page=" + page,
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
