@php
 $name = isset($form_data) ?  $form_data->name : old("name");
 $a_name = isset($form_data) ?  $form_data->a_name : old("a_name");
 $color = isset($form_data) ? $form_data->color : old('color');
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

