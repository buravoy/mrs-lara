<ul>
    @if(!empty($results['categories']))
        @foreach($results['categories'] as $result)
            <li>
                <a class="uppercase w-100 pr-2" href="{{ route('index')}}/{{ $result['link'] }}">
                    {!! $result['text'] !!}
                </a>
                <span class="capitalize type ml-auto">Категория</span>
            </li>
        @endforeach
    @else
        <li class="p-2">Категорий не найдено</li>
    @endif

    @if(!empty($results['products']))
        @if(count($results['products']) < 10)
            <li class="p-2 font-09 flex-column pointer-event-none">
                Найдено {{ count($results['products']) }} товаров:<br>
            </li>
        @else
            <li class="p-2 font-09 flex-column pointer-event-none">Первые 10 товаров:<br>
                <span class="font-07">(для поиска определенного товара уточните запрос)</span>
            </li>
        @endif

        @foreach($results['products'] as $result)
            <li>
                <a class="uppercase w-100 pr-2" href="{{ route('index')}}/{{ $result['link'] }}">
                    <i class="fas fa-gift font-08 grey-light"></i>
                    {!! $result['text'] !!}
                </a>
                <span class="capitalize type ml-auto">Товар</span>
            </li>
        @endforeach
    @else
        <li class="p-2 t-center">Товаров не найдено</li>
    @endif

</ul>