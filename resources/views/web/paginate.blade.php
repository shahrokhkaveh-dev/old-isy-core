@if ($paginator->hasPages())
    <nav class="pagination-wrapper">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <span class="pagination-item disabled">صفحه قبلی</span>
        @else
            <a class="pagination-item" href="{{ $paginator->previousPageUrl() }}">صفحه قبلی</a>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <span class="pagination-item disabled">{{ $element }}</span>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="pagination-item active">{{ $page }}</span>
                    @else
                        <a class="pagination-item" href="{{ $url }}">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a class="pagination-item" href="{{ $paginator->nextPageUrl() }}">صفحه بعدی</a>
        @else
            <span class="pagination-item disabled">صفحه بعدی</span>
        @endif
    </nav>
@endif

