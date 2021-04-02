<table class="table" id="table_data">
    <thead>
    <tr>
        <th>#</th>
        @if($data['pro']->var_type == 1)
            <th>@lang('site.color')</th>
        @else
            <th>@lang('site.flever')</th>
        @endif
        <th>@lang('site.quantity')</th>
        <th>@lang('site.image')</th>
        <th>@lang('site.notes')</th>
        <th>@lang('site.action')</th>
    </tr>
    </thead>
    <tbody>
    @foreach($data['extras'] as $index=>$extra)
        <tr>
            <td>{{ ++$index }}</td>
            <td>
                @if($data['pro']->var_type == 1)
                    <button type="button" class="btn btn-sm text-white"
                            style="width:50px; height:20px;background: {{ $extra->color->color }}">
                        {{ $extra->color->getTranslateName() }}
                    </button>
                @else
                    {{ $extra->color->getTranslateName() }}
                @endif

            </td>

            <td>
                {{ $extra->quantity }}
            </td>
            <td><img width="100" height="100" src="{{ $extra->image_path }}"></td>
            <td>
                {{ $extra->notes }}
            </td>
            <td>
                <a href="{{ route(env('DASH_URL').'.extras.edit',$extra->id) }}" type="button"
                   class="btn btn-outline-warning btn-rounded"><span
                        class="icon-mode_edit"></span></a>
                <form class="delete-form" action="{{ route(env('DASH_URL').'.extras.destroy',$extra->id) }}"
                      method="post" style="display: inline-block">
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
