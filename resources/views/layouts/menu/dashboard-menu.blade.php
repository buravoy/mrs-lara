<div class="d-flex align-items-center ms-5 w-100">
    <a href="{{ url('/dashboard') }}">Dashboard</a>


        <div class="user-menu ms-auto">
            <div class="user-menu-toggle around">
                <i class="las la-user"></i>
            </div>
            <div class="user-menu-drop" style="display: none">
                <a href="{{ url('/user/profile') }}" class="item">
                    <div class="icon">
                        <i class="las la-user-edit"></i>
                    </div>
                    <p>Профиль</p>
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <div class="item" onclick="this.parentNode.submit()">
                        <div class="icon">
                            <i class="las la-sign-out-alt"></i>
                        </div>
                        <p>Выход</p>
                    </div>
                </form>
            </div>
        </div>
</div>




