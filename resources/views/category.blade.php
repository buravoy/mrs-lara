@extends('layouts.main')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/products.css') }}">
@endpush

@section('title')
    {{ $category->name }}
@endsection

@section('content')
    <div class="container-xxl">
        @include('sections.categories')

        <div class="py-3">

            <div class="row mb-3">
                <h1 class="font-11 mb-3">{{ $category->name }}</h1>
                <p class="mb-4"> {{ $description }}</p>
            </div>

            <div class="row">

                <div class="col-3">
                    @include('sections.filter')
                </div>

                <div class="col-9">
                    <div class="row">
                        @foreach($products as $product)
{{--                            @dump($product->image)--}}
                            <div class="col-6 col-md-4 pb-2">
                                <div class="product-card">
                                    <div class="product-img" data-sourse="{{ json_encode($product->image) }}">
                                        <img src="{{ $product->image[0] }}" alt="">
                                    </div>
                                    <h6>{{ $product->name }}</h6>
                                    <p class="font-08">{{ $product->name }}</p>
                                    <p class="font-08">{{ $product->description_1 }}</p>
                                    <p class="font-08">{{ $product->price }}</p>
                                    <p class="font-08">{{ $product->rating }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="py-3">
                {{ $products->onEachSide(1)->links() }}
            </div>
        </div>
    </div>
@endsection
