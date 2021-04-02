<div class="row gutters">

    @foreach(LaravelLocalization::getSupportedLocales() as $locale => $properties)
        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
            <div class="form-group">
                @php $name[$locale] = isset($package) ? $package->getTranslateName($locale) : ""; @endphp

                <label for="name_input">@lang('site.' . $locale . '.name')</label>
                <input value="{{ $name[$locale] }}" type="text" name="{{ $locale.'_name' }}"
                       class="form-control" id="{{ $locale.'_name_input' }}"
                       placeholder="@lang('site.' . $locale . '.name')">
                <span class="form_error" id="{{ $locale }}_name_error"></span>
            </div>
        </div>
    @endforeach

    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
        <div class="form-group">
            @php $user_type = isset($package) ? $package->user_type : old('user_type'); @endphp
            <label for="user_type_input">@lang('site.type')</label>
            <select id="user_type_input" name="user_type" class="form-control" required>
                <option>@lang('site.select')</option>
                @foreach($data['types'] as $t)
                    <option {{ $user_type == $t->id ? "selected" : "" }} value="{{ $t->id }}">
                        {{ $t->getTranslateName(app()->getLocale()) }}
                    </option>
                @endforeach
            </select>
            <span class="form_error" id="user_type_error"></span>
        </div>
    </div>

    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
        <div class="form-group">
            @php $total_ads = isset($package) ? $package->total_ads : old('total_ads'); @endphp
            <label for="phone_number_input">@lang('site.total_ads')</label>
            <input value="{{ $total_ads }}" type="number" name="total_ads"
                   class="form-control"
                   id="total_ads_input" placeholder="@lang('site.total_ads')">
            <span class="form_error" id="phone_total_ads"></span>
        </div>
    </div>

    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
        <div class="form-group">
            @php $days = isset($package) ? $package->days : old('days'); @endphp
            <label for="phone_number_input">@lang('site.days')</label>
            <input value="{{ $days }}" type="number" name="days"
                   class="form-control"
                   id="days_input" placeholder="@lang('site.days')">
            <span class="form_error" id="phone_days"></span>
        </div>
    </div>

    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
        <div class="form-group">
            @php $fees = isset($package) ? $package->fees : old('fees'); @endphp
            <label for="phone_number_input">@lang('site.fees')</label>
            <input value="{{ $fees }}" type="number" name="fees"
                   class="form-control"
                   id="fees_input" placeholder="@lang('site.fees')">
            <span class="form_error" id="phone_fees"></span>
        </div>
    </div>


    @foreach(LaravelLocalization::getSupportedLocales() as $locale => $properties)
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="form-group">
                @php $features[$locale] = isset($package) ? $package->getTranslatefeatures($locale) : ""; @endphp

                <label for="name_input">@lang('site.' . $locale . '.features')</label>
                <textarea name="{{ $locale.'_features' }}"
                          class="form-control" id="{{ $locale.'_features_input' }}"
                          placeholder="@lang('site.' . $locale . '.features')" class="form-control"
                >{{ $features[$locale] }}</textarea>
                <span class="form_error" id="{{ $locale }}_features_error"></span>
            </div>
        </div>
    @endforeach
</div>

