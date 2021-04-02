@extends('layouts.app')
@section('content')
    <div class="breadcrumb-main ">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="breadcrumb-contain">
                        <div>
                            <h2>@lang('site.cart')</h2>
                            <ul>
                                <li><a href="/">@lang('site.home')</a></li>
                                <li><i class="fa fa-angle-double-right"></i></li>
                                <li><a href="#">@lang('site.cart')</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb End -->


    <section class="cart-section section-big-py-space bg-light">
        <div class="custom-container">
            <div class="row">
                <div class="col-sm-12">
                    @if($data['cart'])
                        @php
                            $total = 0;
                        @endphp
                        <table class="table cart-table table-responsive-xs">
                            <thead>
                            <tr class="table-head">
                                <th scope="col">@lang('site.image')</th>
                                <th scope="col">@lang('site.product_name')</th>
                                <th scope="col">@lang('site.price')</th>
                                <th scope="col">@lang('site.quantity')</th>
                                <th scope="col">@lang('site.action')</th>
                                <th scope="col">@lang('site.total')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($data['cart']->items  as $item)
                                <tr>
                                    <td>
                                        <a href="{{ route('product.show',$item['id']) }}"><img
                                                src="{{ $item['image'] }}"
                                                alt="cart"
                                                class=" "></a>
                                    </td>
                                    <td><a href="{{ route('product.show',$item['id']) }}">{{ $item['title'] }}</a>
                                        <div class="mobile-cart-content row">
                                            <div class="col-xs-3">
                                                <div class="qty-box">
                                                    <div class="input-group">
                                                        <input type="text" name="quantity"
                                                               class="form-control input-number"
                                                               value="{{ $item['qty'] }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xs-3">
                                                <h2 class="td-color">{{ $item['price'] }}</h2></div>
                                            <div class="col-xs-3">
                                                <h2 class="td-color">
                                                    <form class="delete_cart_form" method="post" action="{{ route('delete_cart') }}">
                                                        {{ method_field('post') }}
                                                        {{ csrf_field() }}
                                                        <button class="icon delete_cart_btn"><i class="ti-close"></i></button>
                                                    </form>
                                                </h2>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <h2>{{ number_format($item['price']) }}</h2></td>
                                    <td>
                                        <div class="qty-box">
                                            <div class="input-group">
                                                <form class="rahaf_edit_cart" method="post" action="{{ route('edit_cart') }}">
                                                    {{ csrf_field() }}
                                                    {{ method_field('post') }}
                                                    <input type="hidden" name="id" value="{{ $item['id'] }}">
                                                    <input type="number" name="quantity" class="form-control input-number"
                                                           value="{{ $item['qty'] }}">
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <form class="delete_cart" method="post" action="{{ route('delete_cart') }}">
                                            {{ method_field('post') }}
                                            {{ csrf_field() }}
                                            <input type="hidden" name="id" value="{{ $item['id'] }}">
                                            <a  onclick="this.closest('form').submit()" style="cursor: pointer" class="icon delete_cart_btn"><i class="ti-close"></i></a>
                                        </form>
                                    </td>
                                    <td>
                                        @php
                                            $total += $item['price'] * $item['qty'];
                                        @endphp
                                        <h2 class="td-color">{{ number_format($item['price'] * $item['qty']) }}</h2>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <table class="table cart-table table-responsive-md">
                            <tfoot>
                            <tr>
                                <td>@lang('site.total_price'):</td>
                                <td>
                                    <h2 id="#total">{{ number_format($total) }}</h2></td>
                            </tr>
                            </tfoot>
                        </table>
                    @else
                        <h3 class="text-center">@lang('site.no_data')</h3>
                    @endif
                </div>
            </div>
            <div class="row cart-buttons">
                <div class="col-12"><a href="{{ route('products') }}"
                                       class="btn btn-normal">@lang('site.continue_shopping')</a>
                    @if($data['cart'])
                        <a href="{{ route('checkout') }}" class="btn btn-normal ml-3">@lang('site.checkout')</a></div>
                @endif
            </div>
        </div>
    </section>
@endsection


@push('scripts')
    <script>
        $('input[name=quantity]').change(function() {
            this.closest('form').submit();
        });

        $(".rahaf_edit_cart").submit(function (e) {
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
                        $('#total').text(result.all);

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


        $(".delete_cart_form").submit(function (e) {
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
                        $.notify({
                            icon: 'fa fa-check',
                            title: '',
                            message: '{{ __('site.deleted_successfully') }}'
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

        $('.delete_cart_btn').on('click',function (e) {
            e.preventDefault();
            var that = $(this);
            confirm = window.confirm('{{ __('site.confirm_delete') }}');
            if (confirm("Press a button!")) {
                that.closest('form').submit();
            }
        })

    </script>


@endpush
