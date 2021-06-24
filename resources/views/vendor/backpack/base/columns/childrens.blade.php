@if(!$entry->child->isEmpty())

    <div class="d-flex align-items-start justify-content-between">


        <ul class="list-unstyled category-children-view">
            @foreach($entry->child as $child)
                @if($loop->iteration < 3)
                    <li>
                        <a class="small" href="{{ backpack_url('category') }}?id={{ $child->id }}">{{ $child->name }}</a>
                    </li>


                @else
                    @if($loop->iteration == 3)

                        <div class="list" style="display: none">@endif

                            <li>
                                <a class="small" href="{{ backpack_url('category') }}?id={{ $child->id }}">{{ $child->name }}</a>
                            </li>
                            @if($loop->last)</div>

                    @endif
                @endif
            @endforeach
        </ul>
        @if($entry->child->count() > 3)
            <button class="btn btn-sm btn-outline-primary category-list-toggle" onclick="$(this).parent().find('.list').slideToggle();$(this).find('i').toggleClass('rotate180')">
                <i class="small la la-chevron-down"></i>
            </button>
        @endif


    </div>



@endif

