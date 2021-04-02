<form class="edit_form"
      method="post" action="{{ route(env('DASH_URL').'.customers.update',$user->id) }}" enctype="multipart/form-data">
    {{ method_field('put') }}
    {{ csrf_field() }}
    @include('dashboard.customers._form')
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 text-center">
            <button class="btn btn-outline-primary" type="submit">
                @lang('site.edit')
            </button>
        </div>
    </div>
</form>
