<div class="col-xl-3 col-md-4 col-6  col-grid-box">
    <div class="product">
        <div class="product-box">
            <div class="product-imgbox">
                <div class="product-front">
                    <a href="{{ route('product.show',$row->id) }}"><img src="{{ $row->getImageSize(240,300) }}"
                                                                        class="img-fluid  " alt="product">
                    </a></div>
            </div>
            <div class="product-detail detail-center ">
                <div class="detail-title">
                    <div class="detail-left">
                        <div class="rating-star">
                            {!! $row->total_rate !!}
                        </div>
                        <p>
                            {{ substr(strip_tags($row->getTranslateDesc()),0,200) }}
                        </p>
                        <a href="{{ route('product.show',$row->id) }}">
                            <h6 class="price-title">
                                {{ $row->getTranslateName() }}
                            </h6>
                        </a>
                    </div>
                    <div class="detail-right">
                        @if($row->type == 2)
                            <div class="check-price">
                                {{ $row->getDiscountPrice() }}
                            </div>
                            <div class="price">
                                <div class="price">
                                    {{ $row->getPrice() }}
                                </div>
                            </div>
                        @else
                            <div class="price">
                                <div class="price">
                                    {{ $row->getPrice() }}
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="icon-detail">
                    @auth('customers')
                        <form method="post" class="rahaf-cart-form" action="{{ route('add_to_cart') }}">
                            {{ method_field('post') }}
                            {{ csrf_field() }}
                            <div class="form-group">
                                <input type="hidden" value="{{ $row->id }}" name="id">
                                <button type="submit" class="rahaf-add-cart" data-id="{{ $row->id }}"
                                        title="@lang('site.add_to_cart')">
                                    <i class="icon-shopping-cart"></i>
                                </button>
                            </div>
                        </form>

                        @if($row->is_fav)
                            <form method="post" class="rahaf-wishlist-form" action="{{ route('wishlist') }}">
                                {{ method_field('post') }}
                                {{ csrf_field() }}
                                <div class="form-group" id="fav_{{ $row->id }}">
                                    <input type="hidden" value="{{ $row->id }}" name="id">
                                    <button type="submit" data-id="{{ $row->id }}"
                                            title="@lang('site.remove_from_wishlist')">
                                        <i id="whish_icon_{{ $row->icon }}" class="fa fa-heart"></i>
                                    </button>
                                </div>
                            </form>
                        @else
                            <form method="post" class="rahaf-wishlist-form" action="{{ route('wishlist') }}">
                                {{ method_field('post') }}
                                {{ csrf_field() }}
                                <div class="form-group" id="fav_{{ $row->id }}">
                                    <input type="hidden" value="{{ $row->id }}" name="id">
                                    <button type="submit" data-id="{{ $row->id }}"
                                            title="@lang('site.add_to_wishlist')">
                                        <i id="whish_icon_{{ $row->icon }}" class="fa fa-heart-o"></i>
                                    </button>
                                </div>
                            </form>
                        @endif
                    @else
                        <button onclick="openAccount()" class="rahaf-add-cart"
                                title="@lang('site.add_to_cart')">
                            <i class="icon-shopping-cart"></i>
                        </button>
                        <a onclick="openAccount()" title="@lang('site.add_to_whishlist')">
                            <i class="fa fa-heart-o"></i>
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</div>
