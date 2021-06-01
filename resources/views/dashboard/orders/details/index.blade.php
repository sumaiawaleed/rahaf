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
                                    href="{{ route(env('DASH_URL').'.home') }}">@lang('site.home')</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">@lang('site.orders')</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12 text-right">
                    <button onclick="window.print()"
                            class="btn btn-outline-danger btn-sm mb-2 pull-right">
                        <i class="icon-printer"></i>
                    </button>
                </div>
            </div>
        </div>
        <div class="content-wrapper">
            <div class="row gutters">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                    <div class="card">
                        <div class="card-body p-0">
                            <div class="invoice-container">

                                <div class="invoice-header">
                                    <!-- Row start -->
                                    <div class="row gutters">
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 text-center">
                                            <div class="invoice-logo">
                                                <img src="{{ asset('public/main_logo.png') }}">
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Row end -->
                                </div>

                                <hr>

                                <div class="invoice-address">
                                    <!-- Row start -->
                                    <div class="row gutters">
                                        <div class="col-lg-4 col-md-4 col-sm-4">
                                            <address>
                                                <b>@lang('site.to') :</b> <a
                                                    href="{{ route(env('DASH_URL').'.customers.show',$data['order']->user_id) }}">
                                                    {{ $data['customer']->name }}
                                                 <span dir="ltr">({{ $data['customer']->phone }})</span>
                                                </a>
                                            </address>
                                            <address>
                                                <b>@lang('site.address') :</b> {{ $data['order']->user_address }}
                                            </address>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-4">
                                            <address>
                                                @if($data['driver'])
                                                    <b>@lang('site.driver')</b> : {{ $data['driver']->name }} (<i
                                                        dir="ltr">{{ $data['driver']->phone }}</i>)<br>
                                                @endif
                                            </address>
                                            <address>
                                                <b>@lang('site.status')</b> : {{ $data['order']->status_name }}

                                            </address>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-4">
                                            <address>
                                                <b>@lang('site.order_number') - <span
                                                        class="badge badge-info">#{{ str_replace('-','',substr($data['order']->date,0,10)) }}{{ $data['order']->id }}</span></b><br>
                                            </address>
                                            <address>
                                                <b>@lang('site.date'): </b>{{ substr($data['order']->date,0,10) }}<br>
                                            </address>
                                        </div>
                                    </div>
                                    <!-- Row end -->
                                </div>

                                <div class="invoice-body">

                                    <!-- Row start -->
                                    <div class="row gutters">
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <b>@lang('site.notes'):</b>
                                            <p>{{ $data['order']->notes }}</p>
                                        </div>
                                    </div>
                                    <!-- Row end -->

                                    <!-- Row start -->
                                    <div class="row gutters">
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <div class="table-responsive">
                                                <table class="table">
                                                    <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>@lang('site.sku')</th>
                                                        <th>@lang('site.product')</th>
                                                        <th>@lang('site.type')</th>
                                                        <th>@lang('site.value')</th>
                                                        <th>@lang('site.price')</th>
                                                        <th>@lang('site.quantity')</th>
                                                        <th>@lang('site.sub_quantity')</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @php $total = 0; @endphp
                                                    @foreach($data['details'] as $index=>$d)
                                                        <tr>
                                                            <td>{{ ++$index }}</td>
                                                            <td>
                                                                {{ $d->product->sku }}
                                                            </td>
                                                            <td>
                                                                <a href="{{ route(env('DASH_URL').'.products.show',$d->product->id) }}">
                                                                    {{ $d->product->a_name.'( '.$d->product->name.' ) ' }}
                                                                </a>
                                                            </td>
                                                            <td>
                                                                @if($d->extra_id  == 1)
                                                                    @lang('site.not_exist')
                                                                @else
                                                                    @if($d->color and $d->color->type == 1)
                                                                        @lang('site.color')
                                                                    @else
                                                                        @lang('site.flever')
                                                                    @endif
                                                                @endif
                                                            </td>
                                                            <td>
                                                                @if($d->extra_id  == 1)
                                                                    -
                                                                @else
                                                                    @if($d->color)
                                                                        @if($d->color->type == 1)
                                                                            <button type="button" class="btn btn-sm"
                                                                                    style="width:50px; height:20px;background: {{ ($d->color) ? $d->color->color : "" }}">

                                                                            </button>
                                                                        @else
                                                                            {{ $d->color->getTranslateName() }}
                                                                        @endif
                                                                    @endif
                                                                @endif


                                                            </td>
                                                            <td>{{ number_format($d->price) }}</td>
                                                            <td>{{ $d->quantity }}</td>
                                                            <td>{{ ($d->sub_quntity) ? $d->sub_quntity->a_name : "" }}</td>
                                                        </tr>
                                                        @php $total += ($d->price * $d->quantity) + 500; @endphp
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Row end -->

                                    <!-- Row start -->
                                    <div class="invoice-payment">
                                        <div class="row gutters">
                                            <div class="col-lg-6 col-md-6 col-sm-12">
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-12 order-last">
                                                <table class="table no-border m-0">
                                                    <tbody>
                                                    <tr>
                                                        <td>
                                                            <h5><strong>@lang('site.delivery')</strong>
                                                            </h5>
                                                        </td>
                                                        <td>
                                                            <h5><strong>{{ 500 }}</strong></h5>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <h5 class="text-danger"><strong>@lang('site.total')</strong>
                                                            </h5>
                                                        </td>
                                                        <td>
                                                            <h5 class="text-danger"><strong>{{ $total }}</strong></h5>
                                                        </td>
                                                    </tr>

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Row end -->

                                    <div class="row">
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mb-5"
                                             style="height: 300px;" id="map"></div>
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    @php
        $user_lat = isset($data['order']) ?  $data['order']->user_lat : env('PLAT');
       $user_log = isset($data['order']) ?  $data['order']->user_log : env('PLNG');
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
    </script>
@endpush
