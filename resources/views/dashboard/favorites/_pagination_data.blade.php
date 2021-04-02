<table  class="table" id="table_data">
    <thead>
    <tr>
        <th>#</th>
        <th>@lang('site.user_name')</th>
        <th>@lang('site.product')</th>
        <th>@lang('site.date')</th>
        <th>@lang('site.action')</th>
    </tr>
    </thead>
    <tbody>
    @foreach($data['favorites'] as $index=>$favorite)
        <tr>
            <td>{{ $favorite->id }}</td>
            <td>
                <a href="{{ route(env('DASH_URL').'.customers.show',$favorite->user_id) }}">
                    {{ $favorite->user->name }}
                </a>
            </td>
            <td>
                <a href="{{ route(env('DASH_URL').'.products.show',$favorite->ad_id) }}">
                    {{ $favorite->product->getTranslateName(app()->getLocale()) }}
                </a>
            </td>
            <td>
                {{ substr($favorite->created_at,0,10) }}
            </td>
            <td>
                @if($favorite->is_deleted == 0)
                    <form class="delete-form" action="{{ route(env('DASH_URL').'.favorites.destroy',$favorite->id) }}"
                          method="post" style="display: inline-block">
                        {{ csrf_field() }}
                        {{ method_field('delete') }}
                        <button type="submit" class="btn btn-outline-danger btn-rounded delete-btn"><span
                                class="icon-folder1"></span></button>
                    </form>
                @else
                    <form class="delete-form" action="{{ route(env('DASH_URL').'.favorites/restore',['favorite_id' => $favorite->id]) }}"
                          method="post" style="display: inline-block">
                        {{ csrf_field() }}
                        {{ method_field('post') }}
                        <button type="submit" class="btn btn-outline-danger btn-rounded restore-btn"><span
                                class="icon-archive1"></span></button>
                    </form>
                @endif
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
