@extends('layouts.app')
@section('content')
    <div class="breadcrumb-main ">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="breadcrumb-contain">
                        <div>
                            <h2>@lang('site.change_password')</h2>
                            <ul>
                                <li><a href="/">@lang('site.home')</a></li>
                                <li><i class="fa fa-angle-double-right"></i></li>
                                <li><a href="#">@lang('site.change_password')</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb End -->

    @php
        $form_data = auth('customers')->user();
         $name = isset($form_data) ?  $form_data->name : old("name");
         $phone = isset($form_data) ?  $form_data->phone : old("phone");
         $country_code = isset($form_data) ?  $form_data->country_code : old("country_code");
         $address = isset($form_data) ?  $form_data->address : old("address");
         $lat = isset($form_data) ?  $form_data->lat :  env('PLAT');
         $log = isset($form_data) ?  $form_data->log :  env('PLNG');
         $gender = isset($form_data) ?  $form_data->gender : old("gender");
    @endphp

    <!-- personal deatail section start -->
    <section class="contact-page register-page section-big-py-space bg-light">
        <div class="custom-container">
            <div class="row">
                <div class="col-lg-6">
                    <h3 class="mb-3">@lang('site.change_password')</h3>
                    <form class="theme-form password_form" method="post" action="{{ route('user/update_password') }}">
                        {{ method_field('post') }}
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-6" id="msg_error">

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <input type="password"
                                           name="old_password"
                                           class="form-control"
                                           id="password_input" placeholder="@lang('site.old_password')">
                                    <span class="form_error" id="old_password_error"></span>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <input type="password"
                                           name="password"
                                           class="form-control"
                                           id="password_input" placeholder="@lang('site.new_password')">
                                    <span class="form_error" id="password_error"></span>
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <input type="password"
                                           name="password_confirmation"
                                           class="form-control"
                                           id="password_confirmation_input"
                                           placeholder="@lang('site.password_confirmation')">
                                    <span class="form_error" id="password_confirmation_error"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 text-center">
                                <button class="btn btn-outline-primary" type="submit">
                                    @lang('site.edit')
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- Section ends -->
@endsection

@push('scripts')
    <script>
        $(".password_form").submit(function (e) {
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
                    if (result.success == true) {
                        $('#msg_error').html("");
                        $.notify({
                            icon: 'fa fa-check',
                            title: 'Success!',
                            message: result.msg
                        }, {
                            element: 'body',
                            position: null,
                            type: "info",
                            allow_dismiss: true,
                            newest_on_top: false,
                            showProgressbar: false,
                            placement: {
                                from: "top",
                                align: "right"
                            },
                            offset: 20,
                            spacing: 10,
                            z_index: 1031,
                            animate: {
                                enter: 'animated fadeInDown',
                                exit: 'animated fadeOutUp'
                            },
                            icon_type: 'class',
                        });

                        if (result.type == 'add')
                            $('.rahaf_form').trigger('reset');
                    } else {
                        if(result.msg)
                            $('#msg_error').html('<div class="alert alert-danger">'+result.msg+'</div>')

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
