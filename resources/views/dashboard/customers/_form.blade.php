<div class="row gutters">
    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
        <div class="form-group">
            @php $name = isset($user) ? $user->name : old('name'); @endphp
            <label for="name_input">@lang('site.name')</label>
            <input value="{{ $name }}" type="text" name="name"
                   class="form-control" id="name_input"
                   placeholder="@lang('site.name')">
            <span class="form_error" id="name_error"></span>
        </div>
    </div>

   @if(isset($data['types']) and $data['types']->count() > 0)
        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
            <div class="form-group">
                @php $type = isset($user) ? $user->type : old('type'); @endphp
                <label for="type_input">@lang('site.type')</label>
                <select id="type_input" name="type" class="form-control" required>
                    <option>@lang('site.select')</option>
                    @foreach($data['types'] as $t)
                        <option {{ $type == $t->id ? "selected" : "" }} value="{{ $t->id }}">
                            {{ $t->getTranslateName(app()->getLocale()) }}
                        </option>
                    @endforeach
                </select>
                <span class="form_error" id="type_error"></span>
            </div>
        </div>
    @endif

    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
        <div class="form-group">
            @php $email = isset($user) ? $user->email : old('email'); @endphp
            <label for="email_input">@lang('site.email')</label>
            <input value="{{ $email }}" type="email" name="email" class="form-control"
                   id="email_input" placeholder="@lang('site.email')">
            <span class="form_error" id="email_error"></span>
        </div>
    </div>

    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
        <div class="form-group">
            @php $phone = isset($user) ? $user->phone_number : old('phone_number'); @endphp
            <label for="phone_number_input">@lang('site.phone')</label>
            <input value="{{ $phone }}" type="tel" name="phone_number"
                   class="form-control"
                   id="phone_number_input" placeholder="@lang('site.phone')">
            <span class="form_error" id="phone_number_error"></span>
        </div>
    </div>

    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
        <div class="form-group">
            @php $address = isset($user) ? $user->address : old('address'); @endphp
            <label for="address_input">@lang('site.address')</label>
            <input value="{{ $address }}" type="tel" name="address" class="form-control"
                   id="address_input" placeholder="@lang('site.address')">
            <span class="form_error" id="address_error"></span>
        </div>
    </div>

    @if(!isset($user))
        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
            <div class="form-group">
                <label for="password_input">@lang('site.password')</label>
                <input type="password" name="password"
                       class="form-control" id="password_input"
                       placeholder="@lang('site.password')">
                <span class="form_error" id="password_error"></span>
            </div>
        </div>
    @endif

    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
        <div class="form-group">
            @php $img = isset($user) ? $user->getImageSize(100,100) : asset('public/placeholder.png'); @endphp
            <input id="icon_input" type="file" name="image" class="image" style="display: none">
            <button onclick="$('#icon_input').click()" type="button"
                    class="btn btn-success">@lang('site.upload_logo')</button>
            <img src="{{ $img }}" class="image-preview img-thumbnail" width="100" height="100">
            <span class="form_error" id="icon_error"></span>
        </div>
    </div>
</div>

