<script>
    function load_categories(value) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({

            url: "{{ route('categories/get_sub') }}" + "?id=" + value,
            success: function (data) {
                console.log(data);
                $('#categories_area').html(data);
            }
        });
    }


    function load_sub_categories(value) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({

            url: "{{ route('sub_categories/get_sub') }}" + "?id=" + value,
            success: function (data) {
                console.log(data);
                $('#sub_categories_area').html(data);
            }
        });
    }

    function check_offer(value){
        if(value == 1){
            $('#offer_div').css('display','block');
        }else{
            $('#offer_div').css('display','block');
        }
    }
</script>
