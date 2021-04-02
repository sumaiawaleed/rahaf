@if($data['stores']->count() > 0)
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive" id="table_data">
                    @include('dashboard.stores._pagination_data')
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="card">
            <div class="card-body">
                <nav aria-label="Page navigation example">
                    {{ $data['stores']->appends(request()->query())->links() }}
                </nav>
            </div>
        </div>
    </div>
@else
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <h3 class="text-center">@lang('site.no_data')</h3>
    </div>
@endif
