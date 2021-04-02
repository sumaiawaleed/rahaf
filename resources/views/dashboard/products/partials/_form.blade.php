@php
    $sku = isset($form_data) ?  $form_data->sku : old("sku");
    $name = isset($form_data) ?  $form_data->name : old("name");
    $a_name = isset($form_data) ?  $form_data->a_name : old("a_name");
    $description = isset($form_data) ?  $form_data->description : old("description");
    $a_description = isset($form_data) ?  $form_data->a_description : old("a_description");
    $available = isset($form_data) ?  $form_data->available : 1;
    $price_type = isset($form_data) ?  $form_data->price_type : old("price_type");
    $price = isset($form_data) ?  $form_data->price : old("price");
    $offer_price = isset($form_data) ?  $form_data->offer_price : old("offer_price");
    $type = isset($form_data) ?  $form_data->type : old("type");
    $status = isset($form_data) ?  $form_data->status : old("status");
    $is_belong  = isset($form_data) ?  $form_data->is_belong  : old("is_belong");
    $main_catgeory_id = isset($form_data) ?  $form_data->main_catgeory_id : old("main_catgeory_id");
    $cat_id = isset($form_data) ?  $form_data->cat_id : old("cat_id");
    $brand_id = isset($form_data) ?  $form_data->brand_id : old("brand_id");
    $quantity = isset($form_data) ?  $form_data->quantity : old("quantity");
    $quantity_id = isset($form_data) ?  $form_data->quantity_id : 1;
    $var_type = isset($form_data) ?  $form_data->var_type : 1;
    $img = isset($form_data) ? $form_data->image_path : asset('public/placeholder.png');

@endphp

<div class="col-md-12">
    <div class="row">
        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
            <div class="form-group">
                <label for="name_input">sku</label>
                <input value="{{ $sku }}" type="text" name="sku"
                       class="form-control" id="{{ 'sku_input' }}"
                       placeholder="sku">
                <span class="form_error" id="sku_error"></span>
            </div>
        </div>
    </div>
</div>

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
        <label for="a_description_input">@lang('site.a_description')</label>
        <textarea name="a_description" class="form-control summernote" id="a_description_input">{!! $a_description !!}</textarea>
        <span class="form_error" id="a_description_error"></span>
    </div>
</div>

<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
    <div class="form-group">
        <label for="description_input">@lang('site.description')</label>
        <textarea name="description" class="form-control summernote" id="description_input">{!! $description !!}</textarea>
        <span class="form_error" id="description_error"></span>
    </div>
</div>


<div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
    <div class="form-group">
        <label for="price_type_input">@lang('site.price_type')</label>
        <br>
        <div class="custom-control custom-radio custom-control-inline">
            <input value="2" {{ $price_type == 2 ? "checked" : ""}} type="radio" id="customRadioInline1"
                   name="price_type" class="custom-control-input">
            <label class="custom-control-label" for="customRadioInline1">@lang('site.dollar')</label>
        </div>
        <div class="custom-control custom-radio custom-control-inline">
            <input value="1" {{ $price_type == 1 ? "checked" : ""}} type="radio" id="customRadioInline2"
                   name="price_type" class="custom-control-input">
            <label class="custom-control-label" for="customRadioInline2">@lang('site.ryal')</label>
        </div>
        <span class="form_error" id="price_type_error"></span>

    </div>
</div>

<div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-12">
    <div class="form-group">
        <label for="price_input">@lang('site.price')</label>
        <input value="{{ $price }}" type="text" name="price"
               class="form-control" id="{{ 'price_input' }}"
               placeholder="@lang('site.price')">
        <span class="form_error" id="price_error"></span>
    </div>
</div>

<div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-12">
    <div class="custom-control custom-switch" style="margin-top: 35px">
        <input  onchange="check_offer(value)" name="type" {{  ($type == 1 ? "checked" : "")  }} value="1" type="checkbox"
               class="custom-control-input" id="type_input">
        <label class="custom-control-label" for="type_input">@lang('site.type')</label>
    </div>
</div>

<div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-12"  {{ $type == 0 ? "style='display:none'" : "" }}>
    <div class="form-group" id="offer_div" style='display:none'>
        <label for="offer_price_input">@lang('site.offer_price')</label>
        <input value="{{ $offer_price }}" type="text" name="offer_price"
               class="form-control" id="{{ 'offer_price_input' }}"
               placeholder="@lang('site.offer_price')">
        <span class="form_error" id="offer_price_error"></span>
    </div>
</div>

<div class="col-xl-3 col-lg-3 col-md-6 col-sm-4 col-12">
    <div class="form-group">
        <label for="name_input">@lang('site.brands')</label>
        <select name="brand_id" class="form-control selectpicker" data-live-search="true">
            <option value="" selected>@lang('site.select')</option>
            @if(isset($data['brands']))
                @foreach( $data['brands'] as $m)
                    <option
                        {{ $brand_id == $m->id ? "selected" : "" }} value="{{ $m->id }}">{{ $m->getTranslateName(app()->getLocale()) }}</option>
                @endforeach
            @endif
        </select>
        <span class="form_error" id="brand_id_error"></span>
    </div>
</div>



{{--<div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">--}}
{{--    <div class="custom-control custom-switch" style="margin-top: 35px">--}}
{{--        <input name="status" {{  ($status == 1 ? "checked" : "")  }} value="1" type="checkbox"--}}
{{--               class="custom-control-input" id="status_input">--}}
{{--        <label class="custom-control-label" for="status_input">@lang('site.status')</label>--}}
{{--    </div>--}}
{{--</div>--}}


<div class="col-xl-3 col-lg-3 col-md-6 col-sm-4 col-122">
    <div class="custom-control custom-switch" style="margin-top: 35px">
        <input name="is_belong" {{  ($is_belong == 1 ? "checked" : "")  }} value="1" type="checkbox"
               class="custom-control-input" id="is_belong_input">
        <label class="custom-control-label" for="is_belong_input">@lang('site.is_belong')</label>
    </div>
</div>


<div class="col-xl-3 col-lg-3 col-md-6 col-sm-4 col-12">
    <div class="form-group">
        <label for="quantity_id_input">@lang('site.quantity')</label>
       <select class="form-control" name="quantity_id" id="quantity_id_input">
           <option>@lang('site.select')</option>
           @foreach($data['quantities'] as $q)
               <option {{ $q->id == $quantity_id ? "selected" : "" }} value="{{ $q->id }}">
                   {{ $q->getTranslateName(app()->getLocale()) }}
               </option>
           @endforeach
       </select>
        <span class="form_error" id="quantity_error"></span>
    </div>
</div>

<div class="col-xl-3 col-lg-3 col-md-6 col-sm-4 col-12">
    <div class="form-group">
        <label for="quantity_input">@lang('site.quantity')</label>
        <input value="{{ $quantity }}" type="text" name="quantity"
               class="form-control" id="quantity_input"
               placeholder="@lang('site.quantity')">
        <span class="form_error" id="quantity_error"></span>
    </div>
</div>


</div>

<div class="row">
    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-4 col-12">
        <div class="form-group">
            <label for="name_input">@lang('site.main_categories')</label>
            <select onchange="load_categories(value)" name="main_catgeory_id" class="form-control selectpicker" data-live-search="true">
                <option selected>@lang('site.select')</option>
                @foreach( $data['main_categories'] as $m)
                    <option
                        {{ $main_catgeory_id == $m->id ? "selected" : "" }} value="{{ $m->id }}">{{ $m->getTranslateName(app()->getLocale()) }}</option>
                @endforeach
            </select>
            <span class="form_error" id="main_catgeory_id_error"></span>
        </div>
    </div>

    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-4 col-12">
        <div class="form-group">
            <label for="name_input">@lang('site.categories')</label>
            <select onchange="load_sub_categories(value)" id="categories_area" name="cat_id" class="form-control selectpicker" data-live-search="true">
                <option selected>@lang('site.select')</option>
                @if(isset($data['categories']))
                    @foreach( $data['categories'] as $m)
                        <option
                            {{ $cat_id == $m->id ? "selected" : "" }} value="{{ $m->id }}">{{ $m->getTranslateName(app()->getLocale()) }}</option>
                    @endforeach
                @endif
            </select>
            <span class="form_error" id="cat_id_error"></span>
        </div>
    </div>

</div>

<div class="row">
    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
        <div class="form-group">
            <input id="icon_input" type="file" name="image" class="image" style="display: none">
            <button onclick="$('#icon_input').click()" type="button"
                    class="btn btn-success">@lang('site.upload_image')</button>
            <img src="{{ $img }}" class="image-preview img-thumbnail" width="100" height="100">
            <span class="form_error" id="icon_error"></span>
        </div>
    </div>

    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
        <div class="form-group">
            <label for="var_type_input">@lang('site.var_type')</label>
            <br>
            <div class="custom-control custom-radio custom-control-inline">
                <input value="2" {{ $var_type == 2 ? "checked" : ""}} type="radio" id="customRadioInline3"
                       name="var_type" class="custom-control-input">
                <label class="custom-control-label" for="customRadioInline3">@lang('site.flever')</label>
            </div>
            <div class="custom-control custom-radio custom-control-inline">
                <input value="1" {{ $var_type == 1 ? "checked" : ""}} type="radio" id="customRadioInline4"
                       name="var_type" class="custom-control-input">
                <label class="custom-control-label" for="customRadioInline4">@lang('site.color')</label>
            </div>
            <span class="form_error" id="var_type_error"></span>

        </div>
    </div>


    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
        <div class="custom-control custom-switch" style="margin-top: 35px">
            <input name="available" {{  ($available == 1 ? "checked" : "")  }} value="1" type="checkbox"
                   class="custom-control-input" id="available_input">
            <label class="custom-control-label" for="available_input">@lang('site.available')</label>
        </div>
    </div>
</div>
