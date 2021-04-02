<table  class="table" id="table_data">
    <thead>
    <tr>
        <th>#</th>
        <th>@lang('site.name')</th>
        <th>@lang('site.a_name')</th>
        <th>@lang('site.action')s</th>
    </tr>
    </thead>
    <tbody>
    @foreach($data['quantities'] as $index=>$quantity)
        <tr>
            <td>{{ $quantity->id }}</td>
            <td>.
                <a href="{{ route(env('DASH_URL').'.sub_quantities.index',['id' =>$quantity->id]) }}">
                    {{ $quantity->name }}
                </a>
            </td>
            <td>
                {{ $quantity->a_name }}
            </td>
            <td>
                <a href="{{ route(env('DASH_URL').'.quantities.edit',$quantity->id) }}" type="button"
                   class="btn btn-outline-warning btn-rounded"><span
                        class="icon-mode_edit"></span></a>
                <form class="delete-form" action="{{ route(env('DASH_URL').'.quantities.destroy',$quantity->id) }}" method="post" style="display: inline-block">
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
