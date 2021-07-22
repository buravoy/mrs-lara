<nav class="row relative">
    @foreach($categories as $category)
        <div class="col-md-3">
            <div class="category-menu-toggle">
                <p class="t-center">{{ $category->name }}</p>
            </div>

            @if($category->menuChild)
                <div class="drop-categories-wrapper row" style="display: none">
                    @foreach($category->menuChild as $firstChild)
                        <div class="col-3">
                            <p class="font-09 mb-2">{{ $firstChild->name }}</p>


                            @if($firstChild->menuChild)

                            @foreach($firstChild->menuChild as $secondChild)

                                <p class="font-08 ms-2">{{ $secondChild->name }}</p>

                            @endforeach

                        @endif
                        </div>

                    @endforeach


                </div>
            @endif
        </div>

    @endforeach
</nav>

<style>


    .drop-categories-wrapper {
        position: absolute;
        left: 0;
        right: 0;
        background-color: white;
        z-index: 9;
    }
</style>