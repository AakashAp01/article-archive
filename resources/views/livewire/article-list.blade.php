<main class="max-w-7xl mx-auto mt-32 px-6 pb-20 relative ">

    {{-- Header Section --}}
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-12 border-b border-white/10 pb-6">
        <div>
            <h1 class="text-2xl text-white font-semibold mb-2">Articles
                <p class="text-xs text-[#666] uppercase tracking-widest">Content Grid Management</p>
        </div>

        <div class="flex flex-col xl:flex-row items-center gap-4 w-full md:w-auto">

            {{-- FILTER GROUP --}}
            <div class="flex flex-col md:flex-row gap-4 w-full md:w-auto">

                {{-- Category Filter --}}
                <div class="relative group min-w-[150px]">
                    <select wire:model.live="categoryFilter"
                        class="w-full bg-black/20 border border-white/10 px-4 py-3 text-xs text-white focus:outline-none focus:border-accent transition-all font-display uppercase tracking-wider appearance-none cursor-pointer hover:bg-black/40">
                        <option value="" class="bg-black text-white">All Categories</option>
                        @foreach ($categories as $cat)
                            <option value="{{ $cat->id }}" class="bg-black text-white">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                    {{-- Dropdown Icon --}}
                    <div
                        class="absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none text-white/30 group-hover:text-accent transition-colors">
                        <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path d="M6 9l6 6 6-6" />
                        </svg>
                    </div>
                </div>

                {{-- Status Filter --}}
                <div class="relative group min-w-[150px]">
                    <select wire:model.live="statusFilter"
                        class="w-full bg-black/20 border border-white/10 px-4 py-3 text-xs text-white focus:outline-none focus:border-accent transition-all font-display uppercase tracking-wider appearance-none cursor-pointer hover:bg-black/40">
                        <option value="" class="bg-black text-white">All Statuses</option>
                        <option value="published" class="bg-black text-white">Published (Live)</option>
                        <option value="draft" class="bg-black text-white">Draft (Offline)</option>
                    </select>
                    <div
                        class="absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none text-white/30 group-hover:text-accent transition-colors">
                        <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path d="M6 9l6 6 6-6" />
                        </svg>
                    </div>
                </div>

                {{-- Search Bar --}}
                <div class="relative w-full md:w-64 group">
                    <input wire:model.live.debounce.300ms="search" type="text"
                        class="w-full bg-black/20 border border-white/10 px-10 py-3 text-xs text-white focus:outline-none focus:border-accent transition-all placeholder-white/20 font-display uppercase tracking-wider"
                        placeholder="SEARCH DATABASE...">
                    <div
                        class="absolute left-3 top-1/2 -translate-y-1/2 text-white/30 group-focus-within:text-accent transition-colors">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <circle cx="11" cy="11" r="8"></circle>
                            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                        </svg>
                    </div>
                </div>
            </div>

            {{-- Link to Create Page --}}
            <a href="{{ route('article.create') }}"
                class="w-full md:w-auto group flex items-center justify-center gap-3 bg-white/5 border border-white/20 hover:border-accent px-6 py-3 transition-all hover:bg-accent/10 cursor-pointer">

                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" class="text-white group-hover:text-accent transition-colors">
                    <path d="M12 5v14M5 12h14" />
                </svg>

                <span class="text-xs text-white uppercase tracking-widest group-hover:text-accent font-display">
                    Compose New
                </span>
            </a>

        </div>
    </div>

    {{-- Table --}}
    <div class="space-y-4">
        {{-- Headers --}}
        <div
            class="hidden md:grid grid-cols-12 gap-4 text-[10px] uppercase tracking-widest text-[#666] px-6 pb-2 font-display">
            <div class="col-span-4">Article Data</div>
            <div class="col-span-2 text-center">Category</div>
            <div class="col-span-2 text-center">Engagement</div>
            <div class="col-span-2 text-center">Status</div>
            <div class="col-span-2 text-right">Controls</div>
        </div>

        @forelse($articles as $article)
            <div
                class="group relative bg-white/[0.02] border border-white/5 hover:border-accent/50 transition-all duration-300 p-6 md:p-4 rounded-sm">
                <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center">

                    {{-- 1. Thumbnail & Title --}}
                    <div class="col-span-1 md:col-span-4">
                        <div class="flex items-center gap-4">
                            {{-- Thumb --}}
                            <div class="w-20 h-10 bg-black/50 border border-white/10 overflow-hidden shrink-0 relative">
                                @if ($article->thumbnail)
                                    <img src="{{ $article->thumbnail }}"
                                        class="w-full h-full object-cover opacity-60 group-hover:opacity-100 transition-opacity">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-[#333]">
                                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2">
                                            <rect x="3" y="3" width="18" height="18" rx="2"
                                                ry="2"></rect>
                                            <circle cx="8.5" cy="8.5" r="2"></circle>
                                            <path d="M21 15l-5-5L5 21"></path>
                                        </svg>
                                    </div>
                                @endif
                                {{-- Draft Overlay --}}
                                @if ($article->status === 'draft')
                                    <div class="absolute inset-0 bg-black/60 flex items-center justify-center">
                                        <span
                                            class="text-[8px] font-bold text-white uppercase tracking-wider border border-white/20 px-1">Draft</span>
                                    </div>
                                @endif
                            </div>

                            {{-- Text --}}
                            <div class="min-w-0">
                                <h3
                                    class="text-sm font-medium text-white truncate group-hover:text-accent transition-colors">
                                    {{ $article->title }}</h3>
                                <div class="flex items-center gap-2 mt-1">
                                    <span
                                        class="text-[9px] font-mono text-[#666]">{{ $article->created_at->format('d M Y') }}</span>
                                    @if ($article->meta_title)
                                        <span
                                            class="text-[8px] border border-[#333] text-[#444] px-1 rounded uppercase">SEO
                                            OK</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- 2. Category Badge --}}
                    <div class="col-span-1 md:col-span-2 flex md:justify-center">
                        @if ($article->category)
                            <span class="px-2 py-1 text-[9px] uppercase tracking-wider border"
                                style="color: {{ $article->category->color_code }}; border-color: {{ $article->category->color_code }}40; background-color: {{ $article->category->color_code }}10;">
                                {{ $article->category->name }}
                            </span>
                        @else
                            <span class="text-[9px] text-[#444] uppercase">Uncategorized</span>
                        @endif
                    </div>

                    {{-- 3. Engagement --}}
                    <div class="col-span-1 md:col-span-2 flex md:justify-center items-center gap-4">

                        {{-- Likes --}}
                        <div class="flex items-center gap-1.5 text-[#666] group-hover:text-pink-500 transition-colors"
                            title="Likes">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2">
                                <path
                                    d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z">
                                </path>
                            </svg>
                            <span class="text-xs font-mono">{{ $article->likes_count ?? 0 }}</span>
                        </div>

                        {{-- Comments --}}
                        <div class="flex items-center gap-1.5 text-[#666] group-hover:text-blue-400 transition-colors"
                            title="Comments">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2">
                                <path
                                    d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z">
                                </path>
                            </svg>
                            <span class="text-xs font-mono">{{ $article->comments_count ?? 0 }}</span>
                        </div>

                        {{-- Reports --}}
                        <div class="flex items-center gap-1.5 text-[#666] group-hover:text-red-500 transition-colors"
                            title="Reports">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2">
                                <path d="M12 9v2m0 4h.01M3 6h18M5 6v14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V6H5z"></path>
                            </svg>
                            <span class="text-xs font-mono">{{ $article->reports_count ?? 0 }}</span>
                        </div>

                    </div>


                    {{-- 4. Status Toggle --}}
                    <div class="col-span-1 md:col-span-2 flex md:justify-center">
                        <button wire:click="toggleStatus({{ $article->id }})"
                            class="relative inline-flex h-5 w-10 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none 
                            {{ $article->status === 'published' ? 'bg-accent/20' : 'bg-white/10' }}">

                            <span aria-hidden="true"
                                class="pointer-events-none inline-block h-4 w-4 transform rounded-full shadow ring-0 transition duration-200 ease-in-out 
                                {{ $article->status === 'published' ? 'translate-x-5 bg-accent' : 'translate-x-0 bg-[#666]' }}">
                            </span>
                        </button>
                    </div>

                    {{-- 5. Actions --}}
                    <div
                        class="col-span-1 md:col-span-2 flex items-center justify-start md:justify-end gap-2 mt-4 md:mt-0 pt-4 md:pt-0 border-t md:border-t-0 border-white/5">

                        {{-- Edit --}}
                        <a href="{{ route('article.edit', $article->id) }}"
                            class="w-8 h-8 flex items-center justify-center border border-white/10 bg-black/20 text-[#888] hover:border-white hover:text-white hover:bg-white/5 transition-all">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2">
                                <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z" />
                            </svg>
                        </a>

                        {{-- View --}}
                        <a href="{{ route('article.show', $article->slug) }}"
                            class="w-8 h-8 flex items-center justify-center border border-white/10 bg-black/20 text-[#888] hover:border-white hover:text-white hover:bg-white/5 transition-all"
                            title="View Article">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                <circle cx="12" cy="12" r="3"></circle>
                            </svg>
                        </a>

                        {{-- Delete --}}
                        <button wire:click="confirmDelete({{ $article->id }})"
                            class="w-8 h-8 flex items-center justify-center border border-red-500/20 bg-red-500/5 text-red-400 hover:border-red-500 hover:bg-red-500 hover:text-white transition-all">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2">
                                <path d="M3 6h18" />
                                <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6" />
                                <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2" />
                            </svg>
                        </button>

                    </div>

                </div>

                {{-- Hover Decor --}}
                <div class="absolute top-0 left-0 w-2 h-2 border-l border-t border-white/20 group-hover:border-accent">
                </div>
                <div
                    class="absolute bottom-0 right-0 w-2 h-2 border-r border-b border-white/20 group-hover:border-accent">
                </div>
            </div>
        @empty
            <div class="py-20 text-center border border-dashed border-white/10 rounded-sm">
                <p class="text-[#666] mb-4 font-display">No articles found matching filters.</p>
                <a href="{{ route('article.create') }}"
                    class="text-accent hover:underline text-sm uppercase font-display">Initialize First Entry</a>
            </div>
        @endforelse

        <div class="pt-6">
            {{ $articles->links() }}
        </div>
    </div>

    {{-- Delete Modal --}}
    @if ($isDeleteModalOpen)
        <div class="fixed inset-0 z-50 flex items-center justify-center">
            <div class="absolute inset-0 bg-black/90 backdrop-blur-sm" wire:click="$set('isDeleteModalOpen', false)">
            </div>
            <div
                class="relative w-full max-w-sm p-6 bg-[#0a0a0a] border border-red-500/30 shadow-[0_0_30px_rgba(255,0,0,0.1)] z-10 text-center">
                <svg class="mx-auto w-12 h-12 text-red-500 mb-4" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="1">
                    <path
                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                <h3 class="text-lg text-white font-light mb-2">Confirm Delete!</h3>
                <p class="text-xs text-[#888] font-mono mb-6">Permanently delete this entry?</p>
                <div class="flex gap-3">
                    <button wire:click="$set('isDeleteModalOpen', false)"
                        class="flex-1 bg-white/5 border border-white/10 text-white py-3 text-[10px] font-bold uppercase tracking-widest hover:bg-white/10">Cancel</button>
                    <button wire:click="delete"
                        class="flex-1 bg-red-600/20 border border-red-500/50 text-red-500 py-3 text-[10px] font-bold uppercase tracking-widest hover:bg-red-600 hover:text-white transition-all">Confirm</button>
                </div>
            </div>
        </div>
    @endif
</main>

@script
<script>
    Livewire.on('show-toast', (data) => {

        const payload = Array.isArray(data) ? data[0] : data;

        if (window.showToast) {
            window.showToast(
                payload.type, 
                payload.title, 
                payload.message
            );
        } else {
            console.error('window.showToast function is not loaded.');
        }
    });
</script>
@endscript
