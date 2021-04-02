@extends('layouts.app')
@section('content')
    <section id="core" class="main-feature section-big-py-space">
        <div class="custom-container">
            @foreach($data['categories'] as $category)
                <div class="row">
                    <div class="col-md-12 text-center">
                        <div class="col-md-12 text-center">
                            <div class="title6">
                                <h4>{{ $category->getTranslateName() }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row key-feature">
                    @foreach($category->subs as $c)
                        <div class="col-xl-2 col-sm-3 col-6">
                            <div class="theme-collection">
                                <a href="{{ route('products',['category_id' => $c->id]) }}">
                                    <div>
                                        <div class="image-contain">
                                            <div class="set-image">
                                                <img src="{{ $c->getImageSize(100,100) }}" alt="fetures">
                                            </div>
                                        </div>
                                        <h5 class="text-center">{{ $c->getTranslateName() }}</h5>
                                    </div>
                                </a>
                            </div>
                        </div>
                    @endforeach

                </div>
                <div style="margin-top: 5px"></div>
            @endforeach
        </div>
    </section>
@endsection
