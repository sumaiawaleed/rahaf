@php
    $name = isset($form_data) ?  $form_data->name : old("name");
    $a_name = isset($form_data) ?  $form_data->a_name : old("a_name");
    $quantity_id = isset($form_data) ? $form_data->quantity_id : old('quantity_id');
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
        <label for="quantity_id_input">@lang('site.quantity')</label>
        <select class="form-control" name="quantity_id" id="quantity_id">
            <option>@lang('site.select')</option>
            @foreach($data['quantities'] as $q)
                <option {{ $quantity_id == $q->id ? "selected" : "" }} value="{{ $q->id }}">{{ $q->getTranslateName(app()->getLocale()) }}</option>
            @endforeach
        </select>
        <span class="form_error" id="quantity_id_error"></span>
    </div>
</div>


