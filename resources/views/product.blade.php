@extends('layouts.main')

@section('meta')
    <title>{{ $product->name }}</title>
    <meta name="description" content="{{ $product->description_2 ?? $product->description_1 }}">
@endsection


@section('content')
    <div class="container-xxl">
        @include('sections.categories')

        @include('sections.breadcrumbs')

        <div class="row mb-4 mb-md-5">
            <div class="col-md-6 col-12 my-4">
                <div class="single-product-image w-100">
                    @if ($product->discount)
                        <p class="discount">-{{ $product->discount }}%</p>
                    @endif

                    @if (!empty($product->image))
                        @php
                            $href = strstr($product->href, 'ulp=', true)
                        @endphp

                        @if(count($product->image) > 1)
                            <div id="carousel2" class="carousel slide product-slider" data-ride="false">
                                <div class="carousel-inner border-bottom">
                                    @php
                                        $nameTail = ['фотография', 'описание', 'характеристики', 'цена по распродаже', 'выгодная цена', 'купить с доставкой', 'отзывы покупателей', 'официальный сайт', 'недорого', ' со скидкой'];
                                        $tailRun = 0;
                                    @endphp
                                    @foreach($product->image as $image)
                                        <div class="carousel-item @if($loop->first) active @endif">
                                            <img src="{{ $image }}" alt="{{ $product->name. ' ' . $nameTail[$tailRun] }}">
                                            <a href="{{ $href }}ulp={{ $image }}" target="_blank">
                                                <i class="fas fa-search-plus"></i>
                                            </a>
                                        </div>
                                        @php
                                            $tailRun++;
                                            if ($tailRun > count($nameTail)-1) $tailRun = 0;
                                        @endphp
                                    @endforeach
                                    <a class="carousel-control-prev carousel-control" href="#carousel2" role="button"
                                       data-slide="prev">
                                        <div class="carousel-control-icon">
                                            <i class="fas fa-chevron-left"></i>
                                        </div>
                                    </a>
                                    <a class="carousel-control-next carousel-control" href="#carousel2" role="button"
                                       data-slide="next">
                                        <div class="carousel-control-icon">
                                            <i class="fas fa-chevron-right"></i>
                                        </div>
                                    </a>
                                </div>
                                <ol class="carousel-indicators justify-content-start my-2 mx-3">
                                    @foreach($product->image as$key => $image)
                                        <li data-target="#carousel2" data-slide-to="{{ $key }}"
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
                            <img src="{{ $product->image[0] }}" alt="{{ $product->name .' фотография' }}">
                        @endif
                    @else
                        <div class="d-flex flex-column align-items-center justify-content-center" style="width: 100%; min-height: 200px">
                            <i class="far fa-image font-30 grey-light"></i>
                            <span class="mt-3">Нет картинки</span>
                        </div>
                    @endif
                </div>
            </div>

            <div class="col-md-6 col-12 pl-md-5 pl-2">
                <div class="mb-3 mb-md-4 wrapper">
                    <h1 class="mb-1">{{ $product->name }}</h1>

                    <div class="mb-md-5 mb-3 relative rating-wrapper">
                        @include('sections.rating', ['value' => $product->rating])
                    </div>

                    @if($product->description_1)
                        <p class="description ucfirst">{{ $product->description_1 }}</p>
                    @endif
                </div>

                <div class="price justify-content-end justify-content-sm-start align-items-center mb-3 mb-md-4">
                    @if ($product->old_price)
                        <p class="old font-12 red">{{ $product->old_price }}</p>
                    @endif
                    <p class="new font-13 f-w-5">{{ $product->price }}
                        <i class="fas fa-ruble-sign"></i>
                    </p>
                </div>

                <div class="single-attributes mb-3 mb-md-5">
                    <h2 class="mb-2 font-10">Характеристики:</h2>
                    <ul class="attributes w-100">
                        @foreach(\App\Modules\Functions::convertAttributes($product->attributes) as $group => $attribute)
                            <li>
                                <span>{{ $group }}:</span>
                                <span style="font-weight:500">{{ $attribute }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>

                @if($product->deleted_at)
                    <p class="t-center mb-1 red">Нет в наличии</p>
                @endif

                <div class="w-100 t-center">
                    <a href="{{ route('away', ['slug'=>$product->slug]) }}" class="btn btn-cyan px-5 py-3 font-13" rel="nofollow" target="_blank">ПОДРОБНЕЕ</a>
                </div>

            </div>
        </div>
        @if(!empty($relatedCategories))
            <div class="mb-5 pt-4">
                <p class="font-11 f-w-5 t-center mb-4">
                    <i class="fas red fa-heart mr-2"></i>
                    Вам понравятся эти подборки
                </p>
                <div class="row px-2 related-category">
                    @foreach($relatedCategories as $category)
                        <div class="col-6 col-sm-4 col-lg-3 px-sm-2 px-1 mb-1">
                            <a href="{{ route('category',['category' => $category->slug]) }}" class="deep-category mb-1">
                                <h3>{{ $category->name }}</h3>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        @if(config('app.name') == 'Mr.Shopper')
            <div class="my-3">
                <div id="yandex_rtb_R-A-1281564-1"></div>
                <script>window.yaContextCb.push(() => {
                        Ya.Context.AdvManager.render({
                            renderTo: 'yandex_rtb_R-A-1281564-1',
                            blockId: 'R-A-1281564-1'
                        })
                    })</script>
            </div>
        @endif

        <div class="my-5">
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link active font-09 rounded-0" data-toggle="tab" href="#category">Описание</a>
                </li>
                <li class="nav-item font-09" role="presentation">
                    <a class="nav-link rounded-0" data-toggle="tab" href="#reports">Отзывы</a>
                </li>
            </ul>

            <div class="tab-content">

                <div class="tab-pane fade show active" id="category">
                    <div class="p-md-5 p-sm-3 p-1 pt-4">
                        <h2 class="mb-4 font-11">Описание товара</h2>
                        @if($product->description_2)
                            <p class="description-product ucfirst">{{ $product->description_2 }}</p>
                        @else
                            <p class="description-product ucfirst">Мы пока не составили описание.</p>
                        @endif
                    </div>
                </div>

                <div class="tab-pane fade " id="reports">
                    <div class="p-md-5 p-sm-3 p-1 pt-4">
                        <h2 class="mb-4 font-11">Отзывы о товаре</h2>
                        <p class="mb-5 description-product ucfirst">У данного товара пока нет отзывов.<br>Станьте первым!
                        </p>

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

        @if($relatedProducts['up']->isNotEmpty() || $relatedProducts['down']->isNotEmpty())
            <div class="mb-5">
                <p class="font-11 f-w-5 t-center mb-4">
                    Похожие товары
                </p>

                <div class="row related-products justify-content-center">
                    @php
                        $lengthUp = 3;
                        $lengthDown = 3;
                        if(count($relatedProducts['up']) < 3) $lengthDown = $lengthUp + 3 - count($relatedProducts['up']);
                        if(count($relatedProducts['down']) < 3) $lengthUp = $lengthDown + 3 - count($relatedProducts['down']);
                    @endphp

                    @foreach($relatedProducts['down'] as $key => $product)
                        @break($loop->iteration > $lengthDown)
                        <div class="col-6 col-md-4 col-xl-2 px-0 mb-1" style="order: {{ -$key }}">
                            @include('sections.product-card', ['product' => $product, 'related' => true])
                        </div>
                    @endforeach

                    @foreach($relatedProducts['up'] as $product)
                        @break($loop->iteration > $lengthUp)
                        <div class="col-6 col-md-4 col-xl-2 px-0 mb-1">
                            @include('sections.product-card', ['product' => $product, 'related' => true])
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

    </div>
@endsection

@push('modals')
    @include('sections.img-popup')
@endpush
