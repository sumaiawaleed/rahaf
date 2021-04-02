<table  class="table" id="table_data">
    <thead>
    <tr>
        <th>#</th>
        <th>@lang('site.name')</th>
        <th>@lang('site.a_name')</th>
        <th>@lang('site.main_categories')</th>
        <th>@lang('site.icon')</th>
        <th>@lang('site.action')s</th>
    </tr>
    </thead>
    <tbody>
    @foreach($data['sub_categories'] as $index=>$category)
        <tr>
            <td>{{ ++$index }}</td>
            <td>
                {{ $category->name }}
            </td>
            <td>
                {{ $category->a_name }}
            </td>

            <td>{{ $category->main_category->getTranslateName(app()->getLocale()) }}</td>
            <td><img width="100" height="100" src="{{ $category->image_path }}"> </td>
            <td>
                <a href="{{ route(env('DASH_URL').'.sub_categories.edit',$category->id) }}" type="button"
                   class="btn btn-outline-warning btn-rounded"><span
                        class="icon-mode_edit"></span></a>
                <form class="delete-form" action="{{ route(env('DASH_URL').'.sub_categories.destroy',$category->id) }}" method="post" style="display: inline-block">
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
