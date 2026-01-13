<main class="max-w-7xl mx-auto mt-32 px-6 pb-20 relative ">

    {{-- Header Section --}}
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-12 border-b border-white/10 pb-6">
        <div>
            <h1 class="text-2xl text-white font-semibold mb-2">Article Categories</h1>
            <p class="text-xs text-[#666] uppercase tracking-widest">Database Taxonomy Management</p>
        </div>

        <div class="flex flex-col md:flex-row items-center gap-4 w-full md:w-auto">
            {{-- Search Bar --}}
            <div class="relative w-full md:w-64 group">
                <input wire:model.live.debounce.300ms="search" type="text"
                    class="w-full bg-black/20 border border-white/10 px-10 py-3 text-xs text-white focus:outline-none focus:border-accent transition-all placeholder-white/20 font-display uppercase tracking-wider"
                    placeholder="Search Grid...">
                <div class="absolute left-3 top-1/2 -translate-y-1/2 text-white/30 group-focus-within:text-accent transition-colors">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                </div>
            </div>

            {{-- Initialize Button --}}
            <button wire:click="openModal"
                class="w-full md:w-auto group flex items-center justify-center gap-3 bg-white/5 border border-white/20 hover:border-accent px-6 py-3 transition-all hover:bg-accent/10">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="text-white group-hover:text-accent transition-colors"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                <span class="text-xs text-white uppercase tracking-widest group-hover:text-accent font-display">Initialize New</span>
            </button>
        </div>
    </div>

    {{-- Data Table / Grid --}}
    <div class="space-y-4">

        {{-- Grid Headers (Desktop) --}}
        <div class="hidden md:grid grid-cols-12 gap-4 text-[10px] uppercase tracking-widest text-[#666] px-6 pb-2 font-display">
            <div class="col-span-1">ID</div>
            <div class="col-span-1">Color</div>
            <div class="col-span-4">Designation</div>
            <div class="col-span-2 text-center">Status</div>
            <div class="col-span-2">Last Sync</div>
            <div class="col-span-2 text-right">Controls</div>
        </div>

        {{-- Rows --}}
        @forelse($categories as $cat)
            <div class="group relative bg-white/[0.02] border border-white/5 hover:border-accent/50 transition-all duration-300 p-6 md:p-4 rounded-sm">
                <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center">

                    {{-- ID --}}
                    <div class="col-span-1 text-[#666] font-display text-xs">
                        <span class="md:hidden mr-2 uppercase tracking-widest text-[10px]">ID:</span>
                        #{{ str_pad($cat->id, 3, '0', STR_PAD_LEFT) }}
                    </div>

                    {{-- Color --}}
                    <div class="col-span-1">
                        <div class="flex items-center gap-3">
                            <div class="w-3 h-3 rounded-full shadow-[0_0_10px_rgba(0,0,0,0.5)]" 
                                 style="background-color: {{ $cat->color_code }}; box-shadow: 0 0 8px {{ $cat->color_code }}"></div>
                            <span class="text-[10px] font-display text-[#666]">{{ $cat->color_code }}</span>
                        </div>
                    </div>

                    {{-- Name --}}
                    <div class="col-span-1 md:col-span-4">
                        <h3 class="text-white text-base group-hover:text-accent transition-colors">{{ $cat->name }}</h3>
                    </div>

                    {{-- Status Toggle --}}
                    <div class="col-span-1 md:col-span-2 flex md:justify-center">
                        <button wire:click="toggleStatus({{ $cat->id }})" 
                            class="relative inline-flex h-5 w-10 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none {{ $cat->status ? 'bg-accent/20' : 'bg-white/10' }}">
                            
                            {{-- Slider --}}
                            <span aria-hidden="true" 
                                class="pointer-events-none inline-block h-4 w-4 transform rounded-full shadow ring-0 transition duration-200 ease-in-out {{ $cat->status ? 'translate-x-5 bg-accent' : 'translate-x-0 bg-[#666]' }}">
                            </span>
                        </button>
                        <span class="ml-3 text-[10px] uppercase tracking-widest font-display {{ $cat->status ? 'text-accent' : 'text-[#666]' }}">
                            {{ $cat->status ? 'Online' : 'Offline' }}
                        </span>
                    </div>

                    {{-- Date --}}
                    <div class="col-span-1 md:col-span-2 text-xs text-[#666] uppercase font-display">
                        <span class="md:hidden mr-2 uppercase tracking-widest text-[10px]">Updated:</span>
                        {{ $cat->updated_at->diffForHumans() }}
                    </div>

                    {{-- Actions --}}
                    <div class="col-span-1 md:col-span-2 flex items-center justify-start md:justify-end gap-2 mt-4 md:mt-0 pt-4 md:pt-0 border-t md:border-t-0 border-white/5">
                        <button wire:click="edit({{ $cat->id }})" 
                            class="w-8 h-8 flex items-center justify-center border border-white/10 bg-black/20 text-[#888] hover:border-white hover:text-white hover:bg-white/5 transition-all">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2">
                                    <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z" />
                                </svg>
                        </button>
                        
                        <button wire:click="confirmDelete({{ $cat->id }})"
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

                {{-- Hover Corners --}}
                <div class="absolute top-0 left-0 w-2 h-2 border-l border-t border-white/20 group-hover:border-accent"></div>
                <div class="absolute bottom-0 right-0 w-2 h-2 border-r border-b border-white/20 group-hover:border-accent"></div>
            </div>
        @empty
            <div class="py-20 text-center border border-dashed border-white/10 rounded-sm">
                <p class="text-[#666] mb-4 font-display">No classifications found in current sector.</p>
                <button wire:click="openModal" class="text-accent hover:underline text-sm uppercase font-display">Initialize First Classification</button>
            </div>
        @endforelse

        {{-- Pagination --}}
        <div class="pt-6">
            {{ $categories->links() }} 
        </div>
    </div>

    {{-- Create/Edit Modal --}}
    @if ($isModalOpen)
        <div class="fixed inset-0 z-50 flex items-center justify-center">
            <div class="absolute inset-0 bg-black/80 backdrop-blur-sm" wire:click="closeModal"></div>
            <div class="relative w-full max-w-md p-8 bg-[#0a0a0a] border border-white/10 shadow-2xl z-10">
                
                {{-- Modal Header --}}
                <div class="flex justify-between items-start mb-6">
                    <div>
                        <h2 class="text-xl text-white font-light">{{ $categoryId ? 'Edit Classification' : 'New Classification' }}</h2>
                        <p class="text-[10px] text-[#666] uppercase tracking-widest font-mono mt-1">Define taxonomy parameters</p>
                    </div>
                    <button wire:click="closeModal" class="text-[#666] hover:text-white transition-colors">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6L6 18M6 6l12 12" /></svg>
                    </button>
                </div>

                <form wire:submit="store">
                    <div class="space-y-6">
                        {{-- Name Input --}}
                        <div>
                            <label class="block text-[10px] text-[#888] uppercase tracking-widest mb-2 font-mono">Category Name</label>
                            <input wire:model="name" type="text"
                                class="w-full bg-white/5 border border-white/10 px-4 py-3 text-white focus:outline-none focus:border-accent transition-colors placeholder-white/20 font-mono text-sm"
                                placeholder="e.g., NEURAL NETWORKS">
                            @error('name') <span class="text-red-500 text-[10px] uppercase mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        {{-- Color Input --}}
                        <div>
                            <label class="block text-[10px] text-[#888] uppercase tracking-widest mb-2 font-mono">Color Code</label>
                            <div class="flex gap-4">
                                <input wire:model.live="color_code" type="color" class="h-11 w-12 bg-transparent border border-white/10 cursor-pointer p-1">
                                <input wire:model.live="color_code" type="text" class="flex-1 bg-white/5 border border-white/10 px-4 py-3 text-white focus:outline-none focus:border-accent transition-colors placeholder-white/20 font-mono text-sm uppercase">
                            </div>
                            @error('color_code') <span class="text-red-500 text-[10px] uppercase mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        {{-- Status Checkbox (Only in Modal) --}}
                        <div class="flex items-center gap-3 border border-white/10 p-3 bg-white/5">
                            <input wire:model="status" type="checkbox" id="modalStatus" class="w-4 h-4 rounded border-gray-300 text-accent focus:ring-accent bg-transparent">
                            <label for="modalStatus" class="text-xs text-white font-mono uppercase tracking-wide">Category Active</label>
                        </div>

                        {{-- Submit --}}
                        <div class="pt-4 border-t border-white/5">
                            <button type="submit" class="w-full bg-white text-black hover:bg-accent px-6 py-3 uppercase tracking-widest text-xs transition-all duration-300 relative">
                                <span wire:loading.remove wire:target="store">{{ $categoryId ? 'Update Category' : 'Deploy Category' }}</span>
                                <span wire:loading wire:target="store">Processing...</span>
                            </button>
                        </div>
                    </div>
                </form>

                {{-- Tech Decors --}}
                <div class="absolute top-0 left-0 w-3 h-3 border-l border-t border-accent"></div>
                <div class="absolute bottom-0 right-0 w-3 h-3 border-r border-b border-accent"></div>
            </div>
        </div>
    @endif

    {{-- Delete Modal --}}
    @if ($isDeleteModalOpen)
        <div class="fixed inset-0 z-50 flex items-center justify-center">
            <div class="absolute inset-0 bg-black/90 backdrop-blur-sm" wire:click="closeModal"></div>
            <div class="relative w-full max-w-sm p-6 bg-[#0a0a0a] border border-red-500/30 shadow-[0_0_30px_rgba(255,0,0,0.1)] z-10 text-center">
                <svg class="mx-auto w-12 h-12 text-red-500 mb-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1"><path d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                <h3 class="text-lg text-white font-light mb-2">Confirm Deletion</h3>
                <p class="text-xs text-[#888] font-mono mb-6">Action irreversible. Confirm removal from taxonomy?</p>
                <div class="flex gap-3">
                    <button wire:click="closeModal" class="flex-1 bg-white/5 border border-white/10 text-white py-3 text-[10px] uppercase tracking-widest hover:bg-white/10">Cancel</button>
                    <button wire:click="delete" class="flex-1 bg-red-600/20 border border-red-500/50 text-red-500 py-3 text-[10px] uppercase tracking-widest hover:bg-red-600 hover:text-white transition-all">Confirm</button>
                </div>
            </div>
        </div>
    @endif
</main>

@script
    <script>
        Livewire.on('show-toast', (event) => {
            if (window.showToast) {
                window.showToast(event[0].type, event[0].title, event[0].message);
            } else {
                console.log(event[0].message);
            }
        });
    </script>
@endscript