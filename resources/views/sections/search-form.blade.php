<form class="base search w-100 mx-auto mx-sm-0 ml-sm-auto mt-sm-0 mt-2" action="{{ route('search') }}" data-ajax="{{ route('ajax-search') }}" style="order: 99; max-width: 400px">
    <div class="input-group mb-0">
        <label for="password">Поиск:</label>
        <input id="search" type="text" name="search" autocomplete="off" placeholder="Например: Обувь TAMARIS"/>
        <i class="fas fa-search cyan"></i>
        <div class="results results-list"></div>
    </div>
</form>
