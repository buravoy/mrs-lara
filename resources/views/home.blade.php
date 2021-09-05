@extends('layouts.main')

@section('meta')
    <title>{{ config('app.name') }} - Главная</title>
    <meta name="description"
          content="Все Скидки и Акции здесь! Огромный интернет-каталог товаров от известных брендов. Выбирай и сравнивай.">
@endsection

@section('content')
    <div class="container-xxl">
        @include('sections.categories')

        @if($collections->isNotEmpty())
            <div class="compilation my-5">
                @foreach($collections as $collection)
                    <div class="mb-5">
                        <h2 class="mb-2">{{ $collection->name }}</h2>
                        <p class="mb-4 font-09">{{ $collection->description }}</p>

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
        @endif
    </div>
@endsection
