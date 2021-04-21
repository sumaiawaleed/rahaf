@extends('layout.dashboard.app')
@section('content')
    <div class="main-container">
        <div class="page-title">
            <div class="row gutters">
                <div class="col-xl-9 col-lg-9 col-md-9 col-sm-12 col-12">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#"><i class="@lang('icons.extras')"></i></a></li>
                            <li class="breadcrumb-item"><a href="{{ route(env('DASH_URL').'.extras.index',['product_id' => $data['product_id']]) }}">@lang('site.extras')</a>
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
                            <form class="add_new_form" method="post" action="{{ $data['url']   }}" enctype="multipart/form-data">
                                {{ method_field('post') }}
                                {{ csrf_field() }}
                                <div class="row">
                                    @include('dashboard.extras.partials._form')
                                </div>
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
                $(".image").change(function () {

                    if (this.files && this.files[0]) {
                        var reader = new FileReader();

                        reader.onload = function (e) {
                            $('.image-preview').attr('src', e.target.result);
                        }

                        reader.readAsDataURL(this.files[0]);
                    }

                });
                $(".add_new_form").submit(function (e) {
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
                            $("#loading-wrapper").hide();
                            console.log(data);
                            result = jQuery.parseJSON(data);

                            if (result.success) {
                                $(".add_new_form").trigger('reset');
                                $(".image-preview").attr('src','{{ asset('public/placeholder.png') }}');
                                Swal.fire({
                                    icon: 'success',
                                    title: '@lang('site.data_added_successfully')',
                                    showConfirmButton: false,
                                    timer: 1500
                                }).then(function () {
                                    window.location.replace("{{ route(env('DASH_URL').'.extras.index',['product_id' => $data['product_id']]) }}");
                                });
                                // $('.add_new_form').trigger('reset');
                                $('input').removeClass('is-invalid');
                                $('select').removeClass('is-invalid');
                                $('textarea').removeClass('is-invalid');
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
                                console.log(html_errors);
                            }
                        },
                        error: function (data) {

                        }
                    });
                });
            </script>

    @include('layout.dashboard.partials._load_catgeories')
            <link rel="stylesheet" href="{{ asset('public/dash_assets/vendor/bs-select/bs-select.css') }}" />
            <script src="{{ asset('public/dash_assets/vendor/bs-select/bs-select.min.js')}}"></script>


    @endpush
