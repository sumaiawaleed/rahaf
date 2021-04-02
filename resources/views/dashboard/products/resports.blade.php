@extends('layout.dashboard.app')
@section('content')
    <div class="main-container">
        <div class="page-title">
            <div class="row gutters">
                <div class="col-xl-9 col-lg-9 col-md-9 col-sm-12 col-12">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#"><i class="@lang('icons.categories')"></i></a></li>
                            <li class="breadcrumb-item"><a
                                    href="{{ route(env('DASH_URL').'.home') }}">@lang('site.home')</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $data['title'] }}</li>
                        </ol>
                    </nav>
                </div>

            </div>
        </div>
        <div class="content-wrapper">
            <div class="row gutters">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-8">
                                    <form id="search_form" action="{{ route(env('DASH_URL').'.products.index') }}">
                                        <div class="form-inline">
                                            <div class="form-group mx-sm-3 mb-2">
                                                <label for="search" class="sr-only">@lang('site.key_word')</label>
                                                <input value="{{ $request->search }}" id="search" name="search" type="text"
                                                       class="form-control"
                                                       placeholder="@lang('site.key_word')">
                                            </div>

                                            <div class="form-group mx-sm-3 mb-2">
                                                <label for="search" class="sr-only">@lang('site.key_word')</label>

                                            </div>

                                            <button type="submit" class="btn btn-primary mb-2">@lang('site.search')</button>
                                        </div>
                                    </form>

                                </div>
                                <div class="col-md-4">
                                    <div class="form-group mx-sm-3 mb-2">
                                        <button onclick="$('#basicModal').modal('show');"
                                                class="btn btn-primary mb-2">@lang('site.search_filter')</button>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row gutters" id="data">
                @if($data['products']->count() > 0)
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

                        <div class="card">
                            <div class="card-body">

                                <div class="table-responsive" id="table_data">
                                    @include('dashboard.products.partials._report_page')
                                </div>
                            </div>
                        </div>
                    </div>


                @else
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="card">
                            <div class="card-body">
                                <h3 class="text-center">@lang('site.no_data')</h3>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
        @endsection

        @push('scripts')
            <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.2/css/buttons.bootstrap4.min.css">
            <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap4.min.css">
            <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
            <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
            <script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
            <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.bootstrap4.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
            <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
            <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>
            <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.colVis.min.js"></script>
            <script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
            <script src="https://cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap4.min.js"></script> <script>
                $(document).ready(function() {
                    var table = $('#example').DataTable( {
                        lengthChange: false,
                        buttons: [ 'copy', 'excel', 'csv', 'pdf', 'colvis' ]
                    } );

                    table.buttons().container()
                        .appendTo( '#example_wrapper .col-md-6:eq(0)' );
                } );
            </script>
            <div class="modal fade" id="basicModal" tabindex="-1" role="dialog" aria-labelledby="basicModalLabel" aria-hidden="true" style="display: none;">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="basicModalLabel">@lang('site.search')</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <form id="search_form" action="{{ route(env('DASH_URL').'.products.index') }}">

                            <div class="modal-body">
                                <div class="col-xl-12 col-lg lg-12 col-md-12 col-sm-12 col-12">
                                    <div class="form-group">
                                        <label>@lang('site.name')</label>
                                        <input value="{{ $request->search }}" name="search" type="text" class="form-control"  placeholder="@lang('site.search')">
                                    </div>
                                </div>

                                <div class="col-xl-4 col-lglg-4 col-md-4 col-sm-4 col-12">
                                    <div class="form-group">
                                        <label for="sku">sku</label>
                                        <input value="{{ $request->sku }}" name="sku" type="text" class="form-control"  placeholder="sku"></div>
                                </div>


                                <div class="form-group row">
                                    <div class="col-12">
                                        <label for="inputName">@lang('site.status')</label>
                                    </div>
                                    <div class="col-6">
                                        <input type="radio" {{ $request->status == 1 ? "checked" : "" }} name="status" value="1">متاح
                                    </div>
                                    <div class="col-6">
                                        <input type="radio" {{ $request->status == 2 ? "checked" : "" }} name="status" value="0">غير متاح
                                    </div>
                                </div>


                                <div class="col-xl-4 col-lglg-4 col-md-4 col-sm-4 col-12">
                                    <div class="form-group">
                                        <label for="inputName">@lang('site.less_7')</label>
                                        <input type="checkbox" name="q" value="1">
                                    </div>
                                </div>



                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">@lang('site.search')</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

    @endpush
