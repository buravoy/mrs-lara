@extends('layouts.main')

@section('title')
    Подтверждение E-mail
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
@endpush

@section('content')
    <div class="container-xxl">
        <div class="auth-message mx-auto mt-5 px-3">
            <p class="mb-3 t-center">Для завершения регистрации необходимо подтвердить E-mail.</p>
            <p class="mb-5 t-center">Для этого перейдите по ссылке в писме которое мы вам отправили...</p>

            @if (session('status') == 'verification-link-sent')
                <p class="mt-5 green t-center"><b>Повторное письмо отправлено</b></p>
            @else
                <form method="POST" action="{{ route('verification.send') }}" class="d-flex w-100">
                    @csrf
                    <button type="submit" class="btn btn-cyan-outline mx-auto">
                        Отправить письмо повторно
                    </button>
                </form>
            @endif
        </div>
    </div>
@endsection



