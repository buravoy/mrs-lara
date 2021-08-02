<div class="container-xxl">
    <div class="d-flex align-items-center py-3">
        <a href="/" class="d-flex align-items-center justify-content-center decoration-none">
            <div class="logo-img me-2">
                <img src="{{ asset('images/logo.png') }}" alt="Mr.Shopper">
            </div>
            <p class="font-08 mb-1">Mr.<span class="font-11 f-w-7 condensed">Shopper</span>
            </p>
        </a>

        <div class="d-flex align-items-center ms-5 w-100 justify-content-end ">

            <button type="button" class="btn btn-cyan-outline">
                <span id="menu-closed">
                    <i class="las la-bars"></i> КАТЕГОРИИ
                </span>

                <span id="menu-shown" style="display: none">
                    <i class="las la-bars"></i> ЗАКРЫТЬ
                </span>

            </button>

            @auth
                @include('layouts.menu.dashboard-menu')
            @endauth

        </div>

    </div>
</div>
