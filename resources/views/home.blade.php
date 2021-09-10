@extends('layouts.main')

@section('meta')
    <title>{{ config('app.name') }} - Главная</title>
    <meta name="description"
          content="Все Скидки и Акции здесь! Огромный интернет-каталог товаров от известных брендов. Выбирай и сравнивай."/>
@endsection

@section('content')
    <div class="container-xxl">
        @include('sections.categories')

        <div class="mt-5 mb-3 mb-md-5 wrapper">
            <h1 class="mb-3">Интернет - каталог товаров</h1>
            <p class="description ucfirst">
                Огромный каталог товаров известных брендов. Все скидки и акции тут. Выбирай, сравнивай и покупай с
                выгодой.
            </p>
        </div>

        @if(config('app.name') == 'Mr.Shopper')
            <div class="advert-block">
                <div id="yandex_rtb_R-A-1281564-4"></div>
                <script>window.yaContextCb.push(() => {
                        Ya.Context.AdvManager.render({
                            renderTo: 'yandex_rtb_R-A-1281564-4',
                            blockId: 'R-A-1281564-4'
                        })
                    })</script>
            </div>
        @endif

        @if($collections->isNotEmpty())
            <div class="compilation my-5">
                @foreach($collections as $collection)
                    <div class="mb-5">
                        <div class="wrapper mb-3">
                            <h2 class="mb-2">{{ $collection->name }}</h2>
                            <p class="description ucfirst">
                                {{ $collection->description }}
                            </p>
                        </div>

                        <div class="row">
                            @foreach(json_decode($collection->content) as $element)
                                <div class="mb-4 {{ $element->size }}" style="order: {{ $element->sort }}">
                                    <a class="w-100" href="{{ route('index').$element->link }}">
                                        <div class="collection-card">
                                            @if($element->image)
                                                <div class="background"
                                                     style="background-image: url('{{ asset($element->image) }}')">
                                                </div>
                                            @endif
                                            @if($element->title)
                                                <h3 class="p-2">{!! $element->title !!}</h3>
                                            @endif
                                            @if($element->description)
                                                <p class="p-2 w-100 f-w-5">{!! $element->description !!}</p>
                                            @endif

                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
            @if(config('app.name') == 'Mr.Shopper')
                <div class="advert-block">
                    <div id="yandex_rtb_R-A-1281564-2"></div>
                    <script>window.yaContextCb.push(() => {
                            Ya.Context.AdvManager.render({
                                renderTo: 'yandex_rtb_R-A-1281564-2',
                                blockId: 'R-A-1281564-2'
                            })
                        })</script>
                </div>
            @endif
        @endif
    </div>
@endsection
