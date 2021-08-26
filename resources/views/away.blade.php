@extends('layouts.main')

@section('title')
    Mr. Shopper
@endsection

@section('content')
    <div class="container-xxl">
        @include('sections.categories')

        <div class="w-100 d-flex justify-content-center mt-5 pt-5">
            <a href="{{ $href }}">
                <div class="mt-5">
                    <p class="font-30 t-center f-w-7">Проверяем наличие</p>
                    <p id="count" class="font-30 t-center f-w-7 cyan">..</p>
                </div>
            </a>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let
                count = 3, text = '..';
            setInterval(function (){
                console.log(document.getElementById('count'))
                document.getElementById('count').innerText = (text += '..');
            }, 500)
            setTimeout(function (){ document.location.href='{{ $href }}' }, 2000)
        });
    </script>
@endpush
