@extends('layout.dashboard.app')
@section('content')
    <div class="main-container">
        <div class="page-title">
            <div class="row gutters">
                <div class="col-xl-9 col-lg-9 col-md-9 col-sm-12 col-12">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#"><i class="@lang('icons.orders')"></i></a></li>
                            <li class="breadcrumb-item"><a
                                    href="{{ route(env('DASH_URL').'.home') }}">@lang('site.home')</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">@lang('site.orders')</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12 text-right">
                    <a href="{{ route(env('DASH_URL').'.orders.create') }}"
                       class="btn btn-success mb-2 pull-right">@lang('site.add_category')</a>
                </div>
            </div>
        </div>
        <div class="content-wrapper">
            <div class="row gutters">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                    <div class="card">
                        <div class="card-body p-0">
                            <div class="invoice-container">

                                <div class="invoice-header">
                                    <!-- Row start -->
                                    <div class="row gutters">
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
                                            <div class="invoice-logo">
                                                <span class="text-danger">R</span><span
                                                    class="text-warning">e</span><span
                                                    class="text-success">t</span><span class="text-info">a</span><span
                                                    class="text-royal-orange">i</span><span
                                                    class="text-jungle-green">l</span>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                            <div class="btn-group float-right">
                                                <a href="#" class="btn btn-outline-info btn-sm">
                                                    <i class="icon-export"></i> Export PDF
                                                </a>
                                                <a href="#" class="btn btn-outline-danger btn-sm ml-2">
                                                    <i class="icon-printer"></i> Print
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Row end -->
                                </div>

                                <div class="invoice-address">
                                    <!-- Row start -->
                                    <div class="row gutters">
                                        <div class="col-lg-4 col-md-4 col-sm-4">
                                            <small>@lang('site.to')</small><br><br>
                                            <h6>
                                                <a href="{{ route(env('DASH_URL').'.customers.show',$data['order']->user_id) }}">
                                                    {{ $data['customer']->name }}</a>
                                            </h6>
                                            <address>
                                                @lang('site.address') : {{ $data['order']->user_address }}
                                            </address>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-4">
                                            <h6>@lang('site.other')</h6>
                                            <address>
                                               @lang('site.driver') : {{ $data['driver'] }}<br>
                                                @lang('site.status') : {{ $data['order']->status_name }}
                                            </address>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-4">
                                            <div class="invoice-details">
                                                <small>@lang('site.order_number') - <span class="badge badge-info">#{{ $data['order']->id }}</span></small><br>
                                                <small>{{ substr($data['order']->date,0,10) }}</small><br>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Row end -->
                                </div>

                                <div class="invoice-body">

                                    <!-- Row start -->
                                    <div class="row gutters">
                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                            <p><b>@lang('site.notes')</b></p>
                                            <p>{{ $data['order']->notes }}</p>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6">

                                        </div>
                                    </div>
                                    <!-- Row end -->

                                    <!-- Row start -->
                                    <div class="row gutters">
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <div class="table-responsive">
                                                <table class="table">
                                                    <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>@lang('site.product')</th>
                                                        <th>@lang('site.color')</th>
                                                        <th>@lang('site.price')</th>
                                                        <th>@lang('site.quantity')</th>
                                                        <th>@lang('site.sub_quantity')</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @php $total = 0; @endphp
                                                   @foreach($data['details'] as $index=>$d)
                                                       <tr>
                                                           <td>{{ ++$index }}</td>
                                                           <td>
                                                               <a href="{{ route(env('DASH_URL').'.products.show',$d->product->id) }}">
                                                               {{ $d->product->name }}
                                                               </a>
                                                           </td>
                                                          <td>
                                                              <button type="button" class="btn btn-sm" style="width:50px; height:20px;background: {{ $d->color->color }}">

                                                              </button>
                                                          </td>
                                                           <td>{{ number_format($d->price) }}</td>
                                                           <td>{{ $d->quantity }}</td>
                                                           <td>{{ ($d->sub_quntity) ? $d->sub_quntity->name : "" }}</td>
                                                       </tr>
                                                       @php $total += $d->price * $d->quantity; @endphp
                                                   @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Row end -->

                                    <!-- Row start -->
                                    <div class="invoice-payment">
                                        <div class="row gutters">
                                            <div class="col-lg-6 col-md-6 col-sm-12">
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-12 order-last">
                                                <table class="table no-border m-0">
                                                    <tbody>
                                                    <tr>
                                                        <td>
                                                            <h5 class="text-danger"><strong>@lang('site.total')</strong></h5>
                                                        </td>
                                                        <td>
                                                            <h5 class="text-danger"><strong>{{ $total }}</strong></h5>
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Row end -->

                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
