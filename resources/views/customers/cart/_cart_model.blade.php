<ul class="cart_product">
   @foreach($items as $item)
        <li id="cart_modal_item_{{ $itme->id }}">
            <div class="media">
                <a href="{{ route('product.show',$itme->id) }}">
                    <img alt="" width="70" height="90" class="mr-3" src="{{ $item->image }}">
                </a>
                <div class="media-body">
                    <a href="{{ route('product.show',$itme->id) }}">
                        <h4>{{ $item->name }}</h4>
                    </a>
                    <h4>
                        <span>{{ $item->qty  }} x {{ $item->price }}</span>
                    </h4>
                </div>
            </div>
            <div class="close-circle">
                <form class="delete_cart" method="post" action="{{ route('cart.delete') }}">
                    {{ method_field('post') }}
                    {{ csrf_field() }}
                    <input type="hidden" value="{{ $itme->id }}">
                    <button class="icon"><i class="ti-close"></i></button>
                </form>
                <a href="#">
                    <i class="ti-trash" aria-hidden="true"></i>
                </a>
            </div>
        </li>
    @endforeach
</ul>
<ul class="cart_total">
    <li>
        <div class="total">
            <h5>subtotal : <span>{{ $cart->totalPrice }}</span></h5>
        </div>
    </li>
    <li>
        <div class="buttons">
            <a href="{{ route('view_cart') }}" class="btn btn-normal btn-xs view-cart">view cart</a>
            <a href="{{ route('checkout') }}" class="btn btn-normal btn-xs checkout">checkout</a>
        </div>
    </li>
</ul>
