<table  class="table" id="table_data">
    <thead>
    <tr>
        <th>#</th>
        <th>@lang('site.name')</th>
        <th>@lang('site.phone')</th>
        <th>@lang('site.action')s</th>
    </tr>
    </thead>
    <tbody>
    @foreach($data['drivers'] as $index=>$color)
        <tr>
            <td>{{ $color->id }}</td>
            <td>
                {{ $color->name }}
            </td>
            <td>
                {{ $color->phone }}
            </td>
            <td>
                <a href="{{ route(env('DASH_URL').'.drivers.edit',$color->id) }}" type="button"
                   class="btn btn-outline-warning btn-rounded"><span
                        class="icon-mode_edit"></span></a>
                <form class="delete-form" action="{{ route(env('DASH_URL').'.drivers.destroy',$color->id) }}" method="post" style="display: inline-block">
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
