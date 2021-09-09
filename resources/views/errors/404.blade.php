@extends('layouts.main')

@section('meta')
    <title>Страница не найдена :( - {{ config('app.name') }}</title>
    <meta name="description"
          content="Все Скидки и Акции здесь! Огромный интернет-каталог товаров от известных брендов. Выбирай и сравнивай." />
@endsection

@section('content')
    <div class="container-xxl">
        @include('sections.categories')

        <div class="pt-5">
            <p class="t-center mb-3">Страницы не существует</p>
            <p class="t-center font-20 mb-5">404</p>
            <p class="t-center font-13">Пожалуйста, посмотрите другие разделы</p>
        </div>
    </div>
@endsection
