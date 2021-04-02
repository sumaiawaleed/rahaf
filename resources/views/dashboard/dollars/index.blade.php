@extends('layout.dashboard.app')
@section('content')
    <div class="main-container">
        <div class="page-title">
            <div class="row gutters">
                <div class="col-xl-9 col-lg-9 col-md-9 col-sm-12 col-12">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#"><i class="@lang('icons.dollars')"></i></a></li>
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
                                @php
                                    $the_cost = isset($form_data) ?  $form_data->the_cost : old("the_cost");
                                    $id = isset($form_data) ?  $form_data->id : old("id");
                                @endphp
                                <input type="hidden" value="{{ $id }}" name="id">
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label for="the_cost_input">@lang('site.the_cost')</label>
                                        <input value="{{ $the_cost }}" type="number" name="the_cost"
                                               class="form-control" id="{{ 'the_cost_input' }}"
                                               placeholder="@lang('site.the_cost')">
                                        <span class="form_error" id="the_cost_error"></span>
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
