<table id="scrollVertical" class="table">
    <thead>
    <tr>
        <th>#</th>
        <th>@lang('site.user_name')</th>
        <th>@lang('site.title')</th>
        <th>@lang('site.message')</th>
        <th>@lang('site.date')</th>
        <th>@lang('site.action')</th>
    </tr>
    </thead>
    <tbody>
    @foreach($data['notifications'] as $index=>$note)
        <tr>
            <td>{{ ++$index }}</td>
            <td>{{ $note->user->name }}</td>
            <td>{{ $note->title }}</td>
            <td>{{ $note->message }}</td>
            <td>{{ substr($note->created_at,0,10) }}</td>

            <td>
                <a href="{{ route(env('DASH_URL').'.notifications.edit',$note->id) }}" type="button"
                   class="btn btn-outline-warning btn-rounded"><span
                        class="icon-mode_edit"></span></a>
                @if($note->is_deleted == 0)
                    <form class="delete-form" action="{{ route(env('DASH_URL').'.notifications.destroy',$note->id) }}"
                          method="post" style="display: inline-block">
                        {{ csrf_field() }}
                        {{ method_field('delete') }}
                        <button type="submit" class="btn btn-outline-danger btn-rounded delete-btn"><span
                                class="icon-folder1"></span></button>
                    </form>
                @else
                    <form class="delete-form" action="{{ route(env('DASH_URL').'.notifications/restore',['notification_id' => $note->id]) }}"
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
