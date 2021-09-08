<!doctype html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="google-site-verification" content="tF-GNYjHO4dU1x-HFQWBrg7xGfbpJy3lYbJFoQOA02w" />
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="canonical" href="{{ url()->current() }}"/>
    <link rel="icon" href="{{ asset('images/favicon/favicon.svg') }}" type="image/svg+xml">
    <link href="https://fonts.googleapis.com/css2?family=Fira+Sans:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('fontawesome/css/all.css') }}">
    <link rel="stylesheet" href="{{ asset('css/main.css') }}?v={{ File::lastModified('css/main.css') }}">

    @if(config('app.name') == 'Mr.Shopper')
        <script>window.yaContextCb=window.yaContextCb||[]</script>
        <script src="https://yandex.ru/ads/system/context.js" async></script>

        <script data-ad-client="ca-pub-4169030634163191" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
        <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-4169030634163191"
                crossorigin="anonymous"></script>
    @endif

    @stack('styles')

    @yield('meta')
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

@stack('modals')

@csrf
<script src="{{ asset('js/vendors.js') }}?v={{ File::lastModified('js/vendors.js') }}"></script>
<script src="{{ asset('js/main.js') }}?v={{ File::lastModified('js/main.js') }}"></script>
@stack('scripts')

@if(config('app.name') == 'Mr.Shopper')
    <script type="text/javascript" >
        (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
            m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
        (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

        ym(84694141, "init", {
            clickmap:true,
            trackLinks:true,
            accurateTrackBounce:true,
            webvisor:true
        });
    </script>
    <noscript><div><img src="https://mc.yandex.ru/watch/84694141" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
@endif


</body>
</html>
