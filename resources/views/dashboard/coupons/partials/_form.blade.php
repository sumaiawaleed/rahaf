@php
 $amount = isset($form_data) ?  $form_data->amount : old("amount");
 $thecount = isset($form_data) ?  $form_data->thecount : old("thecount");
@endphp

<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
    <div class="form-group">
        <label for="amount_input">@lang('site.amount')</label>
        <input value="{{ $amount }}" type="number" name="amount"
               class="form-control" id="{{ 'amount_input' }}"
               placeholder="@lang('site.amount')">
        <span class="form_error" id="amount_error"></span>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
    <div class="form-group">
        <label for="thecount_input">@lang('site.thecount')</label>
        <input value="{{ $thecount }}" type="number" name="thecount"
               class="form-control" id="{{ 'thecount_input' }}"
               placeholder="@lang('site.thecount')">
        <span class="form_error" id="thecount_error"></span>
    </div>
</div>
