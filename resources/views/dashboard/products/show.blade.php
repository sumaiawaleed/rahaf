@extends('layout.dashboard.app')
@section('content')
    <div class="main-container">
        <div class="page-title">
            <div class="row gutters">
                <div class="col-xl-9 col-lg-9 col-md-9 col-sm-12 col-12">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#"><i class="@lang('icons.products')"></i></a></li>
                            <li class="breadcrumb-item"><a
                                    href="{{ route(env('DASH_URL').'.home') }}">@lang('site.home')</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">@lang('site.products')</li>
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
                                                <h1>
                                                    {{ $data['product']->getTranslateName() }}
                                                </h1>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Row end -->
                                </div>

                                <hr>

                                <div class="invoice-address">
                                    <!-- Row start -->
                                    <div class="row gutters">
                                        <div class="col-lg-12 col-md-12 col-sm-12 text-center">
                                            <img src="{{ $data['product']->image_path }}">
                                        </div>
                                    </div>
                                    <!-- Row end -->
                                </div>

                                <div class="invoice-body">

                                    <!-- Row start -->
                                    <div class="row gutters">
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <b>@lang('site.details'):</b>
                                            <p>{!! $data['product']->getTranslateDesc() !!}</p>
                                        </div>
                                    </div>
                                    <!-- Row end -->

                                    <!-- Row start -->
                                    <div class="row gutters">
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <div class="table-responsive">
                                                @if($data['extras']->count() > 0)
                                                    <table class="table">
                                                        <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>SKU</th>
                                                            <th>@lang('site.image')</th>
                                                            <th>@lang('site.name')</th>
                                                            <th>@lang('site.type')</th>
                                                            <th>@lang('site.value')</th>
                                                            <th>@lang('site.price')</th>
                                                            <th>@lang('site.quantity')</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        @php $total = 0; @endphp
                                                        @foreach($data['extras'] as $index=>$d)
                                                            <tr>
                                                                <td>{{ ++$index }}</td>
                                                                <td>
                                                                    {{ $d->product->sku }}
                                                                </td>
                                                                <td>
                                                                    {{ $d->image_path }}
                                                                </td>
                                                                <td>
                                                                    {{ $d->product->a_name.'( '.$d->product->name.' ) ' }}
                                                                </td>
                                                                <td>

                                                                    @if($d->color and $d->color->type == 1)
                                                                        @lang('site.color')
                                                                    @else
                                                                        @lang('site.flever')
                                                                    @endif
                                                                </td>
                                                                <td>

                                                                    @if($d->color)
                                                                        @if($d->color->type == 1)
                                                                            <button type="button" class="btn btn-sm"
                                                                                    style="width:50px; height:20px;background: {{ ($d->color) ? $d->color->color : "" }}">

                                                                            </button>
                                                                        @else
                                                                            {{ $d->color->getTranslateName() }}
                                                                        @endif
                                                                    @endif


                                                                </td>
                                                                <td>
                                                                    {{ $d->quantity }}
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                        </tbody>
                                                    </table>
                                                @else
                                                    <h3 class="text-center">

                                                    </h3>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Row end -->

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
