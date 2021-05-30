@php
    $driver_id = isset($form_data) ?  $form_data->driver_id : old("driver_id");
    $user_address = isset($form_data) ?  $form_data->user_address : old("user_address");
    $total_price= isset($form_data) ?  $form_data->total_price: old("total");
    $user_lat = isset($form_data) ?  $form_data->user_lat : old("user_lat");
    $user_log = isset($form_data) ?  $form_data->user_log : old("user_log");
    $status = isset($form_data) ?  $form_data->status : old("status");
    $note = isset($form_data) ?  $form_data->note : old("note");

@endphp
<div class="row">
    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
        <div class="form-group">
            <label for="name">@lang('site.name')</label>
            <input disabled value="{{ ($form_data->user) ? $form_data->user->name : '' }}" type="text" name="name"
                   class="form-control" id="name"
                   placeholder="@lang('site.name')">
            <span class="form_error" id="name"></span>
        </div>
    </div>

    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
        <div class="form-group">
            <label for="user_address">@lang('site.user_address')</label>
            <input value="{{ $user_address }}" type="text" name="user_address"
                   class="form-control" id="user_address"
                   placeholder="@lang('site.user_address')">
            <span class="form_error" id="user_address_error"></span>
        </div>
    </div>

    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
        <div class="form-group">
            <label for="total_price">@lang('site.total')</label>
            <input value="{{ $total_price}}" type="number" name="total_price"
                   class="form-control" id="total_price"
                   placeholder="@lang('site.total')">
            <span class="form_error" id="total_price_error"></span>
        </div>
    </div>



    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
        <div class="form-group">
            <label>@lang('site.status')</label><br>
            <select onchange="check_driver(value)" class="form-control" name="status">
                @foreach(__('orders') as $index => $order )
                    <option {{ $index == $status ? "selected" : "" }} value="{{ $index }}">{{ $order }}</option>
                @endforeach
            </select>

            <span class="form_error" id="status_error"></span>
        </div>
    </div>
    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
        <div class="form-group {{ $status > 1 ? 'd-block' : 'd-none' }}" id="driver_id_group">
            <label for="driver_id">@lang('site.driver')</label>
            <select name="driver_id" class="form-control" id="driver_id">
                <option value="">@lang('site.select')</option>
                @foreach($data['drivers'] as $t)
                    <option {{ $driver_id == $t->id ? "selected" : "" }} value="{{ $t->id }}">
                        {{ $t->name }}
                    </option>
                @endforeach
            </select>
            <span class="form_error" id="driver_id_error"></span>
        </div>
    </div>

    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="form-group">
            <label for="note">@lang('site.notes')</label>
            <textarea class="form-control" name="note" id="note"
                      placeholder="@lang('site.notes')">{{ $note }}</textarea>
            <span class="form_error" id="note_error"></span>
        </div>
    </div>

    <input type="hidden" name="lat" id="lat" value="{{ $user_lat }}">
    <input type="hidden" name="log" id="log" value="{{ $user_log }}">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mb-5" style="height: 300px;" id="map"></div>

</div>
