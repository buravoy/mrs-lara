@php
    use App\Modules\Functions;
    use App\Modules\Beautify;
@endphp

@if (strpos(Request::path(), 'filter') !== false)
    <div class="selected t-center mb-5 d-md-block d-none">
        <div class="selected-filters"></div>
        <a href="{{ route('category', ['category' => $category->slug]) }}" class="btn mt-2 btn-red font-09 uppercase">Сбросить фильтры</a>
    </div>
@endif

<div class="filter d-none d-md-block" data-url="{{ route('filter-ajax') }}">
    @if(isset($category->parent))
        <div class="filters-group">
            <div class="d-flex flex-wrap align-items-start filters-list" style="max-height: unset;">
                @foreach(Functions::selectParallel($category->parent)->sortByDesc('count') as $categoryFirst)
                    @if($categoryFirst->count > 0)
                        <a href="{{ route('category',['category' => $categoryFirst->slug]) }}"
                           class="btn-assoc"
                           style="order:@if($categoryFirst->child->contains('id', $category->id))  0 @else 1 @endif">
                            <span>{{ $categoryFirst->short_name }}</span>
                        </a>
                    @endif

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


    <div class="ajax-filters">
        @foreach($filters as $filter)
            @if(!empty($filter['active_attributes']))
                <div class="filters-group" id="{{ $filter['slug'] }}">
                    <h4 class="my-2">{{ $filter['filter_name'] ?? $filter['name'] }}</h4>

                    <div class="d-flex flex-column align-items-start filters-list">
                        @foreach($filter['active_attributes'] as $attribute)
                            @php
                                $filterUrlData = Functions::getFilterUrl($filter['slug'], $attribute['slug'], Request::path());
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
                $discount = Functions::getDiscountUrl(Request::path());
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
    </div>


</div>

@push('modals')
    <div class="modal fade" id="filters-popup">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Фильтр товаров</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="modal-body p-3">
                    @if($category->parent && count($category->parent->allChild) > 1)
                        <div class="filters-group">
                            <div class="d-flex flex-wrap align-items-start filters-list" style="max-height: unset;">
{{--                                @foreach($category->parent->parent->allChild->sortByDesc('count') as $categoryFirst)--}}

{{--                                    <a href="{{ route('category',['category' => $categoryFirst->slug]) }}"--}}
{{--                                       class="btn-assoc"--}}
{{--                                       style="order:@if($categoryFirst->child->contains('id', $category->id))  0 @else 1 @endif">--}}
{{--                                        <span>{{ $categoryFirst->short_name }}</span>--}}
{{--                                    </a>--}}

{{--                                    @if($categoryFirst->child->contains('id', $category->id))--}}

{{--                                        @foreach($categoryFirst->allChild as $categorySecond)--}}
{{--                                            @if($categorySecond->count > 0)--}}
{{--                                                <a href="{{ route('category',['category' => $categorySecond->slug]) }}"--}}
{{--                                                   class="btn-assoc justify-content-start ml-md-3 ml-2 @if($categorySecond->id == $category->id) active @endif">--}}
{{--                                                    <span>{{ $categorySecond->short_name }}</span>--}}
{{--                                                </a>--}}
{{--                                            @endif--}}
{{--                                        @endforeach--}}
{{--                                    @endif--}}

{{--                                @endforeach--}}
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
                </div>
                <div class="modal-footer align-items-center justify-content-center">
                    <button class="btn btn-cyan condensed uppercase away-link" data-dismiss="modal">Закрыть</button>
                </div>
            </div>
        </div>
    </div>
@endpush

