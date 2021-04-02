@php
 $name = isset($form_data) ?  $form_data->name : old("name");
 $a_name = isset($form_data) ?  $form_data->a_name : old("a_name");
 $img = isset($form_data) ? $form_data->image_path : asset('public/placeholder.png');
@endphp

<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
    <div class="form-group">
        <label for="name_input">@lang('site.name')</label>
        <input value="{{ $name }}" type="text" name="name"
               class="form-control" id="{{ 'name_input' }}"
               placeholder="@lang('site.name')">
        <span class="form_error" id="name_error"></span>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
    <div class="form-group">
        <label for="name_input">@lang('site.a_name')</label>
        <input value="{{ $a_name }}" type="text" name="a_name"
               class="form-control" id="{{ 'a_name_input' }}"
               placeholder="@lang('site.a_name')">
        <span class="form_error" id="a_name_error"></span>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
    <div class="form-group">
        <input id="icon_input" type="file" name="image" class="image" style="display: none">
        <button onclick="$('#icon_input').click()" type="button"
                class="btn btn-success">@lang('site.upload_image')</button>
        <img src="{{ $img }}" class="image-preview img-thumbnail" width="100" height="100">
        <span class="form_error" id="icon_error"></span>
    </div>
</div>
