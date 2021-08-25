<ul class="breadcrumbs mb-md-5 mb-3 mt-md-3 mt-3">
    <li>
        <a href="{{ route('index') }}">
            <i class="fas fa-home"></i>
        </a>
    </li>


    @foreach(\App\Modules\Functions::generateBreadcrumbsArr($category) as $item)
        <li>
            <a href="{{ route('category',['category' => $item->slug]) }}">
                {{ $item->short_name ?? $item->name }}
            </a>
        </li>
    @endforeach

    @if(isset($product))
        <li>
            <a href="{{ route('product',['slug' => $product->slug]) }}">
                {{ $product->name }}
            </a>
        </li>
    @endif

</ul>