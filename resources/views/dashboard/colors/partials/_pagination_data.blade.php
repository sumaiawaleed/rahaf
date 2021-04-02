<table  class="table" id="table_data">
    <thead>
    <tr>
        <th>#</th>
        <th>@lang('site.name')</th>
        <th>@lang('site.a_name')</th>
        <th>@lang('site.color')</th>
        <th>@lang('site.notes')</th>
        <th>@lang('site.action')s</th>
    </tr>
    </thead>
    <tbody>
    @foreach($data['colors'] as $index=>$color)
        <tr>
            <td>{{ $color->id }}</td>
            <td>
                {{ $color->name }}
            </td>
            <td>
                {{ $color->a_name }}
            </td>
            <td>
                {{ $color->notes }}
            </td>
            <td>
                <button type="button" class="btn btn-sm" style="width:50px; height:20px;background: {{ $color->color }}">

                </button>
            </td>
            <td>
                <a href="{{ route(env('DASH_URL').'.colors.edit',$color->id) }}" type="button"
                   class="btn btn-outline-warning btn-rounded"><span
                        class="icon-mode_edit"></span></a>
                <form class="delete-form" action="{{ route(env('DASH_URL').'.colors.destroy',$color->id) }}" method="post" style="display: inline-block">
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
