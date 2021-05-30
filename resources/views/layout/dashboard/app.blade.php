<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" href="{{ asset('public/favicon.ico') }}" />
    <title>@lang('site.title') | {{ $data['title'] }}</title>
    @if(app()->getLocale() == 'en')
        <link rel="stylesheet" href="{{ asset('public/dash_assets/css/bootstrap.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('public/dash_assets/fonts/style.css') }}">
        <link rel="stylesheet" href="{{ asset('public/dash_assets/css/main.css?v=4') }}">
        <link rel="stylesheet" href="{{ asset('public/dash_assets/vendor/daterange/daterange.css') }}" />

    @else
        <link rel="stylesheet" href="{{ asset('public/dash_assets/css/ar_bootstrap.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('public/dash_assets/fonts/ar_style.css') }}">
        <link rel="stylesheet" href="{{ asset('public/dash_assets/css/ar_main.css?v=3') }}">
        <link rel="stylesheet" href="{{ asset('public/dash_assets/vendor/daterange/daterange.css') }}" />
    @endif
    <style>
        .form_error{
            color: red;
        }
    </style>
    @stack('styles')
</head>
<body dir="{{ app()->getLocale() == 'ar' ? 'rtl' :'' }}">

<!-- Loading starts -->
<div id="loading-wrapper">
    <div class="spinner-border text-apex-yellow" role="status">
        <span class="sr-only">Loading...</span>
    </div>
</div>
<!-- Loading ends -->

<div class="container">
    @include('layout.dashboard.header')
    @include('layout.dashboard.menu')
    @yield('content')
</div>

<script src="{{ asset('public/dash_assets/js/jquery.min.js')}}"></script>
<script src="{{ asset('public/dash_assets/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{ asset('public/dash_assets/js/nav.min.js')}}"></script>
<script src="{{ asset('public/dash_assets/js/moment.js')}}"></script>
<script src="{{ asset('public/dash_assets/vendor/daterange/daterange.js')}}"></script>
<div  style="height: 150px; position: absolute; top: 50%; left: 50%; z-index: 1000">
    <div id="msgs" class="toast" aria-live="assertive" aria-atomic="true"
         data-autohide="false">
        <div class="toast-header">
            <i class="icon-bubble_chart"></i>
            <span class="title" id="msg_title"></span>
            <button type="button" class="close" data-dismiss="toast" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="toast-body" id="msg_txt">
        </div>
    </div>
</div>
<script>
    //delete
    $('.delete').click(function (e) {

        var that = $(this)

        e.preventDefault();

        var n = new Noty({
            text: "",
            type: "warning",
            killer: true,
            buttons: [
                Noty.button("@lang('site.yes')", 'btn btn-success mr-2', function () {
                    that.closest('form').submit();
                }),

                Noty.button("@lang('site.no')", 'btn btn-primary mr-2', function () {
                    n.close();
                })
            ]
        });

        n.show();

    });//end of delete

</script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<script>

    $(".delete-form").submit(function (e) {
        var selected_tr = $(this).closest("tr");
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
                    selected_tr.remove();
                    Swal.fire({
                        icon: 'success',
                        title: '@lang('site.deleted_successfully')',
                        showConfirmButton: false,
                        timer: 1500
                    })
                } else {
                    selected_tr.remove();
                    Swal.fire({
                        icon: 'success',
                        title: '@lang('site.restore_successfully')',
                        showConfirmButton: false,
                        timer: 1500
                    })
                }
            },
            error: function (data) {

            }
        });
    });

    $('.delete-btn').on('click',function (e) {
        var that = $(this);
        e.preventDefault();
        Swal.fire({
            title: "@lang('site.confirm_delete')",
            text: "",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: "@lang('site.yes')",
            cancelButtonText: "@lang('site.no')",
        }).then((result) => {
            if (result.isConfirmed) {
                that.closest('form').submit();
            }
        })
    })

    $('.restore-btn').on('click',function (e) {
        var that = $(this);
        e.preventDefault();
        Swal.fire({
            title: "@lang('site.confirm_restore')",
            text: "",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: "@lang('site.yes')",
            cancelButtonText: "@lang('site.no')",
        }).then((result) => {
            if (result.isConfirmed) {
                that.closest('form').submit();
            }
        })
    })
</script>
@stack('scripts')


<!-- Main Js Required -->
<script src="{{ asset('public/dash_assets/js/main.js')}}"></script>

</body>
</html>
