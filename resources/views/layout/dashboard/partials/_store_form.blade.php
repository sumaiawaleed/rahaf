<script>
    $(".image").change(function () {

        if (this.files && this.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('.image-preview').attr('src', e.target.result);
            }

            reader.readAsDataURL(this.files[0]);
        }

    });
    $(".add_new_form").submit(function (e) {
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
            beforeSend: function(){
                $("#loading-wrapper").show();
            },
            complete: function(){
                $("#loading-wrapper").hide();
            },
            success: function (data) {
                $("#loading-wrapper").hide();
                console.log(data);
                result = jQuery.parseJSON(data);

                if (result.success) {
                    $(".add_new_form").trigger('reset');
                    $(".image-preview").attr('src','{{ asset('public/placeholder.png') }}');
                    Swal.fire({
                        icon: 'success',
                        title: '@lang('site.data_added_successfully')',
                        showConfirmButton: false,
                        timer: 1500
                    }).then(function () {
                        main_url = String(window.location.href);
                        let path = main_url.split("/");
                        path.pop(); // remove the last
                        main_url = path.join("/")
                        window.location.replace(main_url);
                    });
                    // $('.add_new_form').trigger('reset');
                    $('input').removeClass('is-invalid');
                    $('select').removeClass('is-invalid');
                    $('textarea').removeClass('is-invalid');
                    $('.form_error').text('');
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
                    console.log(html_errors);
                }
            },
            error: function (data) {

            }
        });
    });
</script>
