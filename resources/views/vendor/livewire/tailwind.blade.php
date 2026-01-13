<div>
    @if ($paginator->hasPages())
        <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-between">

            {{-- Mobile View --}}
            <div class="flex justify-between flex-1 sm:hidden gap-2">
                @if ($paginator->onFirstPage())
                    <span class="relative inline-flex items-center px-4 py-2 text-[10px] font-medium text-[#666] uppercase tracking-widest bg-white/5 border border-white/5 cursor-not-allowed ">
                        Previous
                    </span>
                @else
                    <button wire:click="previousPage" wire:loading.attr="disabled" class="relative inline-flex items-center px-4 py-2 text-[10px] font-medium text-white uppercase tracking-widest bg-white/5 border border-white/10  hover:text-accent hover:border-accent/50 transition-all duration-300">
                        Previous
                    </button>
                @endif

                @if ($paginator->hasMorePages())
                    <button wire:click="nextPage" wire:loading.attr="disabled" class="relative inline-flex items-center px-4 py-2 text-[10px] font-medium text-white uppercase tracking-widest bg-white/5 border border-white/10  hover:text-accent hover:border-accent/50 transition-all duration-300">
                        Next
                    </button>
                @else
                    <span class="relative inline-flex items-center px-4 py-2 text-[10px] font-medium text-[#666] uppercase tracking-widest bg-white/5 border border-white/5 cursor-not-allowed ">
                        Next
                    </span>
                @endif
            </div>

            {{-- Desktop View --}}
            <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                <div>
                    <p class="text-[13px] text-[#666] uppercase font-semibold tracking-wider">
                        Showing
                        <span class="font-medium text-white">{{ $paginator->firstItem() }}</span>
                        to
                        <span class="font-medium text-white">{{ $paginator->lastItem() }}</span>
                        of
                        <span class="font-medium text-white">{{ $paginator->total() }}</span>
                        results
                    </p>
                </div>

                <div>
                    <span class="relative z-0 inline-flex shadow-sm gap-1">
                        {{-- Previous Page Link --}}
                        @if ($paginator->onFirstPage())
                            <span aria-disabled="true" aria-label="{{ __('pagination.previous') }}">
                                <span class="relative inline-flex items-center justify-center w-8 h-8 text-[#444] bg-white/5 border border-white/5 cursor-not-allowed " aria-hidden="true">
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                                    </svg>
                                </span>
                            </span>
                        @else
                            <button wire:click="previousPage" rel="prev" class="relative inline-flex items-center justify-center w-8 h-8 text-[#888] bg-white/5 border border-white/10  hover:text-accent hover:border-accent/50 hover:bg-white/10 transition-all duration-300" aria-label="{{ __('pagination.previous') }}">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        @endif

                        {{-- Pagination Elements --}}
                        @foreach ($elements as $element)
                            {{-- "Three Dots" Separator --}}
                            @if (is_string($element))
                                <span aria-disabled="true">
                                    <span class="relative inline-flex items-center justify-center w-8 h-8 text-[13px] font-medium text-[#666] bg-transparent border border-transparent cursor-default">
                                        {{ $element }}
                                    </span>
                                </span>
                            @endif

                            {{-- Array Of Links --}}
                            @if (is_array($element))
                                @foreach ($element as $page => $url)
                                    @if ($page == $paginator->currentPage())
                                        <span aria-current="page">
                                            <span class="relative inline-flex items-center justify-center w-8 h-8 text-[13px] font-bold text-accent bg-accent/10 border border-accent/50 shadow-[0_0_10px_rgba(var(--accent-rgb),0.2)]  cursor-default">
                                                {{ $page }}
                                            </span>
                                        </span>
                                    @else
                                        <button wire:click="gotoPage({{ $page }})" class="relative inline-flex items-center justify-center w-8 h-8 text-[10px] font-medium text-[#888] bg-white/5 border border-white/10  hover:text-white hover:border-white/30 hover:bg-white/10 transition-all duration-300">
                                            {{ $page }}
                                        </button>
                                    @endif
                                @endforeach
                            @endif
                        @endforeach

                        {{-- Next Page Link --}}
                        @if ($paginator->hasMorePages())
                            <button wire:click="nextPage" rel="next" class="relative inline-flex items-center justify-center w-8 h-8 text-[#888] bg-white/5 border border-white/10  hover:text-accent hover:border-accent/50 hover:bg-white/10 transition-all duration-300" aria-label="{{ __('pagination.next') }}">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        @else
                            <span aria-disabled="true" aria-label="{{ __('pagination.next') }}">
                                <span class="relative inline-flex items-center justify-center w-8 h-8 text-[#444] bg-white/5 border border-white/5 cursor-not-allowed " aria-hidden="true">
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                    </svg>
                                </span>
                            </span>
                        @endif
                    </span>
                </div>
            </div>
        </nav>
    @endif
</div>