@extends('layouts.main')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
@endpush

@section('title')
    Главная
@endsection

@section('content')
    <div class="container-xxl">
        <ul>
            @foreach ($categories as $category)
                @if($category->parent_id == null )
                    @include('sections.categories', $category)
                @endif
            @endforeach
        </ul>
    </div>
@endsection
