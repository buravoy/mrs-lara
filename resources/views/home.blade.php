@extends('layouts.main')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
@endpush

@section('title')
    Главная
@endsection

@section('content')
    <div class="container-xxl">
        <h1>Hello!</h1>
    </div>
@endsection
