<table  class="table" id="table_data">
    <thead>
    <tr>
        <th>#</th>
        <th>@lang('site.user')</th>
        <th>@lang('site.products')</th>
        <th>@lang('site.action')</th>
    </tr>
    </thead>
    <tbody>
    @foreach($data['favourites'] as $index=>$favourite)
        <tr>
            <td>{{ ++$index }}</td>
            <td>
                {{ $favourite->customer->name }}
            </td>
            <td>
                {{ $favourite->product->getTranslateName(app()->getLocale()) }}
            </td>
            <td>
                <form class="delete-form" action="{{ route(env('DASH_URL').'.favourites.destroy',$favourite->id) }}" method="post" style="display: inline-block">
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
