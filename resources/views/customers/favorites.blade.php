@extends('layouts.app')
@section('content')
    <div class="breadcrumb-main ">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="breadcrumb-contain">
                        <div>
                            <h2>dashboard</h2>
                            <ul>
                                <li><a href="/">@lang('site.home')</a></li>
                                <li><i class="fa fa-angle-double-right"></i></li>
                                <li><a href="#">@lang('site.my_account')</a></li>
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
            <div class="product-wrapper-grid">
                <div class="row">
                    @foreach($data['products'] as $row)
                        @include('categories.partials._product_row')
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    <!-- Section ends -->
@endsection


@push('scripts')

@endpush
