<main class="max-w-7xl mx-auto mt-32 px-6 pb-20 relative">
    
    {{-- Header & Filters --}}
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-12 border-b border-white/10 pb-6">
        <div>
            <h1 class="text-2xl text-white font-semibold mb-2">Saved Archives</h1>
            <p class="text-xs text-[#666] uppercase tracking-widest">Personal Data Collection</p>
        </div>

        <div class="flex flex-col md:flex-row gap-4 w-full md:w-auto">
            <div class="relative group min-w-[180px]">
                <select wire:model.live="categoryFilter" 
                    class="w-full appearance-none bg-[#0a0a0f] border border-white/10 px-4 py-3 text-xs text-white uppercase tracking-wider focus:outline-none focus:border-accent hover:border-white/30 transition-colors cursor-pointer">
                    <option value="">All Categories</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                    @endforeach
                </select>
                <div class="absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none text-[#666] group-hover:text-white transition-colors">
                    <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
                </div>
            </div>

            <div class="relative group w-full md:w-64">
                <input wire:model.live.debounce.300ms="search" type="text"
                    class="w-full bg-[#0a0a0f] border border-white/10 pl-10 pr-4 py-3 text-xs text-white focus:outline-none focus:border-accent transition-all placeholder-[#444] font-display uppercase tracking-wider"
                    placeholder="Search Archives...">
                <div class="absolute left-3 top-1/2 -translate-y-1/2 text-[#444] group-focus-within:text-accent transition-colors">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                </div>
            </div>
        </div>
    </div>

    {{-- Grid Layout --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($articles as $article)
            @php $themeColor = $article->category->color_code ?? '#ffffff'; @endphp

            <div wire:key="saved-{{ $article->id }}" 
                 style="--card-theme: {{ $themeColor }}"
                 class="group relative bg-[#0a0a0f] border border-white/10 hover:border-[var(--card-theme)] transition-all duration-500 flex flex-col h-full rounded-sm overflow-hidden">
                
                {{-- Image --}}
                <div class="relative w-full aspect-video overflow-hidden border-b border-white/5">
                    @if($article->thumbnail)
                        <img src="{{ $article->thumbnail }}" class="w-full h-full object-cover opacity-60 group-hover:opacity-100 group-hover:scale-105 transition-all duration-700 grayscale group-hover:grayscale-0">
                    @else
                        <div class="w-full h-full bg-white/5 flex items-center justify-center">
                            <svg class="w-10 h-10 text-white/20" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                    @endif
                    
                    @if($article->category)
                        <div class="absolute top-3 left-3 px-2 py-1 bg-[#0a0a0f]/90 border backdrop-blur-md text-[9px] uppercase tracking-widest font-bold"
                             style="color: var(--card-theme); border-color: var(--card-theme);">
                            {{ $article->category->name }}
                        </div>
                    @endif
                </div>

                {{-- Content Body --}}
                <div class="p-6 flex-1 flex flex-col relative">
                    <h3 class="text-lg font-light text-white leading-tight mb-3 transition-colors duration-300 group-hover:text-[var(--card-theme)]">
                        <a href="{{ route('article.show', $article->slug) }}">{{ Str::limit($article->title, 55) }}</a>
                    </h3>
                    
                    <div class="mt-auto pt-4 border-t border-white/5 flex items-center justify-between">
                        <div class="flex flex-col">
                            <span class="text-[9px] text-[#666] uppercase tracking-widest">Saved On</span>
                            <span class="text-[10px] text-white font-mono">{{ $article->pivot->created_at->format('M d, Y') }}</span>
                        </div>
                        
                        <div class="flex items-center gap-3">
                            <a href="{{ route('article.show', $article->slug) }}" class="text-xs text-white hover:text-[var(--card-theme)] uppercase tracking-wider transition-colors font-bold">Read</a>
                            <div class="h-3 w-px bg-white/10"></div>
                            
                            {{-- Remove Button Trigger --}}
                            <button wire:click="confirmRemove({{ $article->id }})" 
                                    class="group/btn text-xs text-[#666] hover:text-red-500 uppercase tracking-wider transition-colors flex items-center gap-1">
                                
                                <span class="decoration-red-500 underline-offset-4">Remove</span>
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Decor --}}
                <div class="absolute top-0 left-0 w-2 h-2 border-l border-t border-white/10 group-hover:border-[var(--card-theme)] transition-colors duration-300"></div>
                <div class="absolute bottom-0 right-0 w-2 h-2 border-r border-b border-white/10 group-hover:border-[var(--card-theme)] transition-colors duration-300"></div>
            </div>
        @empty
            <div class="col-span-full py-24 text-center border border-dashed border-white/10 bg-white/[0.02]">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-white/5 text-[#444] mb-6">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1"><path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>
                <h3 class="text-white font-light text-lg mb-2">No Matches Found</h3>
                <p class="text-[#666] mb-6 text-xs uppercase tracking-widest max-w-sm mx-auto">
                    {{ $search ? 'Your search parameters yielded no results in the archive.' : 'No archives have been saved to local storage.' }}
                </p>
                @if($search || $categoryFilter)
                    <button wire:click="$set('search', ''); $set('categoryFilter', '')" class="text-accent hover:underline text-xs uppercase tracking-widest">Clear Filters</button>
                @else
                    <a href="{{ route('article.index') }}" class="inline-flex items-center gap-2 border border-white/20 px-6 py-3 text-xs text-white uppercase tracking-widest hover:bg-white hover:text-black transition-all">Browse Grid</a>
                @endif
            </div>
        @endforelse
    </div>

    <div class="pt-10">
        {{ $articles->links() }}
    </div>

    {{-- MODAL: Remove Confirmation --}}
    @if ($isDeleteModalOpen)
        <div class="fixed inset-0 z-50 flex items-center justify-center">
            {{-- Backdrop --}}
            <div class="absolute inset-0 bg-black/90 backdrop-blur-sm" wire:click="closeDeleteModal"></div>
            
            {{-- Modal Content --}}
            <div class="relative w-full max-w-sm p-6 bg-[#0a0a0a] border border-red-500/30 shadow-[0_0_30px_rgba(255,0,0,0.15)] z-10 text-center animate-fade-in-down">
                <div class="flex justify-center mb-4">
                    <div class="w-12 h-12 rounded-full bg-red-500/10 flex items-center justify-center text-red-500">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18M19 6v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a2 2 0 012-2h4a2 2 0 012 2v2M10 11v6M14 11v6"/></svg>
                    </div>
                </div>
                
                <h3 class="text-lg text-white font-light mb-2">Confirm Removal</h3>
                <p class="text-xs text-[#888] font-mono mb-6">Remove this article from your personal collection? This action cannot be undone.</p>
                
                <div class="flex gap-3">
                    <button wire:click="closeDeleteModal" class="flex-1 bg-white/5 border border-white/10 text-white py-3 text-[10px] font-bold uppercase tracking-widest hover:bg-white/10 transition-colors">
                        Cancel
                    </button>
                    <button wire:click="remove" class="flex-1 bg-red-500/10 border border-red-500/50 text-red-500 py-3 text-[10px] font-bold uppercase tracking-widest hover:bg-red-500 hover:text-white transition-all">
                        Remove
                    </button>
                </div>
            </div>
        </div>
    @endif

</main>