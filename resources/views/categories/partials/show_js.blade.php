<script type="text/javascript">

    var site_url = encodeURIComponent(location.href);
    function shareOnFB() {
        var url = "https://www.facebook.com/sharer/sharer.php?u=" + site_url;
        window.open(url, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');
        return false;
    }


    function shareOntwitter() {
        var url = 'https://twitter.com/intent/tweet?url=' + site_url + '&via=getboldify&text=yourtext';
        window.open(url, 'TwitterWindow', width = 600, height = 300);
        return false;
    }

    function shareOnInsta() {
        var url = 'www.instagram.com/sharer.php?u=' + site_url;
        window.open(url, 'TwitterWindow', width = 600, height = 300);
        return false;
    }

    function shareOnlinkedin() {

        var url = 'http://www.linkedin.com/shareArticle?mini=true&url=' + site_url;
        window.open(url, 'TwitterWindow', width = 600, height = 300);
        return false;
    }


    function shareOnwhatsup() {
        var url = 'https://whatsapp.com/send?text=' + site_url;
        window.open(url, 'TwitterWindow', width = 600, height = 300);
        return false;
    }

    $(".rahaf-wishlist-form-details").submit(function (e) {
        selected_form = $(this);
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
                    $.notify({
                        icon: 'fa fa-check',
                        title: 'Success!',
                        message: result.msg
                    }, {
                        element: 'body',
                        position: null,
                        type: "info",
                        allow_dismiss: true,
                        newest_on_top: false,
                        showProgressbar: false,
                        placement: {
                            from: "top",
                            align: "right"
                        },
                        offset: 20,
                        spacing: 10,
                        z_index: 1031,
                        animate: {
                            enter: 'animated fadeInDown',
                            exit: 'animated fadeOutUp'
                        },
                        icon_type: 'class',
                    });

                    if (result.type == 1) {
                        $('#fav_' + result.id).html(
                            '  <input type="hidden" value="' + result.id + '" name="id">\n' +
                            '                                    <button class="wishlist-btn" type="submit" data-id="' + result.id + '"\n' +
                            '                                            title="{{ __('site.remove_from_wishlist') }}">\n' +
                            '                                        <i id="whish_icon_' + result.id + '" class="fa fa-heart"></i>\n' +
                            '<span class="title-font">{{ __('site.remove_from_wishlist') }}</span> \n'+
                            '</button>'
                        );
                    } else {
                        $('#fav_' + result.id).html(
                            '  <input type="hidden" value="' + result.id + '" name="id">\n' +
                            '                                    <button class="wishlist-btn" type="submit" data-id="' + result.id + '"\n' +
                            '                                            title="{{ __('site.add_to_wishlist') }}">\n' +
                            '                                        <i id="whish_icon_' + result.id + '" class="fa fa-heart-o"></i>\n' +
                            '<span class="title-font">{{ __('site.add_to_wishlist') }}</span> \n'+
                            '                                    </button>'
                        );
                    }
                } else {
                    var errors = result.errors;
                    var html_errors = '<ul>';

                    $('#error').html('');
                    $.each(errors, function (key, val) {
                        $("#" + key + "_error").text(val[0]);
                        $("#" + key + "_input").addClass('is-invalid');
                        html_errors += "<li>" + val[0] + "<\li>";
                    });
                    html_errors += '</ul>';
                }
            },
            error: function (data) {

            }
        });
    });

    $('.delete-rate-btn').on('click',function (e) {
        var that = $(this);
        e.preventDefault();
        var r = confirm("@lang('site.confirm_delete')");
        if (r == true) {
            that.closest('form').submit();
        }
    });

    $(document).ready(function(){

        /* 1. Visualizing things on Hover - See next part for action on click */
        $('#stars li').on('mouseover', function(){
            var onStar = parseInt($(this).data('value'), 10); // The star currently mouse on

            // Now highlight all the stars that's not after the current hovered star
            $(this).parent().children('li.star').each(function(e){
                if (e < onStar) {
                    $(this).addClass('hover');
                }
                else {
                    $(this).removeClass('hover');
                }
            });

        }).on('mouseout', function(){
            $(this).parent().children('li.star').each(function(e){
                $(this).removeClass('hover');
            });
        });


        /* 2. Action to perform on click */
        $('#stars li').on('click', function(){
            var onStar = parseInt($(this).data('value'), 10); // The star currently selected
            var stars = $(this).parent().children('li.star');

            for (i = 0; i < stars.length; i++) {
                $(stars[i]).removeClass('selected');
            }

            for (i = 0; i < onStar; i++) {
                $(stars[i]).addClass('selected');
            }

            // JUST RESPONSE (Not needed)
            var ratingValue = parseInt($('#stars li.selected').last().data('value'), 10);

            responseMessage(ratingValue);

        });


    });


    function responseMessage(msg) {
        if(msg == 1){
            $('#rate_value').val(5);
        }else if(msg == 2){
            $('#rate_value').val(4);
        }else if(msg == 4){
            $('#rate_value').val(2);
        }else if(msg == 5){
            $('#rate_value').val(1);
        }
    }

    function check_color(id){
        alert(id);
    }

</script>

<style>


    .new-react-version {
        padding: 20px 20px;
        border: 1px solid #eee;
        border-radius: 20px;
        box-shadow: 0 2px 12px 0 rgba(0,0,0,0.1);

        text-align: center;
        font-size: 14px;
        line-height: 1.7;
    }

    .new-react-version .react-svg-logo {
        text-align: center;
        max-width: 60px;
        margin: 20px auto;
        margin-top: 0;
    }





    .success-box {
        margin:50px 0;
        padding:10px 10px;
        border:1px solid #eee;
        background:#f9f9f9;
    }

    .success-box img {
        margin-right:10px;
        display:inline-block;
        vertical-align:top;
    }

    .success-box > div {
        vertical-align:top;
        display:inline-block;
        color:#888;
    }



    /* Rating Star Widgets Style */
    .rating-stars ul {
        list-style-type:none;
        padding:0;

        -moz-user-select:none;
        -webkit-user-select:none;
    }
    .rating-stars ul > li.star {
        display:inline-block;

    }

    /* Idle State of the stars */
    .rating-stars ul > li.star > i.fa {
        font-size:2.5em; /* Change the size of the stars */
        color:#ccc; /* Color on idle state */
    }

    /* Hover state of the stars */
    .rating-stars ul > li.star.hover > i.fa {
        color:#FFCC36;
    }

    /* Selected state of the stars */
    .rating-stars ul > li.star.selected > i.fa {
        color:#FF912C;
    }

</style>
