@extends('layouts.app')
@section('content')
    <div class="breadcrumb-main ">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="breadcrumb-contain">
                        <div>
                            <h2>{{ $data['title'] }}</h2>
                            <ul>
                                <li><a href="/">@lang('site.home')</a></li>
                                <li><i class="fa fa-angle-double-right"></i></li>
                                <li><a href="#">{{ $data['title'] }}</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb End -->

    @php
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
                    <h3 class="mb-3">{{ $data['title'] }}</h3>
                    <form method="post" class="theme-form" action="{{ route('checkout') }}">
                       {{ csrf_field() }}
                        {{ method_field('post') }}
                        <div class="form-row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="address">@lang('site.address')</label>
                                    <input type="text" class="form-control" id="address" value="{{ $address }}" name="address"
                                           placeholder="@lang('site.address')" required="">
                                    <span class="form_error" id="address_error"></span>
                                </div>
                            </div>
                        </div>

                        <div class="form-row">
                            <input type="hidden" name="lat" id="lat" value="{{ $lat }}">
                            <input type="hidden" name="log" id="log" value="{{ $log }}">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" style="height: 300px;"
                                 id="map"></div>
                        </div>

                        <button type="submit" class="btn btn-normal">@lang('site.checkout')</button>

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
