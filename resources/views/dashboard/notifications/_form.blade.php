@php
$message = isset($note) ? $note->message : old('message');
$title = isset($note) ? $note->title : old('title');
$topic = isset($note) ? $note->topic : old('topic');
@endphp
<div class="card-body">
    <div class="row gutters">
        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
            <div class="form-group">
                <label for="title">@lang('site.name')</label>
                <input name="title" id="title" value="{{ $title }}" class="form-control">
                <span class="form_error" id="title_error"></span>
            </div>
        </div>
        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
            <div class="form-group">
                <label for="topic">@lang('site.users')</label>
                <select name="topic" class="form-control">
                    <option>@lang('site.select')</option>
                    <option value="all">@lang('site.all')</option>
                    <option value="users">@lang('site.register_users')</option>
                    <option value="non_users">@lang('site.non_register_users')</option>
                    <option value="android">@lang('site.android')</option>
                    <option value="iphone">@lang('site.iphone')</option>

                </select>
                <span class="form_error" id="users_error"></span>
            </div>
        </div>
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="form-group">
                <label for="message">@lang('site.message')</label>
                <textarea name="message" id="message" class="form-control">{{ $message }}</textarea>
                <span class="form_error" id="message_error"></span>
            </div>
        </div>
    </div>
</div>

