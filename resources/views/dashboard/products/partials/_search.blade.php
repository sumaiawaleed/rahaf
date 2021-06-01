<div class="modal fade" id="basicModal" tabindex="-1" role="dialog" aria-labelledby="basicModalLabel"
     aria-hidden="true" style="display: none;">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="basicModalLabel">@lang('site.search')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            @php
            $url = isset($search_url) ? $search_url :  route(env('DASH_URL').'.products.index') ;
            @endphp
            <form id="search_form" action="{{ $url }}">

                <div class="modal-body">
                    <div class="col-xl-12 col-lg lg-12 col-md-12 col-sm-12 col-12">
                        <div class="form-group">
                            <label>@lang('site.name')</label>
                            <input value="{{ \Illuminate\Support\Facades\Cache::get('search') }}" name="search" type="text"
                                   class="form-control" placeholder="@lang('site.search')">
                        </div>
                    </div>

                    <div class="col-xl-4 col-lglg-4 col-md-4 col-sm-4 col-12">
                        <div class="form-group">
                            <label for="sku">sku</label>
                            <input  value="{{ \Illuminate\Support\Facades\Cache::get('sku') }}" name="sku" type="text" class="form-control"
                                    placeholder="sku"></div>
                    </div>


                    <div class="form-group row">
                        <div class="col-12">
                            <label for="inputName">@lang('site.status')</label>
                        </div>
                        <div class="col-4">
                            <input {{ \Illuminate\Support\Facades\Cache::get('status') == 1 ? "checked" : "" }} type="radio" {{ $request->status == 1 ? "checked" : "" }} name="status"
                                   value="1">متاح
                        </div>
                        <div class="col-4">
                            <input {{ \Illuminate\Support\Facades\Cache::get('status') == 2 ? "checked" : "" }} type="radio" {{ $request->status == 2 ? "checked" : "" }} name="status"
                                   value="2">غير متاح
                        </div>
                        <div class="col-4">
                            <input type="radio" {{ \Illuminate\Support\Facades\Cache::get('status') == 0 ? "checked" : "" }} name="status"
                                   value="3">@lang('site.all')
                        </div>
                    </div>

                    <hr>
                    <div class="form-group row">
                        <div class="col-12">
                            <label for="inputName">@lang('site.var_type')</label>
                        </div>
                        <div class="col-4">
                            <input {{ \Illuminate\Support\Facades\Cache::get('var_type') == 1 ? "checked" : "" }} type="radio" name="var_type"
                                   value="1">@lang('site.color')
                        </div>
                        <div class="col-4">
                            <input type="radio" {{ \Illuminate\Support\Facades\Cache::get('var_type') == 2 ? "checked" : "" }} name="var_type"
                                   value="2">@lang('site.flever')
                        </div>
                        <div class="col-4">
                            <input type="radio" {{ \Illuminate\Support\Facades\Cache::get('var_type') == 3 ? "checked" : "" }} name="var_type"
                                   value="3">@lang('site.all')
                        </div>
                    </div>
                    <hr>

                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="form-group">
                            <label for="inputName">@lang('site.less_7')</label>

                            <div class="row">
                                <div class="col-md-4">
                                    <input type="radio" name="operation" {{ \Illuminate\Support\Facades\Cache::get('operation') == 1 ? "checked" : "" }} value="1"> = <br>
                                </div>
                                <div class="col-md-4">
                                    <input type="radio" name="operation" {{ \Illuminate\Support\Facades\Cache::get('operation') == 2 ? "checked" : "" }} value="2"> أصغر <br>
                                </div>
                                <div class="col-md-4">
                                    <input type="radio" name="operation" {{ \Illuminate\Support\Facades\Cache::get('operation') == 3 ? "checked" : "" }} value="3"> أكبر <br>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-4 col-lglg-4 col-md-4 col-sm-4 col-12">
                        <div class="form-group">
                            <input class="form-control" type="number" name="q" value="{{ \Illuminate\Support\Facades\Cache::get('quantity')}}">
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
