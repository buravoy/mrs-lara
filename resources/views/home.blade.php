@extends('layouts.main')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
@endpush

@section('title')
    Главная
@endsection

@section('content')
    <div class="container-xxl">
        @include('sections.categories')
    </div>
@endsection