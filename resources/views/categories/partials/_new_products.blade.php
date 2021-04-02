@if($data['new_products']->count() > 0)
    <div class="theme-card creative-card creative-inner">
        <h5 class="title-border">@lang('site.new_products')</h5>
        <div class="offer-slider slide-1">
            @foreach($data['new_products'] as $row)
                <div>
                    <div class="media">
                        <a href="{{ route('product.show',$row->id) }}"><img class="img-fluid "
                                                                            src="{{ $row->getImageSize(110,120) }}"
                                                                            alt=""></a>
                        <div class="media-body align-self-center">
                            <div class="rating">
                                {!! $row->total_rate !!}
                            </div>
                            <a href="{{ route('product.show',$row->id) }}"><h6>
                                    {{ $row->getTranslateName() }}
                                </h6></a>
                            <h4>
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
                            </h4></div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endif
