@if(isset($data['main_categories']) and  $data['main_categories']->count() > 0)
    @foreach($data['main_categories'] as $category)
        <!--title start-->
        <div class="title1 section-my-space">
            <h4>{{ $category->getTranslateName() }}</h4>
        </div>
        <section class="product section-big-pb-space">
            <div class="custom-container">
                <div class="row ">
                    <div class="col pr-0">
                        <div class="product-slide-6 no-arrow mb--10">
                            @foreach($category->products as $row)
                                @include('categories.partials._home_product_row')
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--product end-->
    @endforeach
@endif
