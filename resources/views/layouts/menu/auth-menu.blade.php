@if(Route::currentRouteName() != 'login')
    <a href="{{ route('login') }}" class="btn btn-cyan font-08 px-2 py-1 me-2 decoration-none">
        <i class="las la-sign-in-alt font-10 me-sm-1"></i>
        <span class="d-none d-sm-inline uppercase condensed">Вход</span>
    </a>
@endif

@if(Route::currentRouteName() != 'register')
    <a href="{{ route('register') }}" class="btn btn-cyan-outline font-08 px-2 py-1 decoration-none">
        <i class="las la-user-plus font-10 me-sm-1"></i>
        <span class="d-none d-sm-inline uppercase condensed">Регистрация</span>
    </a>
@endif
