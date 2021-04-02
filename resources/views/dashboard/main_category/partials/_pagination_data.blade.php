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
    @foreach($data['categories'] as $index=>$category)
        <tr>
            <td>{{ $category->id  }}</td>
            <td>
                <a href="{{ route(env('DASH_URL').'.categories.index',['main_id' => $category->id]) }}">
                    {{ $category->name }}
                </a>
            </td>
            <td>
                <a href="{{ route(env('DASH_URL').'.categories.index',['main_id' => $category->id]) }}">
                    {{ $category->a_name }}
                </a>
            </td>
            <td><img width="100" height="100" src="{{ $category->image_path }}"> </td>
            <td>
                    <form action="{{ route(env('DASH_URL').'.main_category.active') }}" method="post" class="d-inline">
                        @csrf
                        {{ method_field('post') }}
                        <input type="hidden" value="{{ $category->id }}" name="id">
                        <input type="hidden" value="{{ ($category->status == 0) ? 1 : 0 }}" name="status">
                        <button  type="submit" class="btn {{ ($category->status == 0) ? "btn-outline-success" : "btn-outline-danger" }} btn-rounded">
                          {{ ($category->status == 0) ? __('site.active') : __('site.disactive') }}
                        </button>
                    </form>

                    <a href="{{ route(env('DASH_URL').'.main_categories.edit',$category->id) }}" type="button"
                   class="btn btn-outline-warning btn-rounded"><span
                        class="icon-mode_edit"></span></a>
                <form class="delete-form" action="{{ route(env('DASH_URL').'.main_categories.destroy',$category->id) }}" method="post" style="display: inline-block">
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
