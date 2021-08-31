@extends('layouts.main')

@section('meta')
    <title>{{ config('app.name') }} - Главная</title>
    <meta name="description"
          content="Все Скидки и Акции здесь! Огромный интернет-каталог товаров от известных брендов. Выбирай и сравнивай.">
@endsection

@section('content')
    <div class="container-xxl">
        @include('sections.categories')

        <div class="compilation pt-5">
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link active font-09 rounded-0" data-toggle="tab" href="#females">Женщинам</a>
                </li>
                <li class="nav-item font-09" role="presentation">
                    <a class="nav-link rounded-0" data-toggle="tab" href="#males">Мужчинам</a>
                </li>
                <li class="nav-item font-09" role="presentation">
                    <a class="nav-link rounded-0" data-toggle="tab" href="#kids">Детям</a>
                </li>
            </ul>

            <div class="tab-content">
                <div class="tab-pane fade show active" id="females">
                    <a href="{{ url('filter/zhenskaya-obuv/brend_bridget/discount') }}">Женская обувь bridget - распродажа</a>
                    <a href="{{ url('filter/zhenskaya-obuv/brend_instreet/discount') }}">Женская обувь bridget - распродажа</a>
                    <a href="{{ url('filter/zhenskaya-obuv/brend_bridget/discount') }}">Женская обувь bridget - распродажа</a>
                    <a href="{{ url('filter/zhenskaya-obuv/brend_bridget/discount') }}">Женская обувь bridget - распродажа</a>
                    <a href="{{ url('filter/zhenskaya-obuv/brend_bridget/discount') }}">Женская обувь bridget - распродажа</a>
                    <a href="{{ url('filter/zhenskaya-obuv/brend_bridget/discount') }}">Женская обувь bridget - распродажа</a>
                </div>

                <div class="tab-pane fade " id="males">
                    <h2>Предложения для мужчин</h2>
                </div>

                <div class="tab-pane fade " id="kids">
                    <h2>Предложения для детей</h2>
                </div>
            </div>
        </div>
    </div>
@endsection
