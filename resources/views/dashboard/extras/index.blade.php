@extends('layout.dashboard.app')
@section('content')
    <div class="main-container">
        <div class="page-title">
            <div class="row gutters">
                <div class="col-xl-9 col-lg-9 col-md-9 col-sm-12 col-12">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#"><i class="@lang('icons.extras')"></i></a></li>
                            <li class="breadcrumb-item"><a
                                    href="{{ route(env('DASH_URL').'.home') }}">@lang('site.home')</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $data['title'] }}</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12 text-right">
                    @if($data['product_id']  and $data['product_id']  != 0)
                        <a href="{{ route(env('DASH_URL').'.extras.create',['product_id' => $data['product_id']]) }}"
                           class="btn btn-success mb-2 pull-right">@lang('site.add_extras')</a>
                    @endif
                </div>
            </div>
        </div>
        <div class="content-wrapper">
            <div class="row gutters" id="data">
                @if($data['extras']->count() > 0)
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

                        <div class="card">
                            <div class="card-body">

                                <div class="table-responsive" id="table_data">
                                    @include('dashboard.extras.partials._pagination_data')
                                </div>
                            </div>
                        </div>
                    </div>

                @else
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="card">
                            <div class="card-body">
                                <h3 class="text-center">@lang('site.no_data')</h3>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
@endsection

@push('scripts')
    @include('layout.dashboard.partials._pagination')
@endpush
