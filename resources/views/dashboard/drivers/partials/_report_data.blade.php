<table  class="table" id="table_data">
    <thead>
    <tr @isset($pdf) style="background-color:#f2f2f2" @endisset>
        <th>#</th>
        <th>@lang('site.name')</th>
        <th>@lang('site.phone')</th>
        <th>@lang('site.orders')</th>
    </tr>
    </thead>
    <tbody>
    @foreach($data['drivers'] as $index=>$color)
        <tr @isset($pdf) style="height: 150px; background-color:{{ ($index% 2 == 0) ? "#fff" : "#f2f2f2" }}" @endisset>
            <td>{{ $color->id }}</td>
            <td>
                {{ $color->name }}
            </td>
            <td>
                {{ $color->phone }}
            </td>

            <td>
                {{ $color->orders }}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
