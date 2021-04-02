@extends('layout.dashboard.app')
@section('content')
    @php
        $user = auth()->user();
    @endphp
    <div class="main-container">
        <div class="page-title">
            <div class="row gutters">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#"><i class="@lang('icons.customers')"></i></a></li>
                        <li class="breadcrumb-item"><a
                                href="{{ route(env('DASH_URL').'.home') }}">@lang('site.home')</a></li>

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
                            <form id="add_new_form"
                                  method="post" action="{{ route(env('DASH_URL').'.change_password') }}">
                                {{ method_field('post') }}
                                {{ csrf_field() }}
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
                                                   id="password_confirmation_input" placeholder="@lang('site.password_confirmation')">
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
            </div>
        </div>
@endsection


@push('scripts')
    @include('layout.dashboard.partials._edit_form')
@endpush
