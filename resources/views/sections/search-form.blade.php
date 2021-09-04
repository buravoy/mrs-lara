


<form class="base search w-100 mx-auto mx-sm-0 ml-sm-auto mt-sm-0 mt-2" action="{{ route('search') }}" data-ajax="{{ route('ajax-search') }}">
    <div class="input-group mb-0">
        <input id="search" type="text" name="search" autocomplete="off" placeholder="Поиск: Обувь TAMARIS"/>
        <i class="fas fa-search icon-search cyan d-none d-sm-block"></i>
        <i class="fas fa-spinner icon-search cyan" style="display: none"></i>
        <div class="results results-list"></div>
    </div>
</form>
