
    <div class="user-menu">
        <div class="user-menu-toggle around">
            <i class="las la-user"></i>
        </div>
        <div class="user-menu-drop" style="display: none">
            <a href="{{ url('/favorites') }}" class="item">
                <div class="icon">
                    <i class="lar la-heart"></i>
                </div>
                <p>Избранное</p>
            </a>

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





