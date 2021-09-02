@extends('layouts.main')

@section('meta')
    <title>{{ config('app.name') }}</title>
@endsection

@section('content')
    <div class="container-xxl">
        @include('sections.categories')

        <div class="compilation pt-sm-5 pt-3">
            <div class="mb-3 mb-md-5 wrapper">
                <h1 class="ucfirst"><span class="f-w-3">Поиск: </span>{{ $query }}</h1>
                <p class="font-08 grey-light">Найдено совпадений: {{ count($results) }}</p>
            </div>


            <div class="results-list mt-5">
                @if(!empty($results))
                    <ul>
                        @foreach($results as $result)
                            <li>
                                <a class="capitalize" href="{{ route('index')}}/{{ $result['link'] }}">{!! $result['text'] !!}</a>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <ul>
                        <li class="p-2 t-center">Ничего не найдено</li>
                    </ul>
                @endif
            </div>


        </div>
    </div>
@endsection
