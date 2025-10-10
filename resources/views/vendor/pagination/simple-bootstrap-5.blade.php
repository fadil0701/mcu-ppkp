@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="d-flex justify-content-center mt-4">
        <div class="d-flex align-items-center">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <span class="btn btn-outline-secondary btn-sm disabled me-2">
                    <i class="fas fa-chevron-left"></i> Previous
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="btn btn-outline-primary btn-sm me-2" rel="prev">
                    <i class="fas fa-chevron-left"></i> Previous
                </a>
            @endif

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="btn btn-outline-primary btn-sm ms-2" rel="next">
                    Next <i class="fas fa-chevron-right"></i>
                </a>
            @else
                <span class="btn btn-outline-secondary btn-sm disabled ms-2">
                    Next <i class="fas fa-chevron-right"></i>
                </span>
            @endif
        </div>
    </nav>
@endif
