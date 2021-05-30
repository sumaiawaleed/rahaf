<table class="table" id="table_data">
    <thead>
    <tr>
        <th>#</th>
        <th>@lang('site.type')</th>
        <th>@lang('site.icon')</th>
        <th>@lang('site.action')</th>
    </tr>
    </thead>
    <tbody>
    @foreach($data['ads'] as $index=>$ad)
        <tr>
            <td>{{ $ad->id }}</td>
            <td>
                @if($ad->type == 1)
                    @lang('site.product')
                @elseif($ad->type == 2)
                    @lang('site.brand')
                @else
                    @lang('site.ad')
                @endif
            </td>
            <td>
                @if($ad->type == 1)
                    <a href="{{ route(env('DASH_URL').'.products.edit',$ad->ad_id) }}">
                        <img width="100" height="100" src="{{ $ad->image_path }}">
                    </a>
                @else
                    <img width="100" height="100" src="{{ $ad->image_path }}">
                @endif
            </td>
            <td>
                @if (auth()->user()->hasPermission('products-update'))
                    <a href="{{ route(env('DASH_URL').'.ads.edit',$ad->id) }}" type="button"
                       class="btn btn-outline-warning btn-rounded"><span
                            class="icon-mode_edit"></span></a>
                @endif
                @if (auth()->user()->hasPermission('products-delete'))
                    <form class="delete-form" action="{{ route(env('DASH_URL').'.ads.destroy',$ad->id) }}" method="post"
                          style="display: inline-block">
                        {{ csrf_field() }}
                        {{ method_field('delete') }}
                        <button type="button" class="btn btn-outline-danger btn-rounded delete-btn"><span
                                class="icon-trash-2"></span></button>
                    </form>
                @endif
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
