@extends('layout.dashboard.app')
@section('content')
    <div class="content-wrapper">



        <div class="row gutters">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

                <div class="card custom-default">
                    <div class="card-header">
                        <ul class="nav nav-tabs" id="myTab4" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="home-tab4" data-toggle="tab" href="#home4" role="tab"
                                   aria-controls="home4" aria-selected="true"><i
                                        class="icon-pencil block"></i>@lang('site.edit_customer')</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="profile-tab4" data-toggle="tab" href="#profile4" role="tab"
                                   aria-controls="profile4" aria-selected="false"><i
                                        class="icon-phone-call block"></i>@lang('site.contact_info')</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="contact-tab4" data-toggle="tab" href="#contact4" role="tab"
                                   aria-controls="contact4" aria-selected="false"><i
                                        class="icon-lock-open block"></i>@lang('site.change_password')</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" id="products-tab5" data-toggle="tab" href="#products" role="tab"
                                   aria-controls="products" aria-selected="false"><i
                                        class="@lang('icons.ads') block"></i>@lang('site.ads')</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="favorits-tab5" data-toggle="tab" href="#favorits" role="tab"
                                   aria-controls="products" aria-selected="false"><i
                                        class="@lang('icons.favorites') block"></i>@lang('site.favorites')</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="notes-tab6" data-toggle="tab" href="#notes" role="tab"
                                   aria-controls="products" aria-selected="false"><i
                                        class="@lang('icons.notes') block"></i>@lang('site.notes')</a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body pt-0">
                        <div class="tab-content" id="myTabContent4">
                            <div class="tab-pane fade  show active" id="home4" role="tabpanel"
                                 aria-labelledby="home-tab4">
                                @include('dashboard.customers.pages.edit_form')
                            </div>
                            <div class="tab-pane fade" id="profile4" role="tabpanel" aria-labelledby="profile-tab4">
                                @include('dashboard.customers.pages.contact_info')
                            </div>
                            <div class="tab-pane fade" id="contact4" role="tabpanel" aria-labelledby="contact-tab4">
                                @include('dashboard.customers.pages.chang_password')
                            </div>
                            <div class="tab-pane fade" id="products" role="tabpanel" aria-labelledby="products-tab5">
                                @include('dashboard.customers.pages.products')
                            </div>

                            <div class="tab-pane fade" id="favorits" role="tabpanel" aria-labelledby="favorits-tab6">
                                @include('dashboard.customers.pages.favorits')
                            </div>
                            <div class="tab-pane fade" id="notes" role="tabpanel" aria-labelledby="notes-tab7">
                                @include('dashboard.customers.pages.notes')
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>


    </div>
@endsection

@push('scripts')
    @include('layout.dashboard.partials._edit_form')

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
        $('.page-item.active').html('<a class="page-link" href="{{ route(env('DASH_URL').'.customer/products',['user_id' => $user->id]) }}?page=1">1</a>');
        $(".pagination").addClass("justify-content-center");
        $(".pagination").addClass("info");
        var page_item_class;
        $(document).ready(function () {
            $(document).on('click', '#products_pagination .pagination a', function (event) {
                event.preventDefault();
                page_item_class = $(this).parent('li');
                var page = $(this).attr('href').split('page=')[1];
                featch_data(page);
            });

            function featch_data(page) {
                $.ajax({
                    data:$("#search_form").serialize(),
                    url: "{{ route(env('DASH_URL').'.customer/products',['user_id' => $user->id]) }}" + "&page=" + page,
                    success: function (data) {
                        $('#product_data').html(data);
                        $('.page-item').removeClass('active');
                        page_item_class.addClass('active');
                    }
                });
            }
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
                featch_fav_data(page);
            });

            function featch_fav_data(page) {
                $.ajax({
                    data:$("#search_form").serialize(),
                    url: "{{ route(env('DASH_URL').'.favorites.index') }}" + "?page=" + page,
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
