<div class="container-xxl">
    <div class="d-flex align-items-center py-3">
        <a href="/" class="logo d-flex align-items-center justify-content-center decoration-none">
            <img src="{{ asset('images/logo.png') }}" alt="Mr.Shopper" class="me-2">
            <p class="font-08">Mr.<span class="font-11 f-w-7">Shopper</span></p>
        </a>
        @auth

            @include('layouts.menu.dashboard-menu')

        @else
            <div class="ms-auto">
                @include('layouts.menu.auth-menu')
            </div>
        @endauth
    </div>
</div>
