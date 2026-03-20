@if ($paginator->hasPages())
    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" class="flex items-center justify-between">
        <div class="flex items-center gap-2">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <span class="px-6 py-3 rounded-xl bg-slate-50 text-slate-300 text-[10px] font-black uppercase tracking-[0.2em] border border-slate-100 cursor-not-allowed italic">
                    &larr; Previous
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="px-6 py-3 rounded-xl bg-white text-slate-900 text-[10px] font-black uppercase tracking-[0.2em] border border-slate-200 hover:bg-slate-900 hover:text-white hover:border-slate-900 transition-all shadow-sm italic">
                    &larr; Previous
                </a>
            @endif

            {{-- Pagination Elements --}}
            <div class="hidden md:flex items-center gap-1 mx-4">
                @foreach ($elements as $element)
                    {{-- "Three Dots" Separator --}}
                    @if (is_string($element))
                        <span class="px-3 text-slate-300 font-black">...</span>
                    @endif

                    {{-- Array Of Links --}}
                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <span class="h-10 w-10 flex items-center justify-center rounded-xl bg-indigo-600 text-white text-[11px] font-black italic shadow-lg shadow-indigo-500/20">
                                    {{ $page }}
                                </span>
                            @else
                                <a href="{{ $url }}" class="h-10 w-10 flex items-center justify-center rounded-xl bg-white text-slate-600 text-[11px] font-black hover:bg-indigo-50 hover:text-indigo-600 transition-all italic tracking-tighter">
                                    {{ $page }}
                                </a>
                            @endif
                        @endforeach
                    @endif
                @endforeach
            </div>

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="px-6 py-3 rounded-xl bg-white text-slate-900 text-[10px] font-black uppercase tracking-[0.2em] border border-slate-200 hover:bg-slate-900 hover:text-white hover:border-slate-900 transition-all shadow-sm italic">
                    Next &rarr;
                </a>
            @else
                <span class="px-6 py-3 rounded-xl bg-slate-50 text-slate-300 text-[10px] font-black uppercase tracking-[0.2em] border border-slate-100 cursor-not-allowed italic">
                    Next &rarr;
                </span>
            @endif
        </div>

        <div class="hidden lg:block text-[10px] font-black text-slate-400 uppercase tracking-widest italic translate-y-0.5">
            Page {{ $paginator->currentPage() }} of {{ $paginator->lastPage() }}
        </div>
    </nav>
@endif
