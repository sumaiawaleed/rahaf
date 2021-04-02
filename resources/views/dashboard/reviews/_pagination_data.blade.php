<table  class="table" id="table_data">
    <thead>
    <tr>
        <th>#</th>
        <th>@lang('site.user_name')</th>
        <th>@lang('site.product')</th>
        <th>@lang('site.rate')</th>
        <th>@lang('site.comment')</th>
        <th>@lang('site.date')</th>
        <th>@lang('site.action')</th>
    </tr>
    </thead>
    <tbody>
    @foreach($data['reviews'] as $index=>$review)
        <tr>
            <td>{{ $review->id }}</td>
            <td>
                <a href="{{ route(env('DASH_URL').'.customers.show',$review->user_id) }}">
                    {{ $review->user->name }}
                </a>
            </td>
            <td>
                <a href="{{ route(env('DASH_URL').'.products.show',$review->ad_id) }}">
                    {{ $review->product->getTranslateName(app()->getLocale()) }}
                </a>
            </td>
            <td>
                {{$review->stars }}
            </td>
            <td>
                {{$review->review }}
            </td>
            <td>
                {{ substr($review->created_at,0,10) }}
            </td>
            <td>
                <a href="{{ route(env('DASH_URL').'.reviews.edit',$review->id) }}" type="button"
                   class="btn btn-outline-warning btn-rounded"><span
                        class="icon-mode_edit"></span></a>
                @if($review->is_deleted == 0)
                    <form class="delete-form" action="{{ route(env('DASH_URL').'.reviews.destroy',$review->id) }}"
                          method="post" style="display: inline-block">
                        {{ csrf_field() }}
                        {{ method_field('delete') }}
                        <button type="submit" class="btn btn-outline-danger btn-rounded delete-btn"><span
                                class="icon-folder1"></span></button>
                    </form>
                @else
                    <form class="delete-form" action="{{ route(env('DASH_URL').'.reviews/restore',['rate_id' => $review->id]) }}"
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
