
@if ((session('success')) || (session('failure')))
    <script type="text/javascript">
        //alert(session('success'));
        $(function() {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top', //'top-end'
                showConfirmButton: false,
                closeOnConfirm: true,
                timer: 3000
            });
            @if (session('success'))
            //toastr.success("{/{ session('success') }}");
            Toast.fire({
                type: 'success',
                title: "@lang('site.success')",
                text: "{{ session('success') }}",
            });
            @endif
            @if (session('failure'))
                //toastr.error("{/{ session('failure') }}");
            Toast.fire({
                type: 'error',
                title: "@lang('site.failure')",
                text: "{{ session('failure') }}",
            });
            @endif

        });

    </script>



        <script>
/*
        //alert("{/{ session('success') }}");
        new Noty({
            type: 'success',
            layout: 'topRight',
            text: "{/{ session('success') }}",
            timeout: 2000,
            killer: true
        }).show();
        */
    </script>

@endif
