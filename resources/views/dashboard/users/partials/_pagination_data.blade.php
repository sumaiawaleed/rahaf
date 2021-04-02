<table  class="table" id="table_data">
    <thead>
    <tr>
        <th>#</th>
        <th>@lang('site.name')</th>
        <th>@lang('site.email')</th>
        <th>@lang('site.action')s</th>
    </tr>
    </thead>
    <tbody>
    @foreach($data['users'] as $index=>$user)
        <tr>
            <td>{{ ++$index }}</td>
            <td>
                {{ $user->name }}
            </td>
            <td>
                {{ $user->email }}
            </td>

            <td>
                <a href="{{ route(env('DASH_URL').'.users.edit',$user->id) }}" type="button"
                   class="btn btn-outline-warning btn-rounded"><span
                        class="icon-mode_edit"></span></a>
                <form class="delete-form" action="{{ route(env('DASH_URL').'.users.destroy',$user->id) }}" method="post" style="display: inline-block">
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
