@php
    use App\Modules\Functions;
    use App\Modules\Beautify;
@endphp
<div class="ajax-filters">
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

                            <div class="filter-row" @if(isset($filterUrlData['isActive']) && $filterUrlData['isActive']) style="order: -1" @endif>
                                <div class="btn-filter @if(isset($filterUrlData['isActive']) && $filterUrlData['isActive']) active @endif"
                                     data-href="{{ $filterUrlData['link'] }}">
                                    <span>{{ $attribute['name'] }}</span>
                                    @if(isset($attribute['name']))
                                        {!! Beautify::setThubm($attribute['name']) !!}
                                    @endif
                                </div>
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

                <div class="filter-row">
                    <div class="btn-filter btn-sale @if($discount['isActive']) active @endif"
                         data-href="{{ $discount['link'] }}">

                        <span>распродажа  <span class="red"> SALE</span></span>
                        @if(isset($attribute['name']))
                            {!! Beautify::setThubm($attribute['name']) !!}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif

    <a class="ajax-search filter-result btn btn-cyan" href="{{ route('index').'/'.$path }}">
        Показать<span class="pr-2"><b class="px-2">{{ $products }}</b>{{ Functions::plural($products, ['товар', 'товара', 'товаров']) }}</span>
    </a>

    <a class="filter-modal-href filter-result btn btn-cyan" href="{{ route('index').'/'.$path }}">
        Показать<span class="pr-2"><b class="px-2">{{ $products }}</b>{{ Functions::plural($products, ['товар', 'товара', 'товаров']) }}</span>
    </a>

</div>

