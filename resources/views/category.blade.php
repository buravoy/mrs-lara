@extends('layouts.main')

@section('meta')

    <title>@if($products->links()->paginator->currentPage() > 1)Страница {{ $products->links()->paginator->currentPage() }} - @endif{{ $category->meta_title ?? $meta['meta_title'] ?? $category->name }}</title>
    <meta name="description"
          content="@if($products->links()->paginator->currentPage() > 1)Страница {{ $products->links()->paginator->currentPage() }} - @endif{{ $category->meta_description ?? $meta['meta_description'] ?? 'Выбирайте - '. $category->name . ' в интернет каталоге Mr.Shopper' }}">
@endsection

@section('content')
    @php
        use App\Modules\Functions;
    @endphp
    <div class="container-xxl">
        @include('sections.categories')

        @include('sections.breadcrumbs')

        <div class="pb-3">
            <div class="mb-3 mb-md-5 wrapper">
                <h1 class="mb-3 capitalize">{!! $meta['title'] ?? $category->name !!}</h1>
                @if($products->links()->paginator->currentPage() == 1)
                    <div class="description ucfirst">{!! $category->short_description ?? $meta['description1'] !!}</div>
                @endif


            </div>

            <div class="row">
                <div class="col-12 col-md-3">
                    @include('sections.filter')
                </div>
                <div class="col-12 col-md-9">

                    <div class="row px-2 my-4">
                        @foreach($category->allChild->sortByDesc('count') as $cat)
                            @if($cat->count)
                                <div class="col-6 col-sm-3 col-lg-2 px-sm-2 px-1 mb-1">
                                    <a href="{{ route('category',['category' => $cat->slug]) }}" class="deep-category mb-1">
                                        @if($cat->short_name == true)
                                            <h3>{{ $cat->short_name }}</h3>
                                        @else
                                            <h3>{{ $cat->name }}</h3>
                                        @endif
                                    </a>
                                </div>
                            @endif
                        @endforeach
                    </div>

                    <div class="d-flex d-md-none justify-content-center mb-4">
                        <button type="button" class="btn btn-cyan uppercase" data-toggle="modal" data-target="#filters-popup">
                            <i class="fas fa-filter mr-2"></i>Фильтр товаров
                        </button>
                    </div>

                    <div class="mb-3 d-flex justify-content-between align-items-end" style="margin: 0 -5px;">
                        <div class="d-flex align-items-center flex-wrap">
                            <p class="count-text mr-2 py-2">
                                В каталоге
                                <b>{{ $products->links()->paginator->total() }}</b>
                                {{ Functions::plural($products->links()->paginator->total(), ['товар', 'товара', 'товаров']) }}
                            </p>
                            <div class="sorting-group">
                                <select name="sort" id="" style="min-width: 200px;">
                                    <option value="asc" @if(isset($_COOKIE['sorting']) && $_COOKIE['sorting'] == 'asc') selected @endif>Сначала подешевле</option>
                                    <option value="desc" @if(isset($_COOKIE['sorting']) && $_COOKIE['sorting'] == 'desc') selected @endif>Сначала подороже</option>
                                    <option value="created" @if(!isset($_COOKIE['sorting']) || $_COOKIE['sorting'] == 'created') selected @endif>Сначала новинки</option>
                                    <option value="discount-desc" @if(isset($_COOKIE['sorting']) && $_COOKIE['sorting'] == 'discount-desc') selected @endif>По размеру скидки</option>
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
                                <p class="ml-2 d-none d-sm-block">на&nbsp;странице</p>
                            </div>
                        </div>
                    </div>

                    <div class="row product-list" style="margin: 0 -10px;">
                        @if(!empty($products->items()))
                            @foreach($products as $product)
                                <div class="col-6 col-sm-4 col-lg-3 pb-2 px-0">
                                    @include('sections.product-card', ['product' => $product])
                                </div>
                            @endforeach
                        @else
                            <div class="w-100 d-flex py-5 my-5 justify-content-center">
                                <p>Ничего не найдено</p>
                            </div>

                        @endif
                    </div>
                </div>
            </div>

            <div class="py-3 pagination-block">
                {{ $products->links() }}
            </div>

            @if($products->links()->paginator->currentPage() == 1)
                <div class="my-5 wrapper">
                    <div class="description ucfirst">{!! $category->description ?? $meta['description2'] !!}</div>
                </div>
            @endif


        </div>
    </div>
@endsection


@push('modals')
    @include('sections.img-popup')
@endpush
