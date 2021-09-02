@if(!empty($results))
    <ul>
        @foreach($results as $result)

            @php
            @endphp

            <li>
                <a class="capitalize" href="{{ route('index')}}/{{ $result['link'] }}">{!! $result['text'] !!}</a>
            </li>
        @endforeach
    </ul>

@else
    <ul>
        <li class="p-2 t-center">Ничего не найдено</li>
    </ul>
@endif