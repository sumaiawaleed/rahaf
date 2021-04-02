<div class="row" style="border-bottom:  1px solid #cecece; margin-bottom: 20px">
    <div class="col-xl-9 col-lg-9 col-md-9 col-sm-12 col-12">
        <h1 class="text-left">@lang('site.ads') </h1>
    </div>
    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12 text-right">
        <a href="{{ route(env('DASH_URL').'.products.create',['user_id'=> $user->id]) }}" class="btn btn-success mb-2 pull-right">إضافة منتج</a>
    </div>
</div>
@include('dashboard.ads._ad_data')
