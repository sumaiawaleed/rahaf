@extends('layouts.app')
@section('content')
    <!-- breadcrumb start -->
    <div class="breadcrumb-main">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="breadcrumb-contain">
                        <div>
                            <h2>@lang('site.orders')</h2>
                            <ul>
                                <li><a href="/">@lang('site.home')</a></li>
                                <li><i class="fa fa-angle-double-right"></i></li>
                                <li><a href="#">@lang('site.orders')</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb End -->

    <!--section start-->
    <section class="cart-section order-history section-big-py-space">
        <div class="custom-container">
            <div class="row">
                <div class="col-sm-12">
                    @if($data['orders']->count() > 0)
                        <table class="table cart-table table-responsive-xs">
                            <thead>
                            <tr class="table-head">
                                <th scope="col">#</th>
                                <th scope="col">@lang('site.address')</th>
                                <th scope="col">@lang('site.price')</th>
                                <th scope="col">@lang('site.date')</th>
                                <th scope="col">@lang('site.status')</th>
                                <th scope="col">@lang('site.notes')</th>
                                <th scope="col">@lang('site.more')</th>
                            </tr>
                            </thead>
                            @foreach($data['orders'] as $index=>$order)
                                <tbody>
                                <tr>
                                    <td>
                                        {{ ++$index }}
                                    </td>
                                    <td>
                                        {{ $order->user_address }}
                                    </td>
                                    <td>
                                        <h4>
                                            {{ $order->total_price }}
                                        </h4>
                                    </td>

                                    <td>
                                        {{ substr($order->date,0,10) }}
                                    </td>
                                    <td style="background: {{ $order->get_color() }}">
                                        <span class="text-white">
                                            {{ $order->status_name }}
                                        </span>
                                    </td>
                                    <td>
                                        {{ $order->notes }}
                                    </td>
                                    <td>
                                        <a href="{{ route('user/orders.show',['id' => $order->id]) }}" class="btn btn-rounded btn-outline mr-3">@lang('site.more')</a>
                                    </td>
                                </tr>
                                </tbody>
                            @endforeach
                        </table>

                    @else
                        <h3 class="text-center">@lang('site.no_data')</h3>
                    @endif
                </div>
            </div>
            <div class="row cart-buttons">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

                    {{ $data['orders']->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </section>
    <!--section end-->
@endsection
