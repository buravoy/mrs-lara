@php
    $start = $paginator->getUrlRange(1, 1);
    if ($paginator->currentPage() <= 2) $rangeLength = 5 - $paginator->currentPage();
    elseif ($paginator->currentPage() >= $paginator->lastPage()-2) $rangeLength = 4 - ($paginator->lastPage()-$paginator->currentPage());
    else  $rangeLength = 2;
    $range = $paginator->getUrlRange( $paginator->currentPage()-$rangeLength, $paginator->currentPage()+$rangeLength );
    $end = $paginator->getUrlRange( $paginator->lastPage(), $paginator->lastPage() );
@endphp

@if ($paginator->hasPages())
    <div class="d-flex justify-content-center mb-5">
        <button class="btn btn-cyan uppercase add-more"
                data-href="{{ $paginator->nextPageUrl() }}"
                data-current="{{ $paginator->currentPage() }}"
                data-last="{{ $paginator->lastPage() }}">
            Загрузить еще
        </button>
    </div>

    <nav>
        <ul class="pagination">

            <li class="page-item @if($paginator->currentPage() == 1) disabled @endif">
                <a href="{{ $paginator->previousPageUrl() }}" class="page-link" aria-hidden="true">‹</a>
            </li>

            @if( !array_intersect($start, $range) )
                @foreach($start as $page => $link)
                    <li class="page-item @if($paginator->currentPage() == $page) active @endif" aria-current="page">
                        <a class="page-link" href="{{ $link }}">{{ $page }}</a>
                    </li>
                @endforeach
                <li class="page-item disabled" aria-disabled="true">
                    <span class="page-link">...</span>
                </li>
            @endif


            @foreach($range as $page => $link)
                @continue($page <= 0)
                <li class="page-item @if($paginator->currentPage() == $page) active @endif" aria-current="page">
                    <a class="page-link" href="{{ $link }}">{{ $page }}</a>
                </li>
                @break($page >= $paginator->lastPage())
            @endforeach

            @if( !array_intersect($end, $range) )
                <li class="page-item disabled" aria-disabled="true">
                    <span class="page-link">...</span>
                </li>
                @foreach($end as $page => $link)
                    <li class="page-item" aria-current="page">
                        <a class="page-link" href="{{ $link }}">{{ $page }}</a>
                    </li>
                @endforeach
            @endif

            <li class="page-item @if($paginator->currentPage() == $paginator->lastPage()) disabled @endif">
                <a href="{{ $paginator->nextPageUrl() }}" class="page-link" aria-hidden="true"> > </a>
            </li>

        </ul>
    </nav>
@endif