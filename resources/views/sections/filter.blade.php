@php
    use App\Modules\Functions;
@endphp


<div>
    @if($discountAvailable != null)
        <h4>sale</h4>

        @php
            $discount = Functions::getDiscountUrl(Request::path());
        @endphp

        <a href="{{ route('index') }}/{{ $discount['link'] }}"
           class="btn-cyan mb-1 @if($discount['isActive']) red @endif">
            распродажа
        </a>
    @endif


    <h4>Посмотрите еще:</h4>

    <div>

        @if($category->parent)

            @foreach($category->parent->allChild->sortByDesc('count') as $categoryFirst)
                @if($categoryFirst->id != $category->id && $categoryFirst->count > 0)
                    <a href="{{ route('category',['category' => $categoryFirst->slug]) }}"
                       class="btn-cyan mb-1">
                        {{ $categoryFirst->short_name }}
                    </a>
                @endif
            @endforeach

        @endif

    </div>

    <hr>

    <h4>атрибуты</h4>
    <div>
        @foreach($filters as $filter)
            @if(!empty($filter['attributes']) && count($filter['attributes']) > 1)
                <p>{{ $filter['name'] }}</p>
                @foreach($filter['attributes'] as $attribute)
                    @php
                        $filterUrlData = Functions::getFilterUrl($filter['slug'], $attribute['slug'], Request::path());
                        if ($discountSet) $filterUrlData['link'].'/discount';
                    @endphp
                    <a
                        href="{{ route('index') }}/{{ $filterUrlData['link'] }}"
                        class="btn-cyan mb-1 @if($filterUrlData['isActive']) red @endif">
                        {{ $attribute['name'] }}
                    </a>
                @endforeach
            @endif
        @endforeach
    </div>
</div>

