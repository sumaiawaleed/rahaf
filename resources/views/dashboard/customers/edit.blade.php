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
                            <form id="add_new_form"
                                  method="post" action="{{ route(env('DASH_URL').'.customers.update',$user->id) }}">
                                {{ method_field('put') }}
                                {{ csrf_field() }}
                                @include('dashboard.customers._form')
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
