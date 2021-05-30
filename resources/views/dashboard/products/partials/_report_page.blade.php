<table class="table" id="example">
    <thead>
    <tr  @isset($pdf) style="background-color:#f2f2f2" @endisset>
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
        <tr @isset($pdf) style="height: 150px; background-color:{{ ($index% 2 == 0) ? "#fff" : "#f2f2f2" }}" @endisset>
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
