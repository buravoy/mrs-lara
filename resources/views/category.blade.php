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
                    <div class="col-6 col-md-4">
                        <h2>{{ $product->name }}</h2>
                        <p>{{ $product->name }}</p>
                        <p>{{ $product->description_1 }}</p>
                        <p>{{ $product->price }}</p>
                        <p>{{ $product->rating }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>


@endsection
