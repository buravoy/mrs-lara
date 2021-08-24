@php
    use App\Modules\Functions;
    use App\Modules\Beautify;
@endphp

@if($category->parent && count($category->parent->allChild) > 1)
    <div class="filters-group">
        <div class="d-flex flex-wrap align-items-start filters-list" style="max-height: unset;">
            @foreach($category->parent->parent->allChild->sortByDesc('count') as $categoryFirst)

                <a href="{{ route('category',['category' => $categoryFirst->slug]) }}"
                   class="btn-assoc"
                   style="order:@if($categoryFirst->child->contains('id', $category->id))  0 @else 1 @endif">
                    <span>{{ $categoryFirst->short_name }}</span>
                </a>

                @if($categoryFirst->child->contains('id', $category->id))

                    @foreach($categoryFirst->allChild as $categorySecond)
                        @if($categorySecond->count > 0)
                            <a href="{{ route('category',['category' => $categorySecond->slug]) }}"
                               class="btn-assoc justify-content-start ml-md-3 ml-2 @if($categorySecond->id == $category->id) active @endif">
                                <span>{{ $categorySecond->short_name }}</span>
                            </a>
                        @endif
                    @endforeach
                @endif

            @endforeach
        </div>
    </div>
@endif



@foreach($filters as $filter)
    @if(!empty($filter['active_attributes']) && count($filter['active_attributes']) > 1)
        <div class="filters-group">
            <h4 class="my-2">{{ $filter['filter_name'] ?? $filter['name'] }}</h4>

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
                <div class="d-flex justify-content-center">
                    <p class="show-all-filters d-flex align-items-center">Показать все <i class="ml-2 fas fa-chevron-down"></i></p>
                </div>
            @endif
        </div>
    @endif
@endforeach

@if($discountAvailable != null)
    @php
        $discount = Functions::getDiscountUrl(Request::path());
    @endphp
    <div class="filters-group">
        <div class="d-flex flex-wrap align-items-start filters-list">
            <a href="{{ route('index') }}/{{ $discount['link'] }}"
               class="btn-filter btn-sale @if($discount['isActive']) active @endif">
                <span>распродажа  <span class="red"> SALE</span></span>
            </a>
        </div>
    </div>
@endif

