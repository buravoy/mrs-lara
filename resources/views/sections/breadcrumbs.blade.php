<div class="d-flex align-items-start mb-md-5 mb-3 mt-md-3 mt-3">
    <a href="{{ route('index') }}" class="breadcrumbs-home">
        <i class="fas fa-home"></i>
    </a>

<ul class="breadcrumbs">

    @foreach(\App\Modules\Functions::generateBreadcrumbsArr($category) as $item)
        <li>
            <a href="{{ route('category',['category' => $item->slug]) }}" title="{{ $item->short_name ?? $item->name }}">
                {{ \Illuminate\Support\Str::limit( $item->short_name ?? $item->name, 35) }}
            </a>
        </li>
    @endforeach

    @if(isset($product))
        <li>
            <a href="{{ route('product',['slug' => $product->slug]) }}" title="{{ $product->name }}">
                {{ \Illuminate\Support\Str::limit($product->name, 35) }}
            </a>
        </li>
    @endif

</ul>

</div>