@foreach($data['ads'] as $ad)
    <div class="col-md-3" id="product_div_{{ $ad->id }}">
        <div class="card">
            <img class="card-img-top" src="{{ $ad->main_image_path }}" alt="Card image cap">
            <div class="card-body">
                <h5 class="card-title">{{ $ad->getTranslateName(app()->getLocale()) }}</h5>
                <p class="card-text">{{ substr($ad->getTranslateDetails(app()->getLocale()),0,100) }}</p>
                <p class="card-text">
                    <small class="text-muted">{{ $ad->since }}</small>
                </p>

                <p class="card-text">
                    @if($ad->is_deleted == 0)
                        <button data-id="{{ $ad->id }}"  type="button" class="btn btn-danger delete-product-btn"><span
                                class="icon-archive"></span></button>
                    @else
                        <button data-id="{{ $ad->id }}"  type="button" class="btn btn-danger restore-product-btn"><span
                                class="icon-export"></span></button>
                    @endif
                    <a href="{{ route(env('DASH_URL').'.products.edit',$ad->id) }}" type="button"
                       class="btn btn-warning" style="display: inline"><span
                            class="icon-mode_edit"></span></a>
                </p>
            </div>
        </div>
    </div>
@endforeach
