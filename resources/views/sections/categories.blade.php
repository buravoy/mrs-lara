<nav class="row relative mt-3">
    @foreach($categories as $category)
        <div class="col-sm-6 col-lg-3 col-12 px-3 px-sm-0">
            <div class="category-menu-toggle h-100">
                <div class="px-3 title d-flex h-100 align-items-center justify-content-sm-center justify-content-between">
                    <span>{{ $category->name }}</span>
                    <i class="las la-angle-down ms-3"></i>
                </div>
            </div>

            @if($category->menuChild)
                <div class="drop-categories-wrapper" style="display: none">
                    <div class="w-100 h-100 row p-0 m-0 wrapper-bg" style="background-image: url('{{ asset($category->image) }}')">
                        <div class="parent mt-3 mb-3">
                            <a class="btn btn-cyan-outline f-w-6" href="{{ route('category').'/'.$category->slug }}" >{{ $category->name }}</a>
                        </div>
                        @php
                            $firstChildren = $category->menuChild;
                            $cols = []; $key = 0;
                            foreach( $firstChildren as $item ) {
                                $cols[$key][] = $item;
                                if (++$key > 3) $key = 0;
                            }
                        @endphp

                        @foreach($cols as $col)
                            <div class="col-lg-3 col-md-6 col-12">
                                @foreach($col as $firstChild)
                                    <div class="sector mb-3">
                                        <a href="{{ route('category').'/'.$firstChild->slug }}" class="f-w-6 child-title d-block uppercase condensed px-3 py-1 mb-1">
                                            {{ $firstChild->name }}
                                        </a>

                                        @if($firstChild->menuChild)
                                            @foreach($firstChild->menuChild as $secondChild)
                                                <a href="{{ route('category').'/'.$secondChild->slug }}" class="child-element d-block font-09 ps-4 pe-2 f-w-4 uppercase condensed">
                                                    {{ $secondChild->name }}
                                                </a>
                                            @endforeach
                                        @endif
                                    </div>

                                @endforeach
                            </div>

                        @endforeach
                    </div>
                </div>
            @endif
        </div>

    @endforeach
</nav>