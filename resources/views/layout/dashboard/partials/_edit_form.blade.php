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

    $(".edit_new_form").submit(function (e) {
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
                result = jQuery.parseJSON(data);

                if (result.success) {

                    Swal.fire({
                        icon: 'success',
                        title: "@lang('site.data_updated_successfully')",
                        showConfirmButton: false,
                        timer: 1500
                    })
                    $('input').removeClass('is-invalid');
                    $('select').removeClass('is-invalid');
                    $('textarea').removeClass('is-invalid');
                    $('.form_error').text('');
                    main_url = String(window.location.href);
                    let path = main_url.split("/");
                    var new_path = path.slice(0, -2);
                    main_url = new_path.join("/")
                    window.location.replace(main_url);
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
