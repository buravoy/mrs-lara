<!-- This file is used to store sidebar items, starting with Backpack\Base 0.9.0 -->
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="nav-icon la la-home"></i>{{ trans('backpack::base.dashboard') }}</a></li>
<li class="nav-title"></li>

<li class="nav-title">Партнерки</li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('feeds') }}'><i class="nav-icon las la-comments-dollar"></i> Парсеры</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('longfeeds') }}'><i class='nav-icon las la-copy'></i> Длинные фиды</a></li>

<li class="nav-title mt-3">Каталог</li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('category') }}'><i class='nav-icon la la-stream'></i> Категории</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('products') }}'><i class='nav-icon la la-box'></i>Товары</a></li>

<li class="nav-title mt-3">Фильтры</li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('groups') }}'><i class="nav-icon la la-cubes"></i> Группы атрибутов</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('attributes') }}'><i class="nav-icon la la-cube"></i> Атрибуты</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('tag') }}'><i class='nav-icon la la-tags'></i> Метки</a></li>

<li class="nav-title">Контент</li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('meta-generators') }}'><i class="nav-icon las la-money-check-alt"></i> SEO Генераторы</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('collection') }}'><i class='nav-icon la la-file-alt'></i> Подборки на главной</a></li>


<li class="nav-title mt-3">Администрирование</li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('user') }}'><i class="nav-icon las la-user-friends"></i>Пользователи</a></li>
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('elfinder') }}"><i class="nav-icon la la-files-o"></i> Файлы</a></li>