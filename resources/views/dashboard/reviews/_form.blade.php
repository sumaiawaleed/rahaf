@php
$comment = isset($review) ? $review->review : old('comment');
@endphp
<div class="card-body">
    <div class="row gutters">

        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="form-group">
                <label for="comment">@lang('site.comment')</label>
                <textarea name="comment" id="comment" class="form-control">{{ $comment }}</textarea>
            </div>
        </div>
    </div>
</div>

