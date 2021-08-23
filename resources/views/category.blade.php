@extends('layouts.main')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/products.css') }}">
@endpush

@push('scripts')
    <script src="{{ asset('js/products.js') }}"></script>
@endpush

@section('meta_title')
    <title>{{ $category->meta_title ?? $meta['meta_title'] ?? $category->name }} - Mr.Shopper</title>
@endsection

@section('meta_description')
    <meta name="description"
          content="{{ $category->meta_description ?? $meta['meta_description'] ?? 'Выбирайте - '. $category->name . ' в интернет каталоге Mr.Shopper' }}">
@endsection

@section('content')
    @php
        use App\Modules\Functions;
    @endphp
    <div class="container-xxl">
        @include('sections.categories')
        <div class="py-3">
            <div class="mb-3">
                <h1 class="font-10 mb-3">{!! $meta['title'] ?? $category->name !!}</h1>
                <p class="font-09 mb-5 ucfirst">{!! $category->short_description ?? $meta['description1'] !!}</p>
            </div>
            <div class="row">
                <div class="col-12 col-md-3">
                    @include('sections.filter')
                </div>
                <div class="col-12 col-md-9">
                    <p class="mb-2">
                        В каталоге: <b>{{ $products->links()->paginator->total() }}</b>
                        {{Functions::plural($products->links()->paginator->total(), ['товар', 'товара', 'товаров'])  }}
                    </p>
                    <div class="">
                        @foreach($category->allChild->sortByDesc('count') as $cat)
                            @if($cat->count)
                                <a href="{{ route('category',['category' => $cat->slug]) }}" class="btn-cyan mb-1">{{ $cat->short_name }}</a>
                            @endif
                        @endforeach
                    </div>
                    <div class="row">
                        @if(!empty($products->items()))
                            @foreach($products as $product)
                                <div class="col-6 col-sm-4 col-lg-3 pb-2 px-0">
                                    @include('sections.product-card', ['product' => $product])
                                </div>
                            @endforeach
                        @else
                            <p>Ничего не найдено</p>
                        @endif
                    </div>
                </div>
            </div>
            <div class="py-3">
                {{ $products->onEachSide(1)->links() }}
            </div>
            @if($page == 'category')
                <p class="my-5">{!! $category->description ?? $meta['description2'] !!}</p>
            @endif
            @if($page == 'filter')
                <p class="my-5">Filter</p>
            @endif
        </div>
    </div>
@endsection

@section('modals')
    <div class="modal fade" id="images-popup">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="modal-body p-0">
                    <div id="carousel" class="carousel slide">
                        <div class="carousel-inner border-bottom"></div>
                        <ol class="carousel-indicators justify-content-start my-2 mx-3"></ol>
                    </div>

                    <div class="d-flex justify-content-center">
                        <ul class="attributes p-3"></ul>
                    </div>
                </div>
                <div class="modal-footer align-items-center justify-content-center">
                    <a href="#" class="btn btn-cyan condensed uppercase away-link" target="_blank">В МАГАЗИН</a>
                </div>
            </div>
        </div>
    </div>
@endsection
