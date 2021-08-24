@extends('layouts.main')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/products.css') }}">
@endpush

@push('scripts')
    <script src="{{ asset('js/products.js') }}"></script>
@endpush

@section('title')
    {{ $product->name }}
@endsection

@section('content')
    <div class="container-xxl">
        @include('sections.categories')

        <div class="my-5">
            @include('sections.breadcrumbs')
        </div>

        @dump($product)
    </div>

@endsection
