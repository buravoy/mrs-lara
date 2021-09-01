@if(!empty($results))
    <ul>
        @foreach($results as $result)
            <li>
                <a href="{{ route('index')}}/{{ $result['link'] }}">{{ $result['text'] }}</a>
            </li>
        @endforeach
    </ul>

@else
    <ul>
        <li class="p-2 t-center">Ничего не найдено</li>
    </ul>
@endif