@php
    $type = isset($form_data) ?  $form_data->type : old("type");
    $ad_id = isset($form_data) ?  $form_data->ad_id : 0;
    $img = isset($form_data) ? $form_data->image_path : asset('public/placeholder.png');
@endphp

<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
    <div class="form-group">
        <label for="type_input">@lang('site.type')</label>
        <select name="type" class="form-control" onchange="check_ad(value)">
            <option value="">@lang('site.select')</option>
            <option value="1">@lang('site.product')</option>
            <option value="2">@lang('site.brands')</option>
            <option value="3">@lang('site.ad')</option>
        </select>
        <span class="form_error" id="type_error"></span>
    </div>
</div>

<script>
    function check_ad(type) {
        if(type == 1){
            $('.extra_ad').hide();
            $('#product_id_container').show();
        }else if(type == 2){
            $('.extra_ad').hide();
            $('#brand_id_container').show();
        }else{
            $('.extra_ad').hide();
        }
    }
</script>

<div style="display: none" class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12 extra_ad" id="product_id_container">
    <div class="form-group">
        <label for="product_id_input">sku</label>
        <input type="text" name="sku" id="sku" class="form-control">
        <span class="form_error" id="product_id_error"></span>
    </div>
</div>

<div style="display: none" class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12 extra_ad" id="brand_id_container">
    <div class="form-group">
        <label for="brand_id_input">@lang('site.brands')</label>
        <select name="brand_id" class="form-control">
            <option>@lang('site.select')</option>
            @foreach($data['brands'] as $brand)
                <option value="{{ $brand->id }}">{{ $brand->name }}</option>
            @endforeach
        </select>
        <span class="form_error" id="brand_id_error"></span>
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
