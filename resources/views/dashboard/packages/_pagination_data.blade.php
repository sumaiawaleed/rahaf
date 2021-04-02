<table id="scrollVertical" class="table">
    <thead>
    <tr>
        <th>#</th>
        <th>@lang('site.name')</th>
        <th>@lang('site.features')</th>
        <th>@lang('site.total_ads')</th>
        <th>@lang('site.days')</th>
        <th>@lang('site.fees')</th>
        <th>@lang('site.user_type')</th>
        <th>@lang('site.action')</th>
    </tr>
    </thead>
    <tbody>
    @foreach($data['packages'] as $index=>$package)
        <tr>
            <td>{{ ++$index }}</td>
            <td>{{ $package->getTranslateName(app()->getLocale()) }}</td>
            <td>{{ $package->getTranslateFeatures(app()->getLocale()) }}</td>
            <td>{{ $package->total_ads }}</td>
            <td>{{ $package->fees }}</td>
            <td>{{ $package->type->name }}</td>
            <td>
                <a href="{{ route(env('DASH_URL').'.packages.edit',$package->id) }}" type="button"
                   class="btn btn-outline-warning btn-rounded"><span
                        class="icon-mode_edit"></span></a>
                <form action="{{ route(env('DASH_URL').'.packages.destroy',$package->id) }}" method="post" style="display: inline-block">
                    {{ csrf_field() }}
                    {{ method_field('delete') }}
                    <button type="submit" class="btn btn-outline-danger btn-rounded"><span
                            class="icon-trash-2"></span></button>
                </form>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
