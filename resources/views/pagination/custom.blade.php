@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination" class="flex items-center gap-2">
        {{-- Previous --}}
        @if ($paginator->onFirstPage())
            <span class="p-2 rounded text-on-surface-variant opacity-50 cursor-not-allowed">
                <span class="material-symbols-outlined text-[20px]">chevron_left</span>
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}"
               class="p-2 rounded text-on-surface-variant hover:bg-surface-container-highest hover:text-on-surface transition-colors">
                <span class="material-symbols-outlined text-[20px]">chevron_left</span>
            </a>
        @endif

        {{-- Page Numbers --}}
        @foreach ($elements as $element)
            @if (is_string($element))
                <span class="px-3 py-1 font-ui-label text-ui-label text-on-surface-variant">{{ $element }}</span>
            @endif

            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="px-3 py-1 rounded-lg bg-emerald-500 text-white font-ui-label text-ui-label">
                            {{ $page }}
                        </span>
                    @else
                        <a href="{{ $url }}"
                           class="px-3 py-1 rounded-lg font-ui-label text-ui-label text-on-surface-variant hover:bg-surface-container-highest hover:text-on-surface transition-colors">
                            {{ $page }}
                        </a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}"
               class="p-2 rounded text-on-surface-variant hover:bg-surface-container-highest hover:text-on-surface transition-colors">
                <span class="material-symbols-outlined text-[20px]">chevron_right</span>
            </a>
        @else
            <span class="p-2 rounded text-on-surface-variant opacity-50 cursor-not-allowed">
                <span class="material-symbols-outlined text-[20px]">chevron_right</span>
            </span>
        @endif
    </nav>
@endif
