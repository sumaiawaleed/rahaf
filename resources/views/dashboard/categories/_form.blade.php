<div class="card-body">
    <div class="row gutters">
        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
            <div class="form-group">
                <label for="main_category">@lang('site.main_category')</label>
                <select onchange="load_subs(value)" name="main_category" id="main_category" class="form-control selectpicker"
                        data-live-search="true">
                    <option selected>@lang('site.select')</option>
                    @foreach( $data['main_categories'] as $m)
                        <option value="{{ $m->id }}">{{ $m->getTranslateName(app()->getLocale()) }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
            <div class="form-group">
                <label for="sub_categories">@lang('site.sub_categories')</label>
                <select id="sub_categories" class="form-control" name="sub_categories"></select>
            </div>
        </div>

        @foreach(LaravelLocalization::getSupportedLocales() as $locale => $properties)
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                <div class="form-group">
                    @php $name[$locale] = isset($category) ? $category->getTranslateName($locale) : ""; @endphp

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
                @php $img = isset($category) ? $category->getImageSize(100,100) : asset('public/placeholder.png'); @endphp
                <input id="icon_input" type="file" name="icon" class="image" style="display: none">
                <button onclick="$('#icon_input').click()" type="button"
                        class="btn btn-success">@lang('site.upload_logo')</button>
                <img src="{{ $img }}" class="image-preview img-thumbnail" width="100" height="100">
                <span class="form_error" id="icon_error"></span>
            </div>
        </div>

    </div>

</div>

