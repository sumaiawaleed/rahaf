@php
    $name = isset($form_data) ?  $form_data->name : old("name");
    $phone = isset($form_data) ?  $form_data->phone : old("phone");
    $country_code = isset($form_data) ?  $form_data->country_code : old("country_code");
    $address = isset($form_data) ?  $form_data->address : old("address");
    $lat = isset($form_data) ?  $form_data->lat : old("lat");
    $log = isset($form_data) ?  $form_data->log : old("log");
    $gender = isset($form_data) ?  $form_data->gender : old("gender");
@endphp
<div class="card-body">
    <div class="row gutters">
        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
            <div class="form-group">
                <label for="name_input">@lang('site.name')</label>
                <input value="{{ $name }}" type="text" name="name"
                       class="form-control" id="name"
                       placeholder="@lang('site.name')">
                <span class="form_error" id="name_error"></span>
            </div>
        </div>

        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
            <div class="form-group">
                <label for="gender">@lang('site.gender')</label>
                <div class="custom-control custom-radio custom-control-inline">
                    <input {{ $gender == 1 ? "checked" : "" }} type="radio"  id="gender1" name="gender"
                           class="custom-control-input" value="1">
                    <label class="custom-control-label" for="gender1">@lang("site.male")</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                    <input value="2" {{ $gender == 2 ? "checked" : "" }} type="radio" id="gender2" name="gender" class="custom-control-input">
                    <label class="custom-control-label" for="gender2">@lang("site.female")</label>
                </div>
            </div>
        </div>

        <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-12">
            <div class="form-group">
                <label for="country_code">@lang('site.country_code')</label>
                <input value="{{ $country_code }}" type="tel" name="country_code"
                       class="form-control" id="country_code"
                       placeholder="@lang('site.country_code')">
                <span class="form_error" id="country_code_error"></span>
            </div>
        </div>
        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
            <div class="form-group">
                <label for="phone">@lang('site.phone')</label>
                <input value="{{ $phone }}" type="tel" name="phone"
                       class="form-control" id="phone"
                       placeholder="@lang('site.phone')">
                <span class="form_error" id="phone_error"></span>
            </div>
        </div>

        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
            <div class="form-group">
                <label for="address">@lang('site.address')</label>
                <input value="{{ $address }}" type="text" name="address"
                       class="form-control" id="address"
                       placeholder="@lang('site.address')">
                <span class="form_error" id="address_error"></span>
            </div>
        </div>


        <input type="hidden" name="lat" id="lat" value="{{ $lat }}">
        <input type="hidden" name="log" id="log" value="{{ $log }}">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" style="height: 300px;" id="map"></div>

    </div>
</div>
