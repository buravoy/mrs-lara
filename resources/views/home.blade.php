@extends('layouts.main')

@section('title')
    Главная
@endsection

@section('content')
    <div class="container-xxl">
        @include('sections.categories')
    </div>
@endsection