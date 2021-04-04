@php
    $product_id = $data['product_id'] ;
    $color_id = isset($form_data) ?  $form_data->color_id : 17;
    $quantity = isset($form_data) ?  $form_data->quantity : old("quantity");
    $img = isset($form_data) ? $form_data->image_path : asset('public/placeholder.png');
@endphp
<input type="hidden" name="product_id" value="{{ $product_id }}">

    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
        <div class="form-group">
            @if($data['pro']->var_type == 1)
            <label for="color_id_input">@lang('site.color')</label>
           <select name="color_id" class="form-control selectpicker" data-show-subtext="true" data-live-search="true" id="color_id_input">
               <option value="">@lang('site.select')</option>
               @foreach($data['colors'] as $color)
                   <option class="text-white" {{ $color_id == $color->id ? "selected" : "" }} style="background: {{ $color->color }}" value="{{ $color->id }}">
                       {{ $color->getTranslateName() }}
                   </option>
               @endforeach
           </select>
            @else
                <label for="color_id_input">@lang('site.flever')</label>
                <select name="color_id" data-live-search="true" data-live-search-style="startsWith" class="selectpicker form-control">
                    <option value="">@lang('site.select')</option>
                    @foreach($data['colors'] as $color)
                        <option data-tokens="{{ $color->getTranslateName() }}" {{ $color_id == $color->id ? "selected" : "" }}  value="{{ $color->id }}">{{ $color->getTranslateName() }}</option>
                    @endforeach
                </select>
            @endif
            <span class="form_error" id="color_id_error"></span>
        </div>
    </div>

    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
        <div class="form-group">
            <label for="name_input">@lang('site.quantity')</label>
            <input value="{{ $quantity }}" type="text" name="quantity"
                   class="form-control" id="{{ 'quantity_input' }}"
                   placeholder="@lang('site.quantity')">
            <span class="form_error" id="quantity_error"></span>
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
