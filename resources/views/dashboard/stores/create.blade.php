@extends('layout.dashboard.app')
@section('content')
    <div class="main-container">
        <div class="page-title">
            <div class="row gutters">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#"><i class="@lang('icons.stores')"></i></a></li>
                        <li class="breadcrumb-item"><a
                                href="{{ route(env('DASH_URL').'.home') }}">@lang('site.home')</a></li>
                        <li class="breadcrumb-item"><a
                                href="{{ route(env('DASH_URL').'.stores.index') }}">@lang('site.stores')</a>
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
                            @if($store)
                                <h3 class="text-center">
                                    لا يمكن إضافة متجر للمستخدم
                                </h3>
                            @else
                                <form id="add_new_form" method="post"
                                      action="{{ route(env('DASH_URL').'.stores.store') }}"
                                      enctype="multipart/form-data">
                                    {{ method_field('post') }}
                                    {{ csrf_field() }}
                                    <input type="hidden" value="{{ $data['user_id'] }}" name="user_id">
                                    @include('dashboard.stores._form')

                                    <div class="row">
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 text-center">
                                            <button class="btn btn-outline-primary" type="submit">
                                                @lang('site.add')
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection


@push('scripts')
    @include('layout.dashboard.partials._store_form')

@endpush
