<table  class="table" id="table_data">
    <thead>
    <tr>
        <th>#</th>
        <th>@lang('site.amount')</th>
        <th>@lang('site.code')</th>
        <th>@lang('site.available_times')</th>
        <th>@lang('site.action')s</th>
    </tr>
    </thead>
    <tbody>
    @foreach($data['coupons'] as $index=>$coupon)
        <tr>
            <td>{{ $coupon->id }}</td>
            <td>
                {{ $coupon->amount }}
            </td>
            <td>
                {{ $coupon->code }}
            </td>
            <td>
                {{ $coupon->thecount }}
            </td>
            <td>
                <a href="{{ route(env('DASH_URL').'.coupons.edit',$coupon->id) }}" type="button"
                   class="btn btn-outline-warning btn-rounded"><span
                        class="icon-mode_edit"></span></a>
                <form class="delete-form" action="{{ route(env('DASH_URL').'.coupons.destroy',$coupon->id) }}" method="post" style="display: inline-block">
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
