<script>
    $(".rahaf-wishlist-form").submit(function (e) {
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
                            '                                    <button type="submit" data-id="' + result.id + '"\n' +
                            '                                            title="{{ __('site.remove_from_wishlist') }}">\n' +
                            '                                        <i id="whish_icon_' + result.id + '" class="fa fa-heart"></i>\n' +
                            '                                    </button>'
                        );
                    } else {
                        $('#fav_' + result.id).html(
                            '  <input type="hidden" value="' + result.id + '" name="id">\n' +
                            '                                    <button type="submit" data-id="' + result.id + '"\n' +
                            '                                            title="{{ __('site.add_to_wishlist') }}">\n' +
                            '                                        <i id="whish_icon_' + result.id + '" class="fa fa-heart-o"></i>\n' +
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
</script>
