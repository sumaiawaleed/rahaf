@extends('layouts.app')
@section('content')
@foreach($data['categories'] as $category)
    <div class="title6">
        <h4><a href="{{ route('products',['main_id' => $category->id]) }}"> {{ $category->getTranslateName() }}</a></h4>
    </div>
    <section class="rounded-category ">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="slide-6 no-arrow">
                       @foreach($category->subs as $c)
                            <div>
                                <div class="category-contain">
                                    <a href="{{ route('products',['category_id' => $c->id]) }}">
                                        <div class="img-wrapper">
                                            <img src="{{ $c->getImageSize(100,100) }}" alt="category  " class="img-fluid">
                                        </div>
                                        <div>
                                            <div  class="btn-rounded">
                                                {{ $c->getTranslateName() }}
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
@endforeach
@endsection
