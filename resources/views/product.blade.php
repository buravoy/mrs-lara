@extends('layouts.main')

@section('meta_title')
    <title>{{ $product->name }}</title>
@endsection

@section('meta_description')
    <meta name="description"
          content="{{ $product->description }}">
@endsection

@section('content')
    <div class="container-xxl">
        @include('sections.categories')

        @include('sections.breadcrumbs')

        <div class="row mb-3 mb-md-5">
            <div class="col-md-6 col-12">
                <div class="single-product-image w-100">
                    @if ($product->discount)
                        <p class="discount">-{{ $product->discount }}%</p>
                    @endif

                    @if (!empty($product->image))
                        @php
                            $href = strstr($product->href, 'ulp=', true)
                        @endphp

                        @if(count($product->image) > 1)
                            <div id="carousel" class="carousel slide" data-ride="false">
                                <div class="carousel-inner border-bottom">
                                    @foreach($product->image as $image)
                                        <div class="carousel-item @if($loop->first) active @endif"
                                             style="background-image: url('{{ $image }}')">
                                            <a href="{{ $href }}ulp={{ $image }}" target="_blank">
                                                <i class="fas fa-search-plus"></i>
                                            </a>
                                        </div>
                                    @endforeach
                                    <a class="carousel-control-prev carousel-control" href="#carousel" role="button"
                                       data-slide="prev">
                                        <div class="carousel-control-icon">
                                            <i class="fas fa-chevron-left"></i>
                                        </div>
                                    </a>
                                    <a class="carousel-control-next carousel-control" href="#carousel" role="button"
                                       data-slide="next">
                                        <div class="carousel-control-icon">
                                            <i class="fas fa-chevron-right"></i>
                                        </div>
                                    </a>
                                </div>
                                <ol class="carousel-indicators justify-content-start my-2 mx-3">
                                    @foreach($product->image as$key => $image)
                                        <li data-target="#carousel" data-slide-to="{{ $key }}"
                                            class="captions @if($loop->first) active @endif">
                                            <img src="{{ $image }}" class="thumb">
                                        </li>
                                    @endforeach
                                </ol>
                            </div>
                        @else
                            <a href="{{ $href }}ulp={{ $product->image[0] }}" target="_blank">
                                <i class="fas fa-search-plus"></i>
                            </a>
                            <img src="{{ $product->image[0] }}" alt="{{ $product->name }}">
                        @endif
                    @else
                        <i class="far fa-image font-30 grey-light"></i>
                    @endif
                </div>
            </div>

            <div class="col-md-6 col-12 pl-md-5 pl-2">
                <div class="mb-3 mb-md-4 wrapper">
                    <h1 class="mb-1">{{ $product->name }}</h1>

                    <div class="mb-md-5 mb-3 relative" style="margin-left: -6px;">
                        @include('sections.rating', ['value' => $product->rating])
                    </div>

                    @if($product->description_1)
                        <p class="description ucfirst">{{ $product->description_1 }}</p>
                    @endif
                </div>

                <div class="price justify-content-start align-items-center mb-3 mb-md-4">
                    @if ($product->old_price)
                        <p class="old font-12 red">{{ $product->old_price }}</p>
                    @endif
                    <p class="new font-13 f-w-5">{{ $product->price }}<i class="fas fa-ruble-sign"></i></p>
                </div>

                <div class="single-attributes mb-3 mb-md-5">
                    <h2 class="mb-2 font-10">Характеристики:</h2>
                    <ul class="attributes w-100">
                        @foreach(\App\Modules\Functions::convertAttributes($product->attributes) as $group => $attribute)
                            <li><span>{{ $group }}:</span> <span style="font-weight:500">{{ $attribute }}</span></li>
                        @endforeach
                    </ul>
                </div>

                <div class="w-100 t-center">
                    <a href="{{ $product->href }}" class="btn btn-cyan px-5 py-3 font-13" target="_blank">В МАГАЗИН</a>
                </div>

            </div>
        </div>

        <div class="mb-3 mb-md-4 pt-3">
            <p class="font-11 f-w-5 t-center mb-4">
                <i class="fas red fa-heart mr-2"></i>
                Вам понравятся эти подборки
            </p>
            <div class="row px-3">
                @foreach($relatedCategories as $category)
                    <div class="col-6 col-sm-4 col-lg-3 px-sm-2 px-1 mb-1">
                        <a href="{{ route('category',['category' => $category->slug]) }}" class="deep-category mb-1">
                            <span>{{ $category->name }}</span>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>


        <div class="mb-4">
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link active font-09" data-toggle="tab" href="#category">Описание</a>
                </li>
                <li class="nav-item font-09" role="presentation">
                    <a class="nav-link" data-toggle="tab" href="#reports">Отзывы</a>
                </li>
            </ul>

            <div class="tab-content">

                <div class="tab-pane fade show active" id="category">
                    <div class="p-md-5 p-3">
                        <h2 class="mb-4 font-11">Описание товара</h2>
                        @if($product->description_2)
                            <p class="description-product font-09 ucfirst">{{ $product->description_2 }}</p>
                        @endif
                    </div>
                </div>

                <div class="tab-pane fade " id="reports">
                    <div class="p-md-5 p-3">
                        <h2 class="mb-4 font-11">Отзывы о товаре</h2>
                        <p class="mb-5 font-09">У данного товара пока нет отзывов.<br>Станьте первым!</p>

                        <form action="" class="base w-100" style="max-width: none">
                            <div class="input-group" style="max-width: 360px;">
                                <label for="password_confirmation">Ваше имя:</label>
                                <input type="text">

                            </div>

                            <div class="input-group">
                                <label for="password_confirmation">Отзыв:</label>
                                <textarea rows="5" style="transition: none"></textarea>
                            </div>

                            <div class="d-flex w-100 justify-content-center">
                                <button class="btn btn-cyan-outline">Оставить отзыв</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>

        <div class="mb-5">
            <p class="font-11 f-w-5 t-center mb-4">
                Похожие товары
            </p>

            <div class="row justify-content-center">

                @php
                    $lengthUp = 3 + 3 - count($relatedProducts['down']);
                    $lengthDown = 3 + 3 - count($relatedProducts['up']);
                    if($lengthUp < 3) $lengthUp = 3;
                    if($lengthDown < 3) $lengthDown = 3;
                @endphp

                @foreach($relatedProducts['down'] as $key => $product)
                    @break($loop->iteration > $lengthDown)
                    <div class="col-6 col-md-4 col-xl-2 px-0 mb-1" style="order: {{ -$key }}">
                        @include('sections.product-card', ['product' => $product])
                    </div>
                @endforeach

                @foreach($relatedProducts['up'] as $product)
                    @break($loop->iteration > $lengthUp)
                    <div class="col-6 col-md-4 col-xl-2 px-0 mb-1">
                        @include('sections.product-card', ['product' => $product])
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
