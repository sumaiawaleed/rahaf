<table  class="table" id="table_data">
    <thead>
    <tr>
        <th>#</th>
        <th>@lang('site.user')</th>
        <th>@lang('site.a_name')</th>
        <th>@lang('site.icon')</th>
        <th>@lang('site.action')s</th>
    </tr>
    </thead>
    <tbody>
    @foreach($data['categories'] as $index=>$order)
        <tr>
            <td>{{ $order->id }}</td>
            <td>
                {{ $order->name }}
            </td>
            <td>
                {{ $order->a_name }}
            </td>
            <td><img width="100" height="100" src="{{ $order->image_path }}"> </td>
            <td>
                <form action="{{ route(env('DASH_URL').'.category.active') }}" method="post" class="d-inline">
                    @csrf
                    {{ method_field('post') }}
                    <input type="hidden" value="{{ $order->id }}" name="id">
                    <input type="hidden" value="{{ ($order->status == 0) ? 1 : 0 }}" name="status">
                    <button  type="submit" class="btn {{ ($order->status == 0) ? "btn-outline-success" : "btn-outline-danger" }} btn-rounded">
                        {{ ($order->status == 0) ? __('site.active') : __('site.disactive') }}
                    </button>
                </form>
                <a href="{{ route(env('DASH_URL').'.categories.edit',$order->id) }}" type="button"
                   class="btn btn-outline-warning btn-rounded"><span
                        class="icon-mode_edit"></span></a>
                <form class="delete-form" action="{{ route(env('DASH_URL').'.categories.destroy',$order->id) }}" method="post" style="display: inline-block">
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
