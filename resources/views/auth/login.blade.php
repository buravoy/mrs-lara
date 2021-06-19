@extends('layouts.main')

@section('title')
    Аутентификация
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
@endpush

@section('content')
    <div class="container-xxl">
        <form method="POST" action="{{ route('login') }}" class="my-5 @if ($errors->any()) error @endif base">
            @csrf

            <div class="input-group" tabindex="0">
                <label for="email">E-mail:</label>
                <x-jet-input id="email" type="email" name="email" :value="old('email')" required autofocus/>
            </div>

            <div class="input-group">
                <label for="password">Пароль:</label>
                <x-jet-input id="password" type="password" name="password" required autocomplete="current-password"/>
            </div>

            <div class="d-flex justify-content-between">
                <div class="check-group">
                    <input type="checkbox" id="remember_me" name="remember"/>
                    <label for="remember_me">Запомнить меня</label>
                </div>

                <button type="submit" class="btn btn-cyan">Войти</button>
            </div>


            <div class="d-flex justify-content-center font-08 mt-3">
                <a href="{{ route('password.request') }}">Забыли пароль?</a>
            </div>
        </form>
    </div>
    @if ($errors->any())
        <p>Ошибка аутентификации</p>
    @endif
@endsection



