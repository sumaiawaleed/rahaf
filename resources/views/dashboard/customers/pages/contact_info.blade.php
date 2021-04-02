<form method="post" action="{{ route(env('DASH_URL').'.customer/contacts') }}" class="edit_form">
    {{ csrf_field() }}
    {{ method_field('post') }}
    <input type="hidden" name="user_id" value="{{ $user->id }}">
    @foreach($data['contacts'] as $contact)
        <div class="row">
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                <div class="form-group">
                    <label for="social_{{ $contact->id }}_input">{{ $contact->name }}</label>
                    <input value="{{ ($contact->user) ?  $contact->user->value  : ""}}" type=""
                           name="social_{{ $contact->id }}"
                           class="form-control"
                           id="social_{{ $contact->id }}_input" placeholder="{{ $contact->name }}">
                    <span class="form_error" id="social_{{ $contact->id }}_error"></span>
                </div>
            </div>


            <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-12">
                <div class="custom-control custom-switch" style="margin-top: 35px">
                    <input name="{{ $contact->id }}_status" {{ ($contact->user) ? ($contact->user->is_visible == 1 ? "checked" : "") :"" }} value="1" type="checkbox" class="custom-control-input" id="customSwitch{{ $contact->id }}">
                    <label class="custom-control-label" for="customSwitch{{ $contact->id }}">@lang('site.show')</label>
                </div>
            </div>

        </div>
    @endforeach
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 text-center">
            <button class="btn btn-outline-primary" type="submit">
                @lang('site.edit')
            </button>
        </div>
    </div>
</form>
