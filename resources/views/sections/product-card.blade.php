<div class="product-card">
    @if($product->discount)
        <p class="discount">-{{ $product->discount }} %</p>
    @endif

    <div
        class="product-img"
        data-source="{{ json_encode($product->image) }}"
        data-title="{{ $product->name }}">

        @include('sections.rating', ['value' => $product->rating])
        <img src="{{ $product->image[0] }}" alt="">

    </div>

    <a href="#">
        <div class="price">
            @if($product->old_price)
                <p class="old">{{ $product->old_price }}</p>
            @endif
            <p class="new">{{ $product->price }}<i class="fas fa-ruble-sign"></i></p>
        </div>

        <div class="title">
            <h2>{{ $product->name }}</h2>
        </div>
    </a>

    <div class="about">
        <a href="#">Подробнее</a>
    </div>
</div>
