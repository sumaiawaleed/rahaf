<table  class="table" id="table_data">
    <thead>
    <tr>
        <th>#</th>
        <th>@lang('site.name')</th>
        <th>@lang('site.category_icon')</th>
        <th>@lang('site.action')</th>
    </tr>
    </thead>
    <tbody>
    @foreach($data['categories'] as $index=>$category)
        <tr>
            <td>{{ $category->id }}</td>
            <td>{{ $category->getTranslateName(app()->getLocale()) }}</td>
            <td><img width="100" height="100" class="img-thumbnail" src="{{ $category->getImageSize(100,100) }}"></td>
            <td>
                <a href="{{ route(env('DASH_URL').'.categories.edit',$category->id) }}" type="button"
                   class="btn btn-outline-warning btn-rounded"><span
                        class="icon-mode_edit"></span></a>
                <form class="delete-form" action="{{ route(env('DASH_URL').'.categories.destroy',$category->id) }}" method="post" style="display: inline-block">
                    {{ csrf_field() }}
                    {{ method_field('delete') }}
                    <button type="button" class="btn btn-outline-danger btn-rounded delete-btn"><span
                            class="icon-archive"></span></button>
                </form>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
