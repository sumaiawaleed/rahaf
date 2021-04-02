@extends('layout.dashboard.app')
@section('content')
    <div class="main-container">
        <div class="page-title">
            <div class="row gutters">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#"><i class="@lang('icons.customers')"></i></a></li>
                        <li class="breadcrumb-item"><a
                                href="{{ route(env('DASH_URL').'.home') }}">@lang('site.home')</a></li>
                        <li class="breadcrumb-item"><a
                                href="{{ route(env('DASH_URL').'.customers.index') }}">@lang('site.customers')</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $data['title'] }}</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="content-wrapper">
            <div class="row gutters">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">{{ $data['title'] }}</div>
                        </div>

                        <div class="card-body">

                            <form id="add_new_form" method="post"
                                  action="{{ route(env('DASH_URL').'.customers.index') }}">
                                {{ method_field('post') }}
                                {{ csrf_field() }}
                                @include('dashboard.customers._form')

                                <div class="row">
                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 text-center">
                                        <button class="btn btn-outline-primary" type="submit">
                                            @lang('site.add')
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endsection


        @push('scripts')
            <script>
                $("#add_new_form").submit(function (e) {
                    e.preventDefault();
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    var actionurl = e.currentTarget.action;
                    $.ajax({
                        type: 'POST',
                        url: actionurl,
                        data: new FormData(this),
                        dataType: 'text',
                        processData: false,
                        contentType: false,
                        success: function (data) {
                            result = jQuery.parseJSON(data);

                            if (result.success) {
                                $('#msgs').addClass('success');
                                Swal.fire({
                                    icon: 'success',
                                    title: '{{ $data['page_msg'] }}',
                                    showConfirmButton: false,
                                    timer: 1500
                                })
                                $('#add_new_form').trigger('reset');
                                $('input').removeClass('is-invalid');
                                $('.form_error').text('');
                            } else {
                                var errors = result.errors;
                                var html_errors = '<ul>';

                                $('#error').html('');
                                $.each(errors, function (key, val) {
                                    $("#" + key + "_error").text(val[0]);
                                    $("#" + key + "_input").addClass('is-invalid');
                                    html_errors += "<li>" + val[0] + "<\li>";
                                });
                                html_errors += '</ul>';
                            }
                        },
                        error: function (data) {

                        }
                    });
                });
            </script>

    @endpush
