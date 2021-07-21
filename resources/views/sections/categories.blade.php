@dump($categories)


<li>
    {{ $category->name  }}
    @if ($category->child()->count() > 0 )
        <ul>
            @foreach($category->child as $category)


                @include('category', $category)

            @endforeach
        </ul>

    @endif
</li>