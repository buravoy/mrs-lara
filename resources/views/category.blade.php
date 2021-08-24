@extends('layouts.main')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/products.css') }}">
@endpush

@push('scripts')
    <script src="{{ asset('js/products.js') }}"></script>
@endpush

@section('meta_title')
    <title>{{ $category->meta_title ?? $meta['meta_title'] ?? $category->name }}</title>
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
        <div class="mb-4">
            @include('sections.breadcrumbs')
        </div>
        <div class="pb-3">
            <div class="mb-3">
                <h1 class="font-12 mb-3">{!! $meta['title'] ?? $category->name !!}</h1>
                <div class="font-09 ucfirst">{!! $category->short_description ?? $meta['description1'] !!}</div>
            </div>



            <div class="row">
                <div class="col-12 col-md-3">
                    @include('sections.filter')
                </div>
                <div class="col-12 col-md-9">

                    <div class="row px-2 mb-3">
                        @foreach($category->allChild->sortByDesc('count') as $cat)
                            @if($cat->count)
                                <div class="col-2 px-2 mb-1">
                                    <a href="{{ route('category',['category' => $cat->slug]) }}" class="deep-category mb-1">
                                        <span>{{ $cat->short_name }}</span>
                                    </a>
                                </div>
                            @endif
                        @endforeach
                    </div>

                    <div class="mb-3 d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <p class="condensed">
                                В каталоге <b>{{ $products->links()->paginator->total() }}</b>
                                {{Functions::plural($products->links()->paginator->total(), ['товар', 'товара', 'товаров'])  }}
                            </p>
                            <div class="sorting-group ml-2">
                                <select name="sort" id="" style="min-width: 200px;">
                                    <option value="asc" @if(isset($_COOKIE['sorting']) && $_COOKIE['sorting'] == 'asc') selected @endif>Сначала подешевле</option>
                                    <option value="desc" @if(isset($_COOKIE['sorting']) && $_COOKIE['sorting'] == 'desc') selected @endif>Сначала подороже</option>
                                    <option value="discount-desc" @if(isset($_COOKIE['sorting']) && $_COOKIE['sorting'] == 'discount-desc') selected @endif>По убыванию скидки</option>
                                    <option value="discount-asc" @if(isset($_COOKIE['sorting']) && $_COOKIE['sorting'] == 'discount-asc') selected @endif>По возрастанию скидки</option>
                                    <option value="abc" @if(!isset($_COOKIE['sorting']) || $_COOKIE['sorting'] == 'abc') selected @endif>По алфавиту</option>
                                </select>
                            </div>
                        </div>
                        <div class="sorting">
                            <div class="sorting-group">
                                <p class="mr-2">По </p>
                                <select name="paginate" id="" class="pr-0">
                                    <option value="20" @if(isset($_COOKIE['pagination']) && $_COOKIE['pagination'] == '20') selected @endif>20</option>
                                    <option value="60" @if(isset($_COOKIE['pagination']) && $_COOKIE['pagination'] == '60') selected @endif>60</option>
                                    <option value="100" @if(isset($_COOKIE['pagination']) && $_COOKIE['pagination'] == '100') selected @endif>100</option>
                                </select>
                                <p class="ml-2">на странице</p>
                            </div>

                        </div>
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

            <div class="my-5 ucfirst font-09">{!! $category->description ?? $meta['description2'] !!}</div>

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
