@extends('layout.dashboard.app')
@section('content')
    <div class="main-container">
        <div class="page-title">
            <div class="row gutters">
                <div class="col-xl-9 col-lg-9 col-md-9 col-sm-12 col-12">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#"><i class="@lang('icons.orders')"></i></a></li>
                            <li class="breadcrumb-item"><a
                                    href="{{ route(env('DASH_URL').'.orders.index') }}">@lang('site.orders')</a>
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
                            <form class="edit_new_form" method="post" action="{{ $data['url']   }}"
                                  enctype="multipart/form-data">
                                {{ method_field('put') }}
                                {{ csrf_field() }}
                                @include('dashboard.orders.partials._form')
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
            @php
                $user_lat = isset($form_data) ?  $form_data->user_lat : env('PLAT');
               $user_log = isset($form_data) ?  $form_data->user_log : env('PLNG');
            @endphp
            <script>
                function initMap() {
                    var myLatlng = {lat: {{  $user_lat }}, lng: {{ $user_log }}};

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
