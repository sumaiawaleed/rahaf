<form class="edit_form" method="post" action="{{ route(env('DASH_URL').'.customer/change_password') }}">
    {{ csrf_field() }}
    {{ method_field('post') }}
    <input type="hidden" name="id" value="{{ $form_data->id }}">
    <div class="row">
        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
            <div class="form-group">
                <input type="password"
                       name="password"
                       class="form-control"
                       id="password_input" placeholder="@lang('site.new_password')">
                <span class="form_error" id="password_error"></span>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
            <div class="form-group">
                <input type="password"
                       name="password_confirmation"
                       class="form-control"
                       id="password_confirmation_input" placeholder="@lang('site.password_confirmation')">
                <span class="form_error" id="password_confirmation_error"></span>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 text-center">
            <button class="btn btn-outline-primary" type="submit">
                @lang('site.edit')
            </button>
        </div>
    </div>
</form>
