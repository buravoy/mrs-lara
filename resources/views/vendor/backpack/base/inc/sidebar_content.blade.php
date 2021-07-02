<!-- This file is used to store sidebar items, starting with Backpack\Base 0.9.0 -->
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="la la-home nav-icon"></i>{{ trans('backpack::base.dashboard') }}</a></li>
<li class="nav-title"></li>
<li class="nav-title">Каталог</li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('category') }}'><i class='nav-icon la la-stream'></i> Категории</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('products') }}'><i class='nav-icon la la-box'></i>Товары</a></li>
<li class="nav-title mt-3">Атрибуты</li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('groups') }}'><i class="la la-cubes"></i> Группы атрибутов</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('attributes') }}'><i class="la la-cube"></i> Атрибуты</a></li>

<li class="nav-title mt-3">Администрирование</li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('user') }}'><i class="las la-user-friends nav-icon"></i>Пользователи</a></li>


<li class="nav-item"><a class="nav-link" href="{{ backpack_url('elfinder') }}"><i class="nav-icon la la-files-o"></i> <span>{{ trans('backpack::crud.file_manager') }}</span></a></li>