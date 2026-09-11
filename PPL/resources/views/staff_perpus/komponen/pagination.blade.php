@if ($paginator instanceof Illuminate\Pagination\LengthAwarePaginator && $paginator->hasPages())
    <nav aria-label="Page navigation" class="mt-6 flex items-center justify-between border-t border-slate-200 px-4 py-3 sm:px-6">
        <div class="hidden sm:block">
            <p class="text-xs text-slate-500 font-mono">
                Menampilkan <span class="font-semibold text-slate-700">{{ $paginator->firstItem() }}</span> - <span class="font-semibold text-slate-700">{{ $paginator->lastItem() }}</span> dari <span class="font-semibold text-slate-700">{{ $paginator->total() }}</span> hasil
            </p>
        </div>
        <ul class="flex items-center gap-1 text-xs">
            <li>
                <a href="{{ $paginator->onFirstPage() ? '#' : $paginator->previousPageUrl() }}"
                    class="px-3 py-1.5 rounded-lg border border-slate-200 text-slate-700 hover:bg-slate-50 transition-colors {{ $paginator->onFirstPage() ? 'opacity-40 pointer-events-none' : '' }}">
                    Sebelumnya
                </a>
            </li>
            @foreach (range(1, $paginator->lastPage()) as $pages)
                @if ($paginator->currentPage() == $pages)
                    <li>
                        <span aria-current="page"
                            class="px-3 py-1.5 rounded-lg bg-brand-800 text-white font-semibold font-mono">
                            {{ $pages }}
                        </span>
                    </li>
                @else
                    <li>
                        <a href="{{ $paginator->url($pages) }}"
                            class="px-3 py-1.5 rounded-lg border border-slate-200 text-slate-700 hover:bg-slate-50 transition-colors font-mono">
                            {{ $pages }}
                        </a>
                    </li>
                @endif
            @endforeach
            <li>
                <a href="{{ $paginator->onLastPage() ? '#' : $paginator->nextPageUrl() }}"
                    class="px-3 py-1.5 rounded-lg border border-slate-200 text-slate-700 hover:bg-slate-50 transition-colors {{ $paginator->onLastPage() ? 'opacity-40 pointer-events-none' : '' }}">
                    Selanjutnya
                </a>
            </li>
        </ul>
    </nav>
@endif

