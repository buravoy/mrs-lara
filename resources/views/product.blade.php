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

        <div class="row">
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
                            <div id="carousel" class="carousel slide"  data-ride="false">
                                <div class="carousel-inner border-bottom">
                                    @foreach($product->image as $image)


                                        <div class="carousel-item @if($loop->first) active @endif" style="background-image: url('{{ $image }}')">
                                            <a href="{{ $href }}ulp={{ $image }}" target="_blank">
                                                <i class="fas fa-search-plus"></i>
                                            </a>
                                        </div>
                                    @endforeach
                                    <a class="carousel-control-prev carousel-control" href="#carousel" role="button" data-slide="prev">
                                        <div class="carousel-control-icon">
                                            <i class="fas fa-chevron-left"></i>
                                        </div>
                                    </a>
                                    <a class="carousel-control-next carousel-control" href="#carousel" role="button" data-slide="next">
                                        <div class="carousel-control-icon">
                                            <i class="fas fa-chevron-right"></i>
                                        </div>
                                    </a>
                                </div>
                                <ol class="carousel-indicators justify-content-start my-2 mx-3">
                                    @foreach($product->image as$key => $image)
                                        <li data-target="#carousel" data-slide-to="{{ $key }}" class="captions @if($loop->first) active @endif">
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
                <div class="mb-3 mb-md-5 wrapper">
                    <h1 class="mb-3 t-right">{{ $product->name }}</h1>
                    @if($product->description_1)
                        <p class="description ucfirst t-right">{{ $product->description_1 }}</p>
                    @endif
                </div>

                <div class="single-price">
                    @if ($product->old_price)
                        <p class="old-price t-right">{{ $product->old_price }}</p>
                    @endif
                    <p class="price t-right">{{ $product->price }}</p>
                </div>

                <div class="single-attributes">
                    <ul class="attributes w-100">
                        @foreach(\App\Modules\Functions::convertAttributes($product->attributes) as $group => $attribute)
                            <li><span>{{ $group }}:</span> <span style="font-weight:500">{{ $attribute }}</span></li>
                        @endforeach
                    </ul>
                </div>

                <div class="w-100 t-center">
                    <a href="{{ $product->href }}" class="btn btn-cyan " target="_blank">В МАГАЗИН</a>
                </div>

                @if($product->description_1)
                    <p class="description ucfirst t-right">{{ $product->description_2 }}</p>
                @endif
            </div>
        </div>

        <div class="">

            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link active" data-toggle="tab" href="#category">Вам понравятся эти подборки</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" data-toggle="tab" href="#reports">Отзывы</a>
                </li>
            </ul>

            <div class="tab-content">
                <div class="tab-pane fade show active" id="category">
                    @dump($category)
                </div>
                <div class="tab-pane fade " id="reports">
                    <div class="p-5">
                        <h3 class="mb-4">Отзывы о товаре</h3>
                        <p class="mb-5">У данного товара нет отзывов. Станьте первым!</p>

                        <form action="" class="base w-100" style="max-width: none">
                            <div class="input-group" style="max-width: 360px;">
                                <label for="password_confirmation">Ваше имя:</label>
                                <input type="text">

                            </div>

                            <div class="input-group">
                                <label for="password_confirmation">Отзыв:</label>
                                <textarea rows="5"></textarea>
                            </div>

                            <div class="d-flex w-100 justify-content-center">
                                <button class="btn btn-cyan-outline">Оставить отзыв</button>
                            </div>
                        </form>




                        

                    </div>
                    
                </div>
            </div>


        </div>




    </div>
@endsection
