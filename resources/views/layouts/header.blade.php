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

            <button type="button" class="btn btn-cyan-outline main-menu-toggle d-sm-none">
                <span class="menu-button-text">
                    <i class="las la-bars font-12"></i>
                    <span>КАТЕГОРИИ</span>
                </span>

                <span class="menu-button-text" style="display: none">
                    <i class="las la-times font-12"></i>
                    <span>ЗАКРЫТЬ</span>
                </span>

            </button>

            @auth
                @include('layouts.menu.dashboard-menu')
            @endauth
        </div>
    </div>
</div>


