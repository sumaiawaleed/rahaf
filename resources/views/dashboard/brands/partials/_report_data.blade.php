<table  class="table" id="table_data">
    <thead>
    <tr @isset($pdf) style="background-color:#f2f2f2" @endisset>
        <th>#</th>
        <th>@lang('site.name')</th>
        <th>@lang('site.a_name')</th>
        <th>@lang('site.icon')</th>
        <th>@lang('site.products')</th>
    </tr>
    </thead>
    <tbody>
    @foreach($data['brands'] as $index=>$brand)
        <tr @isset($pdf) style="height: 150px; background-color:{{ ($index% 2 == 0) ? "#fff" : "#f2f2f2" }}" @endisset>
            <td>{{ $brand->id }}</td>
            <td>
                <a href="{{ route(env('DASH_URL').'.products.index',['brand_id' => $brand->id ]) }}">
                    {{ $brand->name }}
                </a>
            </td>
            <td>
                <a href="{{ route(env('DASH_URL').'.products.index',['brand_id' => $brand->id ]) }}">
                    {{ $brand->a_name }}
                </a>
            </td>
            <td><img width="100" height="100" src="{{ $brand->image_path }}"> </td>
            <td>{{ $brand->products }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
