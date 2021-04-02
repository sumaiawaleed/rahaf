<div class="row gutters">

    @foreach(LaravelLocalization::getSupportedLocales() as $locale => $properties)
        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
            <div class="form-group">
                @php $name[$locale] = isset($store) ? $store->getTranslateName($locale) : ""; @endphp

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
                @php $category_id = isset($store) ? $store->category_id : old('category_id'); @endphp
                <label for="category_id_input">@lang('site.category')</label>
                <select id="category_id_input" name="category_id" class="form-control" required>
                    <option>@lang('site.select')</option>
                    @foreach($data['categories'] as $t)
                        <option {{ $category_id == $t->id ? "selected" : "" }} value="{{ $t->id }}">
                            {{ $t->getTranslateName(app()->getLocale()) }}
                        </option>
                    @endforeach
                </select>
                <span class="form_error" id="category_id_error"></span>
            </div>
        </div>

        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
            <div class="form-group">
                @php $img = isset($store) ? $store->getImageSize(100,100) : asset('public/placeholder.png'); @endphp
                <input id="logo_input" type="file" name="logo" class="image" style="display: none">
                <button onclick="$('#logo_input').click()" type="button" class="btn btn-success">@lang('site.upload_logo')</button>
                <img src="{{ $img }}" class="image-preview img-thumbnail" width="100" height="100">
                <span class="form_error" id="logo_error"></span>
            </div>
        </div>

    @foreach(LaravelLocalization::getSupportedLocales() as $locale => $properties)
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="form-group">
                @php $details[$locale] = isset($store) ? $store->getTranslateDetails($locale) : ""; @endphp

                <label for="name_input">@lang('site.' . $locale . '.details')</label>
                <textarea name="{{ $locale.'_details' }}"
                          class="form-control" id="{{ $locale.'_details_input' }}"
                          placeholder="@lang('site.' . $locale . '.details')" class="form-control"
                >{{ $details[$locale] }}</textarea>
                <span class="form_error" id="{{ $locale }}_details_error"></span>
            </div>
        </div>
    @endforeach

        @foreach(LaravelLocalization::getSupportedLocales() as $locale => $properties)
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                <div class="form-group">
                    @php $address[$locale] = isset($store) ? $store->getTranslateaddress($locale) : ""; @endphp

                    <label for="address_input">@lang('site.' . $locale . '.address')</label>
                    <input value="{{ $address[$locale] }}" type="text" name="{{ $locale.'_address' }}"
                           class="form-control" id="{{ $locale.'_address_input' }}"
                           placeholder="@lang('site.' . $locale . '.address')">
                    <span class="form_error" id="{{ $locale }}_address_error"></span>
                </div>
            </div>
        @endforeach


</div>

