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
                                    href="{{ route(env('DASH_URL').'.sub_categories.index') }}">@lang('site.sub_categories')</a>
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
                            <form class="edit_new_form" method="post" action="{{ $data['url']}}"
                                  enctype="multipart/form-data">
                                {{ method_field('put') }}
                                {{ csrf_field() }}
                                <div class="row">
                                    @include('dashboard.products.partials._form')
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
            </div>
        </div>
@endsection

@push('scripts')

        @include('layout.dashboard.partials._load_catgeories')
    @include('dashboard.products.partials._tools')

            <script>
                $(".image").change(function () {

                    if (this.files && this.files[0]) {
                        var reader = new FileReader();

                        reader.onload = function (e) {
                            $('.image-preview').attr('src', e.target.result);
                        }

                        reader.readAsDataURL(this.files[0]);
                    }

                });

                $(".edit_new_form").submit(function (e) {
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
                        beforeSend: function(){
                            $("#loading-wrapper").show();
                        },
                        complete: function(){
                            $("#loading-wrapper").hide();
                        },
                        success: function (data) {
                            result = jQuery.parseJSON(data);

                            if (result.success) {

                                Swal.fire({
                                    icon: 'success',
                                    title: "@lang('site.data_updated_successfully')",
                                    showConfirmButton: false,
                                    timer: 1500
                                })
                                $('input').removeClass('is-invalid');
                                $('select').removeClass('is-invalid');
                                $('textarea').removeClass('is-invalid');
                                $('.form_error').text('');
                                main_url = String(window.location.href);
                                let path = main_url.split("/");
                                var new_path = path.slice(0, -2);
                                main_url = new_path.join("/")
                                window.location.replace(main_url+"?page="+{{ \Illuminate\Support\Facades\Cache::get('page',0) }});
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
