@php
use App\Modules\Functions;
@endphp

<div>
    <h4>Посмотрите еще:</h4>

    <div>
        @if($category->parent)

        @foreach($category->parent->allChild->sortByDesc('count') as $categoryFirst)
            @if($categoryFirst->id != $category->id && $categoryFirst->count > 0)
                <a href="{{ route('category',['category' => $categoryFirst->slug]) }}" class="btn-cyan mb-1">{{ $categoryFirst->short_name }}</a>
            @endif
        @endforeach

        @endif

    </div>

    <hr>

    <h4>атрибуты</h4>
    <div>
        @foreach($filters as $filter)
{{--            @dump($filter)--}}
            @if(!empty($filter['attributes']))
                <p>{{ $filter['name'] }}</p>

                @foreach($filter['attributes'] as $attribute)

{{--                    @dump( Functions::getFilterUrl($filter->slug, $attribute->slug, Request::path()) )--}}
                    @php
                        $filterUrlData = Functions::getFilterUrl($filter['slug'], $attribute['slug'], Request::path());
                    @endphp

{{--                    @dump($filterUrlData)--}}

                    <a
                        href="{{ route('index') }}/{{ $filterUrlData['link'] }}"
                        class="btn-cyan mb-1 @if($filterUrlData['isActive']) red @endif ">
                        {{ $attribute['name'] }}
                    </a>
                @endforeach

            @endif
        @endforeach
    </div>


</div>

{{--@dump($selectedFilters)--}}
