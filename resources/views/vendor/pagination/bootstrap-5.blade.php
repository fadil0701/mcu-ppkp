@if ($paginator->hasPages())
    <nav class="mt-4 flex flex-wrap items-center justify-center gap-2">
        <div class="inline-flex items-center overflow-hidden rounded-lg border border-gray-200 bg-white text-theme-sm shadow-theme-xs dark:border-gray-800 dark:bg-gray-800">
            {{-- Previous («) --}}
            @if ($paginator->onFirstPage())
                <span class="inline-flex items-center px-3 py-2 text-gray-400 dark:text-gray-500" aria-disabled="true">
                    <span aria-hidden="true">&laquo;</span>
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="inline-flex items-center px-3 py-2 text-gray-600 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700" aria-label="Sebelumnya">
                    &laquo;
                </a>
            @endif

            {{-- Page numbers & ellipsis --}}
            @foreach ($elements as $element)
                @if (is_string($element))
                    <span class="inline-flex items-center border-l border-gray-200 px-3 py-2 text-gray-400 dark:border-gray-700 dark:text-gray-500">{{ $element }}</span>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span class="inline-flex items-center border-l border-gray-200 bg-brand-500 px-3 py-2 font-medium text-white dark:border-gray-700 dark:bg-brand-500" aria-current="page">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" class="inline-flex items-center border-l border-gray-200 px-3 py-2 text-brand-600 hover:bg-gray-100 dark:border-gray-700 dark:text-brand-400 dark:hover:bg-gray-700">{{ $page }}</a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next (») --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="inline-flex items-center border-l border-gray-200 px-3 py-2 text-gray-600 hover:bg-gray-100 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700" aria-label="Selanjutnya">
                    &raquo;
                </a>
            @else
                <span class="inline-flex items-center border-l border-gray-200 px-3 py-2 text-gray-400 dark:border-gray-700 dark:text-gray-500" aria-disabled="true">
                    <span aria-hidden="true">&raquo;</span>
                </span>
            @endif
        </div>
    </nav>

    {{-- Results info --}}
    <div class="mt-2 text-center">
        <p class="text-theme-xs text-gray-500 dark:text-gray-400">
            Menampilkan {{ $paginator->firstItem() ?? 0 }} sampai {{ $paginator->lastItem() ?? 0 }} dari {{ $paginator->total() }} hasil
        </p>
    </div>
@endif
