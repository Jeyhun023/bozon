@if ($paginator->hasPages())
    <div class="pagination">
        <span class="f-size-14 c-black-op-75">
             {{  $paginator->currentPage() . "  of  " . $paginator->lastPage() }}
        </span>
        <div class="pagination-nav">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <a href="" class="disabled">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g >
                            <path d="M11.3333 6L7.33333 10L11.3333 14" stroke="#0B0B18" stroke-linecap="square"/>
                        </g>
                    </svg>
                </a>
            @else
                <a href="{{ $paginator->previousPageUrl() }}">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g >
                            <path d="M11.3333 6L7.33333 10L11.3333 14" stroke="#0B0B18" stroke-linecap="square"/>
                        </g>
                    </svg>
                </a>
            @endif
            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M8.66666 14L12.6667 10L8.66667 6" stroke="#0B0B18" stroke-linecap="square"/>
                    </svg>
                </a>
            @else
                <a href="" class="disabled">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M8.66666 14L12.6667 10L8.66667 6" stroke="#0B0B18" stroke-linecap="square"/>
                    </svg>
                </a>
            @endif
        </div>
    </div>
@endif
