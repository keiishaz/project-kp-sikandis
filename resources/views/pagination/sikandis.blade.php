@if ($paginator->hasPages())
    <nav class="pagination" role="navigation" aria-label="Pagination">
        <div class="pagination-inner">
            @if ($paginator->onFirstPage())
                <span class="page-btn disabled">Sebelumnya</span>
            @else
                <a class="page-btn" href="{{ $paginator->previousPageUrl() }}" rel="prev">Sebelumnya</a>
            @endif

            <div class="page-numbers">
                @foreach ($elements as $element)
                    @if (is_string($element))
                        <span class="page-ellipsis">{{ $element }}</span>
                    @endif

                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <span class="page-number active">{{ $page }}</span>
                            @else
                                <a class="page-number" href="{{ $url }}">{{ $page }}</a>
                            @endif
                        @endforeach
                    @endif
                @endforeach
            </div>

            @if ($paginator->hasMorePages())
                <a class="page-btn" href="{{ $paginator->nextPageUrl() }}" rel="next">Berikutnya</a>
            @else
                <span class="page-btn disabled">Berikutnya</span>
            @endif
        </div>
        <div class="pagination-meta">
            Menampilkan {{ $paginator->firstItem() ?? 0 }} - {{ $paginator->lastItem() ?? 0 }} dari {{ $paginator->total() }}
        </div>
    </nav>
@endif
