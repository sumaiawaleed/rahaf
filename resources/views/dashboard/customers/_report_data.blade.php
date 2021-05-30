<table id="example" class="table">
    <thead>
    <tr @isset($pdf) style="background-color:#f2f2f2" @endisset>
        <th>#</th>
        <th>@lang('site.name')</th>
        <th>@lang('site.phone')</th>
        <th>@lang('site.email')</th>
        <th>@lang('site.total_orders')</th>
        <th>@lang('site.total_products')</th>
    </tr>
    </thead>
    <tbody>
    @foreach($data['customers'] as $index=>$customer)
        <tr @isset($pdf) style="height: 150px; background-color:{{ ($index% 2 == 0) ? "#fff" : "#f2f2f2" }}" @endisset>
            <td>{{ ++$index }}</td>
            <td>{{ $customer->name }}</td>
            <td>{{ $customer->phone_number }}</td>
            <td>{{ $customer->email }}</td>
            <td>{{ $customer->total_orders }}</td>
            <td>{{ $customer->total_products }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
