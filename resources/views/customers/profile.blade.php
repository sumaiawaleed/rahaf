@extends('layouts.app')
@section('content')
    <div class="breadcrumb-main ">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="breadcrumb-contain">
                        <div>
                            <h2>@lang('site.my_account')</h2>
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
            <div class="row">
                <div class="col-lg-6">
                    <h3 class="mb-3">@lang('site.my_personal_data')</h3>
                    <form class="theme-form rahaf_form" method="post" action="{{ route('update_profile') }}">
                        {{ method_field('post') }}
                        {{ csrf_field() }}
                        <div class="form-row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="name">@lang('site.username')</label>
                                    <input type="text" class="form-control" id="name" value="{{ $name }}" name="name"
                                           placeholder="@lang('site.username')" required="">
                                    <span class="form_error" id="name_error"></span>
                                </div>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email">@lang('site.gender')</label>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="radio-option paypal">
                                                <input {{ $gender == 1 ? "checked" : "" }} type="radio" name="gender"
                                                       id="male" value="1">
                                                <label for="male">@lang('site.male')</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="radio-option paypal">
                                                <input {{ $gender == 2 ? "checked" : "" }} type="radio" name="gender"
                                                       id="female" value="2">
                                                <label for="female">@lang('site.female')</label>
                                            </div>
                                        </div>
                                    </div>
                                    <span class="form_error" id="gender_error"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="review">@lang('site.address')</label>
                                    <input type="text" class="form-control" name="address" id="review"
                                           placeholder="@lang('site.address')" value="{{ $address }}" required="">
                                </div>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class="form-group">
                                        <label for="country_code">@lang('site.country_code')</label>
                                        <input name="country_code" value="{{ $country_code }}" type="text"
                                               class="form-control" id="country_code"
                                               placeholder="@lang('site.country_code')" required="">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-8">
                                <div class="form-group">
                                    <div class="form-group">
                                        <label for="country_code">@lang('site.phone')</label>
                                        <input name="phone" value="{{ $phone }}" type="text" class="form-control"
                                               id="phone" placeholder="@lang('site.phone')" required="">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-normal">@lang('site.edit')</button>

                    </form>
                </div>
                <div class="col-lg-6">
                    <h3 class="mb-3 spc-responsive">@lang('site.map_address')</h3>
                    <form class="theme-form rahaf_form" action="{{ route('update_location') }}" method="post">
                        {{ method_field('post') }}
                        {{ csrf_field() }}
                        <div class="form-row">
                            <input type="hidden" name="lat" id="lat" value="{{ $lat }}">
                            <input type="hidden" name="log" id="log" value="{{ $log }}">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" style="height: 300px;"
                                 id="map"></div>
                        </div>
                        <button type="submit" class="btn btn-normal">@lang('site.edit')</button>

                    </form>


                </div>
            </div>
        </div>
    </section>
    <!-- Section ends -->
@endsection


@push('scripts')
    <script>
        @php
            $lat = isset($form_data) ?  $form_data->lat :  env('PLAT');
            $log = isset($form_data) ?  $form_data->log :  env('PLNG');
        @endphp
        function initMap() {
            var myLatlng = {lat: {{ $lat }}, lng: {{ $log }}};

            var map = new google.maps.Map(
                document.getElementById('map'), {zoom: 4, center: myLatlng});

            // Create the initial InfoWindow.
            var infoWindow = new google.maps.InfoWindow(
                {content: 'Click the map to get Lat/Lng!', position: myLatlng});
            infoWindow.open(map);

            // Configure the click listener.
            map.addListener('click', function (mapsMouseEvent) {
                // Close the current InfoWindow.
                infoWindow.close();

                // Create a new InfoWindow.
                infoWindow = new google.maps.InfoWindow({position: mapsMouseEvent.latLng});
                infoWindow.setContent(mapsMouseEvent.latLng.toString());

                $('#lat').val(mapsMouseEvent.latLng.lat().toString());
                $('#log').val(mapsMouseEvent.latLng.lng().toString());


                infoWindow.open(map);
            });
        }
    </script>
    <script async defer
            src="https://maps.googleapis.com/maps/api/js?key={{ env('MAP_API') }}&callback=initMap">
    </script>
@endpush
