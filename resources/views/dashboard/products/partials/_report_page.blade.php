<table class="table" id="example">
    <thead>
    <tr>
        <th>#</th>
        <th>sku</th>
        <th>@lang('site.name')</th>
        <th>@lang('site.a_name')</th>
        <th>@lang('site.categories')</th>
        <th>@lang('site.quantity')</th>
    </tr>
    </thead>
    <tbody>
    @foreach($data['products'] as $index=>$product)
        <tr>
            <td>{{ $product->id }}</td>
            <td>{{ $product->sku }}</td>
            <td>
                {{ $product->name }}
            </td>
            <td>
                {{ $product->a_name }}
            </td>
            <td>
                {{ $product->category_name }}
            </td>
            <td> {{ $product->getTotal() }}</td>

        </tr>
    @endforeach
    </tbody>
</table>
