@extends('layout.dashboard.app')
@section('content')
    <div class="main-container">
        <div class="page-title">
            <div class="row gutters">
                <div class="col-xl-9 col-lg-9 col-md-9 col-sm-12 col-12">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#"><i class="@lang('icons.packages')"></i></a></li>
                            <li class="breadcrumb-item"><a href="#">@lang('site.home')</a></li>
                            <li class="breadcrumb-item active" aria-current="page">@lang('site.user_request')</li>
                        </ol>
                    </nav>
                </div>

            </div>
        </div>

        <div class="content-wrapper">


            <!-- Row start -->
            <div class="row gutters">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

                    <div class="card">
                        <div class="card-body">

                            <div class="table-responsive">
                                <table id="scrollVertical" class="table">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>@lang('site.customer_name')</th>
                                        <th>@lang('site.package_name')</th>
                                        <th>@lang('site.status')</th>
                                        <th>@lang('site.action')</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>customer name</td>
                                        <td>
                                        package name</td>
                                        <td>
                                            <span class="badge badge-warning">@lang('site.pending')</span>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-outline-danger btn-rounded"><span
                                                    class="icon-trash-2"></span></button>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>2</td>
                                        <td>customer name</td>
                                        <td>
                                            package name</td>
                                        <td>
                                            <span class="badge badge-danger">@lang('site.rejected')</span>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-outline-danger btn-rounded"><span
                                                    class="icon-trash-2"></span></button>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>3</td>
                                        <td>customer name</td>
                                        <td>
                                            package name</td>
                                        <td>
                                            <span class="badge badge-success">@lang('site.accepted')</span>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-outline-danger btn-rounded"><span
                                                    class="icon-trash-2"></span></button>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Row end -->


        </div>
        @endsection

        @push('styles')
            <link rel="stylesheet" href="{{ asset('public/dash_assets/css/pricing.css') }}">
    @endpush

