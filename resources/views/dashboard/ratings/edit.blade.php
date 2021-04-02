@extends('layout.dashboard.app')
@section('content')
    <div class="main-container">
        <div class="page-title">
            <div class="row gutters">
                <div class="col-xl-9 col-lg-9 col-md-9 col-sm-12 col-12">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#"><i class="@lang('icons.ratings')"></i></a></li>
                            <li class="breadcrumb-item"><a href="{{ route(env('DASH_URL').'.ratings.index') }}">@lang('site.ratings')</a>
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
                            <form class="edit_new_form" method="post" action="{{ $data['url']}}" enctype="multipart/form-data">
                                {{ method_field('put') }}
                                {{ csrf_field() }}
                                @include('dashboard.ratings.partials._form')
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
