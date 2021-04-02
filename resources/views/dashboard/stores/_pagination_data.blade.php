<table id="scrollVertical" class="table">
    <thead>
    <tr>
        <th>#</th>
        <th>@lang('site.name')</th>
        <th>@lang('site.logo')</th>
        <th>@lang('site.address')</th>
        <th>@lang('site.view_products')</th>
        <th>@lang('site.action')</th>
    </tr>
    </thead>
    <tbody>
    @foreach($data['stores'] as $index=>$store)
        <tr>
            <td>{{ ++$index }}</td>
            <td>{{ $store->getTranslateName(app()->getLocale()) }}</td>
            <td><img src="{{ $store->getImageSize(100,100) }}" class="img-thumbnail"></td>
            <td>{{ $store->getTranslateAddress(app()->getLocale()) }}</td>
            <td>
                <a href="{{ route(env('DASH_URL').'.products.index',['store_id' => $store->id]) }}"
                   class="btn btn-outline-success btn-rounded">@lang('site.view')</a>
            </td>
            <td>
                <a href="{{ route(env('DASH_URL').'.stores.edit',$store->id) }}" type="button"
                   class="btn btn-outline-warning btn-rounded"><span
                        class="icon-mode_edit"></span></a>
                @if($store->is_deleted == 0)
                    <form class="delete-form" action="{{ route(env('DASH_URL').'.stores.destroy',$store->id) }}"
                          method="post" style="display: inline-block">
                        {{ csrf_field() }}
                        {{ method_field('delete') }}
                        <button type="submit" class="btn btn-outline-danger btn-rounded delete-btn"><span
                                class="icon-folder1"></span></button>
                    </form>
                @else
                    <form class="delete-form" action="{{ route(env('DASH_URL').'.store/restore',['store_id' => $store->id]) }}"
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
