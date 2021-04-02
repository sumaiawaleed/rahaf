@php
    $brands = $request->brands;
    $offer = $request->offer;
    $categories = $request->categories;
    $color_id = $request->color_id;
    $from = $request->from;
    $to = $request->to;
    $search = $request->search;
    $search = $request->search;
@endphp
<div class="col-sm-3 collection-filter category-page-side">
    <!-- side-bar colleps block stat -->
    <form id="search_form" method="get" action="{{ route('products') }}">
        @if($offer)
            <input type="hidden" value="1" name="offer">
        @endif
        <div class="collection-filter-block creative-card creative-inner category-side">
            <!-- brand filter start -->
            <div class="collection-mobile-back"><span class="filter-back"><i class="fa fa-angle-left"
                                                                             aria-hidden="true"></i> back</span>
            </div>
            <div class="collection-collapse-block border-0 open">
                <h3 class="collapse-block-title">@lang('site.categories')</h3>
                <div class="collection-collapse-block-content">
                    @foreach($data['main_categories'] as $category)
                        <div class="custom-control custom-checkbox collection-filter-checkbox">
                            <input
                                {{ (($categories != null) and  in_array($category->id,$categories)) ? "checked" : "" }} onchange="$('#search_form').submit();"
                                type="checkbox" class="custom-control-input" value="{{ $category->id }}"
                                id="{{ $category->name }}" name="categories[]">
                            <label class="custom-control-label"
                                   for="{{ $category->name }}">{{ $category->getTranslateName() }}</label>
                        </div>
                    @endforeach
                </div>
            </div>
            <hr>
            <div class="collection-collapse-block open">
                <h3 class="collapse-block-title mt-0">@lang('site.brands')</h3>
                <div class="collection-collapse-block-content">
                    <div class="collection-brand-filter">
                        @foreach($data['general']['brands'] as $brand)
                            <div class="custom-control custom-checkbox collection-filter-checkbox">
                                <input onchange="$('#search_form').submit();"
                                       {{ (($brands != null)  and in_array($brand->id,$brands)) ? "checked" : "" }} type="checkbox"
                                       class="custom-control-input" value="{{ $brand->id }}"
                                       id="{{ $brand->name }}" name="brands[]">
                                <label class="custom-control-label"
                                       for="{{ $brand->name }}">{{ $brand->getTranslateName() }}</label>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <hr>
            <!-- color filter start here -->
            <div class="collection-collapse-block open">
                <h3 class="collapse-block-title">@lang('site.colors')</h3>
                <div class="collection-collapse-block-content">
                    <div class="color-selector">
                        <ul>
                            <input id="radio_color" style="display: none" onchange="$('#search_form').submit();"
                                   type="radio" name="color_id" value="0">
                            <li onclick="$('#radio_color').click()" style="background:#fff">
                            </li>
                            @foreach($data['general']['colors'] as $color)
                                <input id="radio_{{ $color->id }}" style="display: none"
                                       onchange="$('#search_form').submit();" type="radio" value="{{ $color->id }}"
                                       name="color_id" {{ $color_id == $color->id ? "checked" : "" }}>
                                <li onclick="$('#radio_{{ $color->id }}').click()"
                                    style="background: {!! $color->color !!}">
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <hr>
            <!-- price filter start here -->
            <div class="collection-collapse-block border-0 open">
                <h3 class="collapse-block-title">@lang('site.price')</h3>
                <div class="collection-collapse-block-content">
                    <div class="row">
                        <div class="col-md-6">
                            <label>@lang('site.from')</label>
                            <input class="form-control" value="{{ $from }}" type="number" name="from"
                                   placeholder="@lang('site.from')">
                        </div>
                        <div class="col-md-6">
                            <label>@lang('site.to')</label>
                            <input class="form-control" type="number" value="{{ $to }}" name="to"
                                   placeholder="@lang('site.to')">
                        </div>
                        <input type="submit" style="display: none">
                    </div>
                </div>
            </div>
            <hr>
        </div>
    </form>
    @include('categories.partials._new_products')

</div>
