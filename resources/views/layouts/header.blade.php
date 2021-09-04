<div class="container-xxl">
    <div class="d-flex align-items-center py-sm-3 pt-2 flex-wrap">
        <a href="/" class="d-flex align-items-center justify-content-center decoration-none">
            <div class="logo-img mr-2">
                <img src="{{ asset('images/logo.png') }}" alt="Mr.Shopper">
            </div>
            <p class="font-08 mb-1">Mr.<span class="font-11 f-w-7 condensed">Shopper</span>
            </p>
        </a>

        @include('sections.search-form')

        <button type="button" class="cyan bg-white search-toggle d-sm-none ml-auto">
            <span class="menu-button-text">
                <i class="fas fa-search font-12"></i>
            </span>
        </button>

        <button type="button" class="cyan bg-white main-menu-toggle d-sm-none">
            <span class="menu-button-text">
                <i class="fas fa-bars font-12"></i>
            </span>

            <span class="menu-button-text" style="display: none">
                <i class="fas fa-times font-12"></i>
            </span>
        </button>
    </div>
</div>


