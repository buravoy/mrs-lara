@if(!empty($results))
    <ul>
        @foreach($results['categories'] as $result)
            <li>
                <a class="capitalize" href="{{ route('index')}}/{{ $result['link'] }}">{!! $result['text'] !!}</a>
                <span class="type">Категория</span>
            </li>
        @endforeach
    </ul>

@else
    <ul>
        <li class="p-2 t-center">Ничего не найдено</li>
    </ul>
@endif