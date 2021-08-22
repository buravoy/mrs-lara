@php
    use App\Modules\Functions;
    use App\Modules\Beautify;
@endphp


@if($discountAvailable != null)

    @php
        $discount = Functions::getDiscountUrl(Request::path());
    @endphp
    <div class="filters-group">
        <div class="d-flex flex-wrap align-items-start filters-list">
            <a href="{{ route('index') }}/{{ $discount['link'] }}"
               class="btn-filter btn-sale @if($discount['isActive']) active @endif">
                <span>распродажа  <span class="red">% SALE %</span></span>
                <i class="fas fa-tags red"></i>
            </a>
        </div>
    </div>
@endif



@if($category->parent)
    <div class="filters-group">
        <h4 class="my-2">Посмотрите еще</h4>
        <div class="d-flex flex-wrap align-items-start filters-list">
            @foreach($category->parent->allChild->sortByDesc('count') as $categoryFirst)
                @if($categoryFirst->id != $category->id && $categoryFirst->count > 0)
                    <a href="{{ route('category',['category' => $categoryFirst->slug]) }}"
                       class="btn-assoc">
                        <span>{{ $categoryFirst->short_name }}</span>
                    </a>
                @endif
            @endforeach
        </div>
        @if(count($category->parent->allChild) > 6)
            <p class="show-all-filters">Показать все</p>
        @endif
    </div>
@endif



@foreach($filters as $filter)
    @if(!empty($filter['active_attributes']) && count($filter['active_attributes']) > 1)

        <div class="filters-group">
            <h4 class="my-2">{{ $filter['name'] }}</h4>

            <div class="d-flex flex-column align-items-start filters-list">
                @foreach($filter['active_attributes'] as $attribute)
                    @php
                        $filterUrlData = Functions::getFilterUrl($filter['slug'], $attribute['slug'], Request::path());
                        if ($discountSet) $filterUrlData['link'].'/discount';
                    @endphp
                    <a href="{{ route('index') }}/{{ $filterUrlData['link'] }}"
                       class="btn-filter @if($filterUrlData['isActive']) active @endif"
                    >
                        <span>{{ $attribute['name'] }}</span>
                        {!! Beautify::setThubm($attribute['name']) !!}
                    </a>
                @endforeach
            </div>
            @if(count($filter['active_attributes']) > 6)
                <p class="show-all-filters">Показать все</p>
            @endif
        </div>


    @endif
@endforeach

