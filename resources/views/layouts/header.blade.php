<div class="container-xxl">
    <div class="d-flex align-items-center py-3">
        <a href="/" class="d-flex align-items-center justify-content-center decoration-none">
            <div class="logo-img me-2">
                <img src="{{ asset('images/logo.png') }}" alt="Mr.Shopper">
            </div>
            <p class="font-08 mb-1">Mr.<span class="font-11 f-w-7 condensed">Shopper</span></p>
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
