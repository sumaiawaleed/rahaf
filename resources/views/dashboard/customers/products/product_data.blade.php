@if($data['ads']->count() > 0)
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="row" id="product_data">
            @include('dashboard.ads._pagination_data')
        </div>
    </div>
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="card">
            <div class="card-body">
                <nav aria-label="Page navigation example" id="products_pagination">
                    {{ $data['ads']->appends(request()->query())->links() }}
                </nav>
            </div>
        </div>
    </div>
@else
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <h3 class="text-center">@lang('site.no_data')</h3>
    </div>
@endif
