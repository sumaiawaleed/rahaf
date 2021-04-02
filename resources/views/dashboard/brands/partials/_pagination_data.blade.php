<table  class="table" id="table_data">
    <thead>
    <tr>
        <th>#</th>
        <th>@lang('site.name')</th>
        <th>@lang('site.a_name')</th>
        <th>@lang('site.icon')</th>
        <th>@lang('site.action')</th>
    </tr>
    </thead>
    <tbody>
    @foreach($data['brands'] as $index=>$brand)
        <tr>
            <td>{{ $brand->id }}</td>
            <td>
                <a href="{{ route(env('DASH_URL').'.products.index',['brand_id' => $brand->id ]) }}">
                    {{ $brand->name }}
                </a>
            </td>
            <td>
                <a href="{{ route(env('DASH_URL').'.products.index',['brand_id' => $brand->id ]) }}">
                    {{ $brand->a_name }}
                </a>
            </td>
            <td><img width="100" height="100" src="{{ $brand->image_path }}"> </td>
            <td>
                <form action="{{ route(env('DASH_URL').'.brand.active') }}" method="post" class="d-inline">
                    @csrf
                    {{ method_field('post') }}
                    <input type="hidden" value="{{ $brand->id }}" name="id">
                    <input type="hidden" value="{{ ($brand->status == 0) ? 1 : 0 }}" name="status">
                    <button  type="submit" class="btn {{ ($brand->status == 0) ? "btn-outline-success" : "btn-outline-danger" }} btn-rounded">
                        {{ ($brand->status == 0) ? __('site.active') : __('site.disactive') }}
                    </button>
                </form>
                <a href="{{ route(env('DASH_URL').'.brands.edit',$brand->id) }}" type="button"
                   class="btn btn-outline-warning btn-rounded"><span
                        class="icon-mode_edit"></span></a>
                <form class="delete-form" action="{{ route(env('DASH_URL').'.brands.destroy',$brand->id) }}" method="post" style="display: inline-block">
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
