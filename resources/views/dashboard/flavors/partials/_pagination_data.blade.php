<table  class="table" id="table_data">
    <thead>
    <tr>
        <th>#</th>
        <th>@lang('site.name')</th>
        <th>@lang('site.a_name')</th>
        <th>@lang('site.notes')</th>
        <th>@lang('site.action')</th>
    </tr>
    </thead>
    <tbody>
    @foreach($data['flavors'] as $index=>$flavor)
        <tr>
            <td>{{ $flavor->id }}</td>
            <td>
                {{ $flavor->name }}
            </td>
            <td>
                {{ $flavor->a_name }}
            </td>

            <td>
                {{ $flavor->notes }}
            </td>

            <td>
                <a href="{{ route(env('DASH_URL').'.flavors.edit',$flavor->id) }}" type="button"
                   class="btn btn-outline-warning btn-rounded"><span
                        class="icon-mode_edit"></span></a>
                <form class="delete-form" action="{{ route(env('DASH_URL').'.flavors.destroy',$flavor->id) }}" method="post" style="display: inline-block">
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
