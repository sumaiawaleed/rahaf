<!-- My account bar start-->
<div id="myAccount" class="add_to_cart right account-bar">
    <a href="javascript:void(0)" class="overlay" onclick="closeAccount()"></a>
    <div class="cart-inner">
        <div class="cart_top">
            <h3>@lang('site.login')</h3>
            <div class="close-cart">
                <a href="javascript:void(0)" onclick="closeAccount()">
                    <i class="fa fa-times" aria-hidden="true"></i>
                </a>
            </div>
        </div>
        <form method="post" class="theme-form login_form" action="{{ route('postLogin') }}">
            {{ method_field('post') }}
            {{ csrf_field() }}
            <div class="row">
                <div class="col-md-12">
                    <div class="login_error_msgs"></div>
                </div>
            </div>
            <div class="form-group">
                <label for="phone">@lang('site.phone')</label>
                <input type="text" class="form-control" id="phone" name="phone" placeholder="@lang('site.phone')" required="">
            </div>
            <div class="form-group">
                <label for="review">@lang('site.password')</label>
                <input type="password" class="form-control" name="password" id="review" placeholder="@lang('site.password')" required="">
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-rounded btn-block ">@lang('site.login')</button>
            </div>
            <div>
                <h6 class="forget-class"><a href="{{ route('register') }}" class="d-block">@lang('site.new_user_message')</a></h6>
            </div>
        </form>
    </div>
</div>
<!-- Add to account bar end-->

<script>
    $(".login_form").submit(function (e) {
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var actionurl = e.currentTarget.action;
        $.ajax({
            type: 'POST',
            url: actionurl,
            data: new FormData(this),
            dataType: 'text',
            processData: false,
            contentType: false,
            success: function (data) {
                result = jQuery.parseJSON(data);
                if (result.success == true) {
                    $('.login_form').trigger('reset');
                    location.reload();
                } else {
                    var errors = result.errors;
                    var html_errors = '<ul>';
                    html_errors += "<li>" + result.msg + "<\li>";

                    $('#error').html('');
                    $.each(errors, function (key, val) {
                        html_errors += "<li>" + val[0] + "<\li>";
                    });
                    html_errors += '</ul>';
                    $('.login_error_msgs').addClass('login-alert');
                    $('.login_error_msgs').html(html_errors);
                }
            },
            error: function (data) {

            }
        });
    });
</script>
