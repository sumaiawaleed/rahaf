<table  class="table" id="example">
    <thead>
    <tr>
        <th>#</th>
        <th>@lang('site.user')</th>
        <th>@lang('site.total')</th>
        <th>@lang('site.date')</th>
        <th>@lang('site.address')</th>
        <th>@lang('site.status')</th>
        <th>@lang('site.driver')</th>
        <th>@lang('site.action')</th>
    </tr>
    </thead>
    <tbody>
    @foreach($data['orders'] as $index=>$order)
        <tr>
            <td>{{ ++$index }}</td>
            <td>
                <a href="{{ route(env('DASH_URL').'.customers.show',$order->user_id) }}">
                    {{ $order->customer->name }}
                </a>
            </td>
            <td>
                {{ $order->total_price }}
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
                <a href="{{ route(env('DASH_URL').'.orderDetails.index',['order_id' => $order->id]) }}" type="button"
                   class="btn btn-outline-success btn-rounded">@lang('site.show')</a>
                <a href="{{ route(env('DASH_URL').'.orders.edit',$order->id) }}" type="button"
                   class="btn btn-outline-warning btn-rounded"><span
                        class="icon-mode_edit"></span></a>
                <form class="delete-form" action="{{ route(env('DASH_URL').'.orders.destroy',$order->id) }}" method="post" style="display: inline-block">
                    {{ csrf_field() }}
                    {{ method_field('delete') }}
                    <button type="button" class="btn btn-outline-danger btn-rounded delete-btn"><span
                            class="icon-trash-2"></span></button>
                </form>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
