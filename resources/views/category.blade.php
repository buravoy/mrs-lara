@extends('layouts.main')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
@endpush

@section('title')
    Категории
@endsection

@section('content')
    <div class="container-xxl">
        @include('sections.categories')

        <div class="p-3">
            <div class="row">
                @foreach($products as $product)
                    <div class="col-6 col-md-2 pb-2">
                        <h6>{{ $product->name }}</h6>
                        <p class="font-08">{{ $product->name }}</p>
                        <p class="font-08">{{ $product->description_1 }}</p>
                        <p class="font-08">{{ $product->price }}</p>
                        <p class="font-08">{{ $product->rating }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
