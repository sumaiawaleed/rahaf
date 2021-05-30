<style>
    * {
        font-family: 'dejavu sans', sans-serif;
    }

    table {
        border-collapse: collapse;
        width: 100%;
    }

    th, td {
        text-align: right;
        padding: 8px;
    }

</style>
<table class="table" id="example">
    <thead>
    <tr style="background-color: #f2f2f2">
        <th>#</th>
        <th>@lang('site.user')</th>
        <th>@lang('site.total')</th>
        <th>@lang('site.date')</th>
        <th>@lang('site.address')</th>
        <th>@lang('site.status')</th>
        <th>@lang('site.driver')</th>
        <th>@lang('site.notes')</th>
    </tr>
    </thead>
    <tbody>
    @foreach($data['orders'] as $index=>$order)
        <tr style="height: 180px; background-color:{{ ($index% 2 == 0) ? "#fff" : "#f2f2f2" }}">
            <td dir="ltr">
                <a href="{{ route(env('DASH_URL').'.orderDetails.index',['order_id' => $order->id]) }}">
                    #{{ str_replace('-','',substr($order->date,0,10)).$order->id }}
                </a>
            </td>

            <td>
                <a href="{{ route(env('DASH_URL').'.customers.show',$order->user_id) }}">
                    {{ $order->customer->name }}
                </a>
            </td>
            <td>
                {{ is_numeric($order->total_price) ? number_format($order->total_price) : $order->total_price }}
            </td>
            <td>
                {{ substr($order->date,0,10) }}
            </td>
            <td>
                {{ $order->user_address }}
            </td>
            <td>
                {{ $order->getStatusNameAttribute() }}
            </td>
            <td>
                {{ $order->driver() }}
            </td>

            <td>
                @if($order->notes)
                    <button class="btn btn-sm btn-success">
                        <i class="icon-check"></i>
                    </button>
                @else
                    <label class="btn btn-sm btn-warning">
                        <i class="icon-close"></i>
                    </label>
                @endif
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
