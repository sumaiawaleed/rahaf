@extends('layout.dashboard.app')
@section('content')
    <div class="main-container">
        <div class="page-title">
            <div class="row gutters">
              <div class="col-md-9">
                  <nav aria-label="breadcrumb">
                      <ol class="breadcrumb">
                          <li class="breadcrumb-item"><a href="#"><i class="@lang('icons.notifications')"></i></a></li>
                          <li class="breadcrumb-item"><a href="#">@lang('site.home')</a></li>
                          <li class="breadcrumb-item active" aria-current="page">@lang('site.notifications')</li>
                      </ol>
                  </nav>
              </div>
                <div class="col-md-3">
                    <a class="btn btn-outline-primary" href="{{ route(env('DASH_URL').'.store/archive') }}">
                        @lang('site.archive')
                    </a>
                    <a class="btn btn-outline-success" href="{{ route(env('DASH_URL').'.notifications.create') }}">
                        @lang('site.add_notifications')
                    </a>
                </div>
            </div>
        </div>
        <div class="content-wrapper">
            <div class="row gutters" id="data">
                @include('dashboard.notifications._data')
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
                    $('.page-item.active').html('<a class="page-link" href="{{ env('APP_URL') }}/ads?page=1">1</a>');

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
                  url: "{{ route(env('DASH_URL').'.notifications.index') }}"+"?page="+page,
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
