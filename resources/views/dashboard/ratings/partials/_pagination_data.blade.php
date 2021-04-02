<table  class="table" id="table_data">
    <thead>
    <tr>
        <th>#</th>
        <th>@lang('site.user')</th>
        <th>@lang('site.products')</th>
        <th>@lang('site.rate')</th>
        <th>@lang('site.comment')</th>
        <th>@lang('site.date')</th>
        <th>@lang('site.action')</th>
    </tr>
    </thead>
    <tbody>
    @foreach($data['ratings'] as $index=>$rate)
        <tr>
            <td>{{ $rate->id }}</td>
            <td>
                {{ $rate->customer->name }}
            </td>
            <td>
                {{ $rate->product->getTranslateName(app()->getLocale()) }}
            </td>
            <td>
                {{ $rate->rate }}
            </td>
            <td>
                {{ $rate->comment }}
            </td>
            <td>
                {{ substr($rate->the_date,0,10) }}
            </td>
            <td>
                <a href="{{ route(env('DASH_URL').'.ratings.edit',$rate->id) }}" type="button"
                   class="btn btn-outline-warning btn-rounded"><span
                        class="icon-mode_edit"></span></a>
                <form class="delete-form" action="{{ route(env('DASH_URL').'.ratings.destroy',$rate->id) }}" method="post" style="display: inline-block">
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
