<table id="scrollVertical" class="table">
    <thead>
    <tr>
        <th>#</th>
        <th>@lang('site.name')</th>
        <th>@lang('site.phone')</th>
        <th>@lang('site.email')</th>
        <th>@lang('site.total_orders')</th>
        <th>@lang('site.total_products')</th>
        <th>@lang('site.view_profile')</th>
        <th>@lang('site.action')</th>
    </tr>
    </thead>
    <tbody>
    @foreach($data['customers'] as $index=>$customer)
        <tr>
            <td>{{ ++$index }}</td>
            <td>{{ $customer->name }}</td>
            <td>{{ $customer->phone_number }}</td>
            <td>{{ $customer->email }}</td>
            <td>{{ $customer->total_orders }}</td>
            <td>{{ $customer->total_products }}</td>
            <td>
                <a href="{{ route(env('DASH_URL').'.customers.show',$customer->id) }}"
                   class="btn btn-outline-success btn-rounded">@lang('site.view')</a>
            </td>
            <td>
                <a href="{{ route(env('DASH_URL').'.customers.edit',$customer->id) }}" type="button"
                   class="btn btn-outline-warning btn-rounded"><span
                        class="icon-mode_edit"></span></a>
                <form class="delete-form" action="{{ route(env('DASH_URL').'.customers.destroy',$customer->id) }}" method="post" style="display: inline-block">
                    {{ csrf_field() }}
                    {{ method_field('delete') }}
                  <button type="submit" class="btn btn-outline-danger btn-rounded delete-btn"><span
                          class="icon-folder1"></span></button>
              </form>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
