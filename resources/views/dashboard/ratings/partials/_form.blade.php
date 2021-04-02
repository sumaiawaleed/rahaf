@php
 $rate = isset($form_data) ?  $form_data->rate : old("rate");
 $comment = isset($form_data) ?  $form_data->comment : old("comment");
@endphp
<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
    <div class="form-group">
        <label for="name_input">@lang('site.rate')</label>
        <input value="{{ $rate }}" type="text" name="rate"
               class="form-control" id="{{ 'rate_input' }}"
               placeholder="@lang('site.rate')">
        <span class="form_error" id="rate_error"></span>
    </div>
</div>

<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
    <div class="form-group">
        <label for="comment_input">@lang('site.comment')</label>
        <textarea name="comment" id="comment_input" class="form-control">{{ $comment }}</textarea>
        <span class="form_error" id="comment_error"></span>
    </div>
</div>
