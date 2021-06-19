@extends('layouts.main')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
@endpush

@section('title')
    Регистрация
@endsection

@section('content')
    <div class="container-xxl">

    <form method="POST" action="{{ route('register') }}" class="my-5 @if ($errors->any()) error @endif base">
        @csrf

        <div class="input-group">
            <label for="name">Ваше имя:</label>
            <x-jet-input id="name" type="text" name="name" :value="old('name')" required autofocus autocomplete="name"/>
        </div>

        <div class="input-group">
            <label for="email">E-mail:</label>
            <x-jet-input id="email" type="email" name="email" :value="old('email')" required/>
        </div>

        <div class="input-group">
            <label for="password">Пароль</label>
            <x-jet-input id="password" type="password" name="password" required autocomplete="new-password"/>
        </div>

        <div class="input-group">
            <label for="password_confirmation">Повторите пароль:</label>
            <x-jet-input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"/>

        </div>

        <button type="submit" class="btn btn-cyan d-block mx-auto">Регистрация</button>
    </form>

    </div>
    @if ($errors->any())
        <p>Ошибка регистрации</p>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

@endsection



