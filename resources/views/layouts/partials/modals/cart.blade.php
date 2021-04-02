<!-- Add to cart bar -->
<div id="cart_side" class=" add_to_cart top">
    <a href="javascript:void(0)" class="overlay" onclick="closeCart()"></a>
    <div class="cart-inner">
        <div class="cart_top">
            <h3>my cart</h3>
            <div class="close-cart">
                <a href="javascript:void(0)" onclick="closeCart()">
                    <i class="fa fa-times" aria-hidden="true"></i>
                </a>
            </div>
        </div>
        <div class="cart_media" id="cart_content">

        </div>
    </div>
</div>
<!-- Add to cart bar end-->

<script>
    $(".rahaf-cart-form").submit(function (e) {
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
                if (result.success) {
                    $('#count_cart_items').text(result.all);

                    $.notify({
                        icon: 'fa fa-check',
                        title: '',
                        message: result.message
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
                }else{
                    $.notify({
                        icon: 'fa fa-remove',
                        title: '',
                        message: result.message
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
                }
            },
            error: function (data) {

            }
        });
    });

    $('#view_cart_form').submit(function (e) {
        e.preventDefault();
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });
      var actionurl = "{{ route('view_cart_model') }}";
      $.ajax({
          type: 'POST',
          url: actionurl,
          data: new FormData(this),
          dataType: 'text',
          processData: false,
          contentType: false,
          success: function (data) {
              alert(data);
            $('#cart_content').html(data);
              document.getElementById("cart_side").classList.add('open-side');

          },
          error: function (data) {

          }
      });
  });
</script>
