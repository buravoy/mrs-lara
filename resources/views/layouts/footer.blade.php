<div class="container-xxl">
    <div class="d-flex align-items-center justify-content-between py-3">
        <div class="d-flex align-items-center">
            <i class="far fa-copyright mr-1"></i>
            <span>2021. Mr.Shopper</span>
        </div>

        <div class="ms-auto d-flex align-items-center">
            @auth
                {{ Auth::user()->name }}
            @else
                @include('layouts.menu.auth-menu')
            @endauth
        </div>
    </div>
</div>

<a href="/admin" class="admin-signin" target="_blank">
    <i class="fas fa-lock"></i>
</a>
