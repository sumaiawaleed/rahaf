@php
 $name = isset($form_data) ?  $form_data->name : old("name");
 $phone = isset($form_data) ?  $form_data->phone : old("phone");
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
        <label for="name_input">@lang('site.phone')</label>
        <input value="{{ $phone }}" type="tel" name="phone"
               class="form-control" id="{{ 'phone_input' }}"
               placeholder="@lang('site.phone')">
        <span class="form_error" id="phone_error"></span>
    </div>
</div>


