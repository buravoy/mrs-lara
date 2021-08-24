<ul class="breadcrumbs">
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