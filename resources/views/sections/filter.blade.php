<div>
    <h4>Категории</h4>
    <div>
        @foreach($filters['category']->parent->allChild->sortBy('sort') as $categoryFirst)
            @if($categoryFirst->id != $filters['category']->id)
                <a href="{{ route('category',['category' => $categoryFirst->slug]) }}" class="btn-cyan mb-1">{{ $categoryFirst->short_name }}</a>
            @endif
        @endforeach
    </div>


    <hr>
    @if($filters['discount']['count'])
        <h4>Распродажа</h4>
        <div>
            <a
                    @if($filters['attribute'] && $filters['attribute'] != 'all')
                    href="{{ route('category', [
                                'category' => $filters['category']->slug,
                                'attr' => $filters['attribute'],
                                'discount' => $filters['discount']['link']
                                ]) }}"

                    @endif

                    @if($filters['attribute'] == 'all' && !$filters['discount']['link'])
                    href="{{ route('category', [
                                'category' => $filters['category']->slug,
                                ]) }}"

                    @endif



               class="btn-cyan mb-1 @if(!$filters['discount']['link']) f-w-9 @endif">
                распродажа
            </a>
        </div>
    @endif

    <hr>

    <h4>атрибуты</h4>
    <div>
        @foreach($filters['attributes'] as $attribute)
            @if($attribute->attributes->count() > 1)
                <p>{{ $attribute->name }}</p>


                @foreach($attribute->attributes as $value)
                    <a href="{{ route('category', [
                                            'category' => $filters['category']->slug,
                                            'attr' => $attribute->slug.'_'.$value->slug,
                                            'discount' => !$filters['discount']['link']
                                            ]) }}"
                       class="btn-cyan mb-1">
                        {{ $value->name }}
                    </a>
                @endforeach


            @endif
        @endforeach
    </div>


    @dump($filters)
</div>
