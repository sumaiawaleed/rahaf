@php
    $name = isset($form_data) ?  $form_data->name : old("name");
    $a_name = isset($form_data) ?  $form_data->a_name : old("a_name");
    $details = isset($form_data) ?  $form_data->details : old("details");
    $a_details = isset($form_data) ?  $form_data->a_details : old("a_details");
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


<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
    <div class="form-group">
        <label for="details_input">@lang('site.details')</label>
        <textarea name="details" class="form-control summernote" id="details_input">{!! $details !!}</textarea>
        <span class="form_error" id="details_error"></span>
    </div>
</div>

<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
    <div class="form-group">
        <label for="a_details_input">@lang('site.a_details')</label>
        <textarea name="a_details" class="form-control summernote" id="a_details_input">{!! $a_details !!}</textarea>
        <span class="form_error" id="a_details_error"></span>
    </div>
</div>


