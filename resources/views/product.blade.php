@extends('layouts.main')

@section('title')
    {{ $product->name }}
@endsection

@section('content')
    <div class="container-xxl">
        @include('sections.categories')

        @include('sections.breadcrumbs')

        @dump($product)
    </div>

@endsection
