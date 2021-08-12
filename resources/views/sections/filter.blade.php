<div>




    <h4>Посмотрите еще:</h4>

    <div>
        @foreach($category->parent->allChild->sortByDesc('count') as $categoryFirst)
            @if($categoryFirst->id != $category->id && $categoryFirst->count > 0)
                <a href="{{ route('category',['category' => $categoryFirst->slug]) }}" class="btn-cyan mb-1">{{ $categoryFirst->short_name }}</a>
            @endif
        @endforeach
    </div>


    <hr>

    <h4>атрибуты</h4>
    <div>
        @foreach($filters as $filter)
            @if($filter->attributes->count() > 1)
                <p>{{ $filter->name }}</p>


                @foreach($filter->attributes as $attribute)
                    <a href="{{ route('filter') }}/{{ $category->slug }}/{{ $filter->slug }}_{{ $attribute->slug }}"
                       class="btn-cyan mb-1">
                        {{ $attribute->name }}
                    </a>
                @endforeach


            @endif
        @endforeach
    </div>


    @dump($filters)
</div>
