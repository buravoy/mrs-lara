<div>
    <h4>Категории</h4>
    <div>
        @foreach($filters['category']->allChild->sortBy('sort') as $categoryFirst)
            @if($categoryFirst->count)
                @foreach($categoryFirst->allChild->sortBy('sort') as $categorySecond)
                    @if($categorySecond->count)
                        <a href="{{ route('category') }}/{{ $categorySecond->slug }}" class="btn-cyan mb-1">{{ $categorySecond->short_name }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach
    </div>


    <hr>

    <h4>Распродажа</h4>
    <div>

        <a href="{{ route($filters['route'], ['category' => $filters['category']->slug, 'discount' => $filters['discount']['link']]) }}"
           class="btn-cyan mb-1 @if(!$filters['discount']) f-w-9 @endif">
            распродажа
        </a>

    </div>

    <hr>

    <h4>атрибуты</h4>
    <div>
        @foreach($filters['attributes'] as $attribute)
            @if($attribute->attributes->count() > 1)
                <p>{{ $attribute->name }}</p>
                @foreach($attribute->attributes as $value)
                    <a href="#" class="btn-cyan mb-1">{{ $value->name }}</a>
                @endforeach
            @endif
        @endforeach
    </div>


{{--    @dump($filters)--}}
</div>
