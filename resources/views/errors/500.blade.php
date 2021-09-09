@extends('layouts.main')

@section('meta')
    <title>Внутреняя ошибка :( - {{ config('app.name') }}</title>
    <meta name="description"
          content="Все Скидки и Акции здесь! Огромный интернет-каталог товаров от известных брендов. Выбирай и сравнивай." />
@endsection

@section('content')
    <div class="container-xxl">
        @include('sections.categories')

        <div class="pt-5">
            <p class="t-center mb-3">Внутреняя ошибка</p>
            <p class="t-center mb-5">Мы уже исправляем</p>
            <p class="t-center font-13">Пожалуйста, посмотрите другие разделы</p>
        </div>
    </div>
@endsection
