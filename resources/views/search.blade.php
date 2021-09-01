@extends('layouts.main')

@section('meta')
    <title>{{ config('app.name') }}</title>

@endsection

@section('content')
    <div class="container-xxl">
        @include('sections.categories')

        <div class="compilation pt-5">
            <p>Найдено совпадений:</p>
            <h1></h1>

            <div class="mt-5">
                @if(!empty($results))
                    <ul>
                        @foreach($results as $result)
                            <li>
                                <a href="{{ route('index')}}/{{ $result['link'] }}">{{ $result['text'] }}</a>
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
