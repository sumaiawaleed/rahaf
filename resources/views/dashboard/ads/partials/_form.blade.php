@php
    $type = isset($form_data) ?  $form_data->type : old("type");
    $ad_id = isset($form_data) ?  $form_data->ad_id : 0;
    $img = isset($form_data) ? $form_data->image_path : asset('public/placeholder.png');
@endphp

@if($data['ad_id'] == 0)
    <input type="hidden" name="type" value="1">
    <input type="hidden" name="ad_id" value="0">
@else
    <input type="hidden" name="type" value="2">
    <input type="hidden" name="ad_id" value="{{ $data['ad_id'] }}">
@endif


<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
    <div class="form-group">
        <input id="icon_input" type="file" name="image" class="image" style="display: none">
        <button onclick="$('#icon_input').click()" type="button"
                class="btn btn-success">@lang('site.upload_image')</button>
        <img src="{{ $img }}" class="image-preview img-thumbnail" width="100" height="100">
        <span class="form_error" id="icon_error"></span>
    </div>
</div>
