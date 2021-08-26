@php
    use App\Modules\Functions;
    use App\Modules\Beautify;
@endphp

@foreach($filters as $filter)
    @if(!empty($filter['active_attributes']))
        <div class="filters-group" id="{{ $filter['slug'] }}">
            <h4 class="my-2">{{ $filter['filter_name'] ?? $filter['name'] }}</h4>

            <div class="d-flex flex-column align-items-start filters-list">
                @foreach($filter['active_attributes'] as $attribute)
                    @php
                        $filterUrlData = Functions::getFilterUrl($filter['slug'], $attribute['slug'], $path);
                        if ($discountSet) $filterUrlData['link'].'/discount';
                    @endphp

                    @if(count($filter['active_attributes']) > 1 || $filterUrlData['isActive'])

                        <div class="filter-row">
                            <div class="btn-filter @if($filterUrlData['isActive']) active @endif"
                                 data-href="{{ $filterUrlData['link'] }}"
                            >

                                <span>{{ $attribute['name'] }}</span>
                                {!! Beautify::setThubm($attribute['name']) !!}
                            </div>
                            <a href="{{ route('index') }}/{{ $filterUrlData['link'] }}">
                                <i class="fas fa-angle-double-right filter-href"></i>
                            </a>
                        </div>

                    @endif
                @endforeach
            </div>
            @if(count($filter['active_attributes']) > 6)
                <div class="d-flex justify-content-center">
                    <p class="show-all-filters d-flex align-items-center">Показать все
                        <i class="ml-2 fas fa-chevron-down"></i>
                    </p>
                </div>
            @endif
        </div>
    @endif
@endforeach

@if($discountAvailable != null)
    @php
        $discount = Functions::getDiscountUrl($path);
    @endphp
    <div class="filters-group" id="rasprodazha">
        <div class="d-flex flex-wrap align-items-start filters-list">
            <a href="{{ route('index') }}/{{ $discount['link'] }}"
               class="btn-filter btn-sale @if($discount['isActive']) active @endif">
                <span>распродажа  <span class="red"> SALE</span></span>
            </a>
        </div>
    </div>
@endif

<a href="{{ route('index').'/'.$path }}">Показать {{ $products }} товаров</a>
