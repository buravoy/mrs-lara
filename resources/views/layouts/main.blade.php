<!doctype html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="shortcut icon" href="{{ asset('images/favicon/favicon.ico') }}" type="image/x-icon">

    <link rel="stylesheet" href="{{ asset('lineawesome/css/line-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    @stack('styles')

    <title>@yield('title')</title>
</head>

<body>
<header>
    @include('layouts.header')
</header>

<main>
    @yield('content')
</main>

<footer>
    @include('layouts.footer')
</footer>

<script src="{{ asset('js/vendors.js') }}"></script>
<script src="{{ asset('js/main.js') }}"></script>
@stack('scripts')
</body>
</html>
