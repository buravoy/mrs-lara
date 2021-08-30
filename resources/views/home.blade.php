@extends('layouts.main')

@section('meta')
    <title>{{ config('app.name') }} - Главная</title>
    <meta name="description"
          content="Все Скидки и Акции здесь! Огромный интернет-каталог товаров от известных брендов. Выбирай и сравнивай.">
@endsection

@section('content')
    <div class="container-xxl">
        @include('sections.categories')
    </div>
@endsection