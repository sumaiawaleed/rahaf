<table class="table" id="table_data">
    <thead>
    <tr>
        <th>#</th>
        <th>sku</th>
        <th>@lang('site.name')</th>
        <th>@lang('site.categories')</th>
        {{--        <th>@lang('site.favorites')</th>--}}
        {{--        <th>@lang('site.orders')</th>--}}
        <th>@lang('site.available')</th>
        <th>@lang('site.quantity')</th>
        <th>@lang('site.is_belong')</th>
        <th>@lang('site.extra')</th>
        <th>@lang('site.icon')</th>
        <th>@lang('site.action')</th>
    </tr>
    </thead>
    <tbody>
    @foreach($data['products'] as $index=>$product)
        <tr>
            <td>{{ $product->id }}</td>
            <td>{{ $product->sku }}</td>
            <td>
                {{ $product->getTranslateName(app()->getLocale()) }}
            </td>
            <td>
                {{ $product->category_name }}
            </td>

            {{--            <td>--}}
            {{--                <a href="{{ route(env('DASH_URL').'.favourites.index',['product_id' => $product->id]) }}">--}}
            {{--                    {{ $product->favorites }}--}}
            {{--                </a>--}}
            {{--            </td>--}}

            {{--            <td>--}}
            {{--                <a href="{{ route(env('DASH_URL').'.orders.index',['product_id' => $product->id]) }}">--}}
            {{--                    {{ $product->orders }}--}}
            {{--                </a>--}}
            {{--            </td>--}}

            <td> {{ $product->available == 1 ?  __('site.yes') : __('site.no') }}</td>
            <td> {{ $product->getTotal() }}</td>
            <td> {{ $product->is_belong == 1 ? __('site.yes') : __('site.no') }}</td>

            <td>
                <a href="{{ route(env('DASH_URL').'.extras.index',['product_id' => $product->id]) }}">
                    @lang('site.show')
                </a>
            </td>

            <td><img width="100" height="100" src="{{ $product->getImageSize(100,100) }}"></td>
            <td>
                @if (auth()->user()->hasPermission('products-update'))
                    <a href="{{ route(env('DASH_URL').'.products.edit',$product->id) }}" type="button"
                       class="btn btn-outline-warning btn-rounded"><span
                            class="icon-mode_edit"></span></a>
                @endif

                @if (auth()->user()->hasPermission('products-delete'))
                    <form class="delete-form" action="{{ route(env('DASH_URL').'.products.destroy',$product->id) }}"
                          method="post" style="display: inline-block">
                        {{ csrf_field() }}
                        {{ method_field('delete') }}
                        <button type="button" class="btn btn-outline-danger btn-rounded delete-btn"><span
                                class="icon-trash-2"></span></button>
                    </form>
                @endif
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
