@extends('layouts.app')
@section('content')
    <section class="section-big-py-space mt--5 bg-light">
        <div class="custom-container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="product-order">
                        <h3>@lang('site.products')</h3>
                        @php $total = 0;@endphp
                        @foreach($data['details'] as $d)
                            @if($d->product_data)
                            @php $row = $d->product_data;  $total += $d->price; @endphp
                            <div class="row product-order-detail">
                                <div class="col-3">
                                    <img src="{{ $row->getImageSize(130,130) }}" alt=""
                                                        class="img-fluid "></div>
                                <div class="col-3 order_detail">
                                    <div>
                                        <h4>{{ $row->getTranslateName() }}</h4>
                                        <h5>{{ $row->category_name }}</h5></div>
                                </div>
                                <div class="col-3 order_detail">
                                    <div>
                                        <h4>@lang('site.quantity')</h4>
                                        <h5>{{ $d->quantity }}</h5></div>
                                </div>
                                <div class="col-3 order_detail">
                                    <div>
                                        <h4>@lang('site.price')</h4>
                                        <h5>{{ number_format($d->price) }}</h5></div>
                                </div>
                            </div>
                            @endif
                        @endforeach
                        <div class="total-sec">
                            <ul>
                                <li> <span></span></li>
                            </ul>
                        </div>
                        <div class="final-total">
                            <h3>@lang('site.total') <span>{{ number_format($total) }}</span></h3></div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="row order-success-sec">
                        <div class="col-sm-6">
                            <h4>@lang('site.address')</h4>
                            <ul class="order-detail">
                                <li>{{  $data['order']->user_address }}</li>
                            </ul>
                        </div>
                        <div class="col-sm-12 payment-mode">
                            <h4>@lang('site.notes')</h4>
                            <p>{{  $data['order']->notes }}</p>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
