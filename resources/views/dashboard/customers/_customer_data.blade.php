<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

    <div class="card">
        <div class="card-body">
            <div class="table-responsive" id="table_data">
                @include('dashboard.customers._pagination_data')
            </div>
        </div>
    </div>
</div>
<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
    <div class="card">
        <div class="card-body">
            <nav aria-label="Page navigation example">
                {{ $data['customers']->appends(request()->query())->links() }}
            </nav>
        </div>
    </div>
</div>
