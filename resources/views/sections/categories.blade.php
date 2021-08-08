<nav class="row relative my-3 categories-menu">
    @foreach($categories as $category)
        @if($category->count)
            <div class="col-sm-6 col-md-3 col-12 px-3 px-sm-0 position-unset">
                <div class="category-menu-toggle h-100">
                    <div class="px-3 title d-flex h-100 align-items-center justify-content-sm-center justify-content-between">
                        <span>{{ $category->short_name ?? $category->name }}</span>
                        <i class="fas fa-chevron-down ml-3"></i>
                    </div>
                </div>
                @if($category->child)
                    <div class="drop-categories-wrapper" style="display: none">

                        <div class="w-100 h-100 row pt-3 pb-0 px-0 m-0 wrapper-bg" style="background-image: url('{{ asset($category->image) }}')">
                            @php
                                $firstChildren = $category->child;
                                $cols = []; $key = 0;
                                foreach( $firstChildren as $item ) {
                                    $cols[$key][] = $item;
                                    if (++$key > 3) $key = 0;
                                }
                            @endphp

                            @foreach($cols as $col)
                                <div class="col-lg-3 col-md-6 col-12">
                                    @foreach($col as $firstChild)

                                        @if($firstChild->count)
                                            <div class="sector mb-3">

                                                <a href="{{ route('category').'/'.$firstChild->slug }}" class="f-w-6 child-title d-flex align-items-center justify-content-between uppercase condensed px-3 py-1 mb-1">
                                                    {{ $firstChild->short_name ?? $firstChild->name }}
                                                    <i class="fas fa-angle-double-right"></i>
                                                </a>

                                                @if($firstChild->child)
                                                    <div class="d-flex flex-column">
                                                        @foreach($firstChild->child as $secondChild)
                                                            @if($secondChild->count)
                                                                <a href="{{ route('category').'/'.$secondChild->slug }}" class="child-element d-flex align-items-center justify-content-between font-09 px-4 mb-1 f-w-4 uppercase condensed">
                                                                    {{ $secondChild->short_name ?? $secondChild->name }}
                                                                </a>
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                @endif
                                            </div>
                                        @endif
                                    @endforeach
                                </div>

                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        @endif
    @endforeach
</nav>
