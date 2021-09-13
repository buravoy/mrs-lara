<div class="product-card card-wrapper">
    @if($product->discount)
        <p class="discount">-{{ $product->discount }} %</p>
    @endif

    <div
        class="product-img img-popup"
        @if (!empty($product->image)) data-source="{{ json_encode($product->image) }}" @endif
        data-title="{{ $product->name }}"
        data-attributes="{{ $product->attributes }}"
        data-url="{{ route('product-info') }}"
        data-href="{{ $product->href }}"
        data-away="{{ route('away') }}/{{ $product->slug }}"
    >
        @include('sections.rating', ['value' => $product->rating])

        @if (!empty($product->image))
            <img src="{{ $product->image[0] }}" alt="{{ $product->name }}">
        @else
            <i class="far fa-image font-30 grey-light"></i>
        @endif
    </div>

    <a href="{{ route('away') }}/{{ $product->slug }}" target="_blank" rel="nofollow" style="max-width: 100%;">
        <div class="price">
            @if($product->old_price)
                <p class="old">{{ $product->old_price }}</p>
            @endif
            <p class="new">{{ $product->price }}<i class="fas fa-ruble-sign"></i></p>
        </div>

        <div class="title">
            @if(isset($related))
                <h3>{{ $product->name }}</h3>
            @else
                <h2>{{ $product->name }}</h2>
            @endif
        </div>

        <div class="description">
            @foreach(\App\Modules\Functions::convertAttributes($product->attributes) as $group => $attribute)
                <span>{{ $group }} <strong>{{ $attribute }}</strong></span>
            @endforeach
        </div>
    </a>

    <div class="about">
        <a href="{{ route('product') }}/{{ $product->slug }}"><i class="fas fa-info-circle"></i></a>
    </div>
</div>
