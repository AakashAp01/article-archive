@section('title', 'Newsletter')
<main class="max-w-7xl mx-auto mt-32 px-6 pb-20 relative ">

    <x-page-header 
        title="Subscribers" 
        subtitle="Manage your newsletter audience and growth" 
    />

    <div class="flex flex-col md:flex-row items-center justify-between gap-6 mb-12">
        
        <div class="relative w-full md:w-64 group">
            <input wire:model.live.debounce.300ms="search" type="text"
                class="w-full bg-black/20 border border-white/10 px-10 py-3 text-xs text-white focus:outline-none focus:border-accent transition-all placeholder-white/20 font-display uppercase tracking-wider"
                placeholder="Lookup Identity...">
            <div class="absolute left-3 top-1/2 -translate-y-1/2 text-white/30 group-focus-within:text-accent transition-colors">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
            </div>
        </div>

        <x-button wire:click="openModal" variant="accent-outline" class="w-full md:w-auto">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="mr-3"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
            Add Subscriber
        </x-button>
    </div>

    <div class="space-y-4" role="table" aria-label="Newsletter Subscriptions">

        <div class="hidden md:grid grid-cols-12 gap-4 text-[10px] uppercase tracking-widest text-[#666] px-6 pb-2 font-display">
            <div class="col-span-1">Ref</div>
            <div class="col-span-4">Subscriber Email</div>
            <div class="col-span-2 text-center">Status</div>
            <div class="col-span-2">Joined On</div>
            <div class="col-span-2 text-right">Actions</div>
        </div>

        @forelse($subscribers as $sub)
            <div class="group relative bg-white/[0.02] border border-white/5 hover:border-accent/50 transition-all duration-300 p-6 md:p-4 rounded-sm" role="row">
                <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center">

                    <div class="col-span-1 text-[#666] font-display text-xs" role="cell">
                        <span class="md:hidden mr-2 uppercase tracking-widest text-[10px]">ID:</span>
                        #{{ str_pad($sub->id, 4, '0', STR_PAD_LEFT) }}
                    </div>

                    <div class="col-span-1 md:col-span-4" role="cell">
                        <div class="text-sm text-white group-hover:text-accent transition-colors font-light">
                            {{ $sub->email }}
                        </div>
                    </div>

                    <div class="col-span-1 md:col-span-2 flex md:justify-center" role="cell">
                        <button wire:click="toggleStatus({{ $sub->id }})" 
                            class="relative inline-flex h-5 w-10 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none {{ $sub->is_active ? 'bg-accent/20' : 'bg-white/10' }}">
                            
                            <span aria-hidden="true" 
                                class="pointer-events-none inline-block h-4 w-4 transform rounded-full shadow ring-0 transition duration-200 ease-in-out {{ $sub->is_active ? 'translate-x-5 bg-accent' : 'translate-x-0 bg-[#666]' }}">
                            </span>
                        </button>
                        <span class="ml-3 text-[10px] uppercase tracking-widest font-display {{ $sub->is_active ? 'text-accent' : 'text-[#666]' }}">
                            {{ $sub->is_active ? 'Active' : 'Unsubscribed' }}
                        </span>
                    </div>

                    <div class="col-span-1 md:col-span-2 text-xs text-[#666] uppercase font-display" role="cell">
                        <span class="md:hidden mr-2 uppercase tracking-widest text-[10px]">Joined:</span>
                        {{ $sub->created_at->format('d M Y') }}
                    </div>

                    <div class="col-span-1 md:col-span-2 flex items-center justify-start md:justify-end gap-2 mt-4 md:mt-0 pt-4 md:pt-0 border-t md:border-t-0 border-white/5" role="cell">
                        <x-button wire:click="edit({{ $sub->id }})" variant="outline" class="!w-8 !h-8 !p-0">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2">
                                    <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z" />
                                </svg>
                        </x-button>
                        
                        <x-button wire:click="confirmDelete({{ $sub->id }})" variant="danger" class="!w-8 !h-8 !p-0 !bg-red-500/5 !text-red-400 hover:!bg-red-500 hover:!text-white">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2">
                                <path d="M3 6h18" />
                                <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6" />
                                <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2" />
                            </svg>
                        </x-button>
                    </div>
                </div>

                <div class="absolute top-0 left-0 w-2 h-2 border-l border-t border-white/20 group-hover:border-accent"></div>
                <div class="absolute bottom-0 right-0 w-2 h-2 border-r border-b border-white/20 group-hover:border-accent"></div>
            </div>
        @empty
            <div class="py-20 text-center border border-dashed border-white/10 rounded-sm">
                <p class="text-[#666] mb-4 font-display text-xs uppercase tracking-widest">No subscribers found yet.</p>
                <x-button wire:click="openModal" variant="accent-outline" class="!bg-transparent !text-[10px]">Add Your First Subscriber</x-button>
            </div>
        @endforelse

        <div class="pt-6">
            {{ $subscribers->links() }} 
        </div>
    </div>

    @if ($isModalOpen)
        <x-modal id="newsletterModal" 
            :title="$newsletterId ? 'Edit Subscriber' : 'New Subscriber'" 
            subtitle="Enter subscriber details"
            wire:click="closeModal">
            
            <form wire:submit="store">
                <div class="space-y-6">
                    
                    <div>
                        <label class="block text-[10px] text-[#888] uppercase tracking-widest mb-2 font-mono">Subscriber Identity (Email)</label>
                        <input wire:model="email" type="email"
                            class="w-full bg-white/5 border border-white/10 px-4 py-3 text-white focus:outline-none focus:border-accent transition-colors placeholder-white/20 font-mono text-sm uppercase"
                            placeholder="OPERATOR@CORE.SYS">
                        @error('email') <span class="text-red-500 text-[10px] uppercase mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex items-center gap-3 border border-white/10 p-3 bg-white/5">
                        <input wire:model="status" type="checkbox" id="modalStatus" class="w-4 h-4 rounded border-gray-300 text-accent focus:ring-accent bg-transparent">
                        <label for="modalStatus" class="text-xs text-white font-mono uppercase tracking-wide">Protocol Active</label>
                    </div>

                    <div class="pt-4 border-t border-white/5">
                        <x-button type="submit" class="w-full">
                            <span wire:loading.remove wire:target="store">Confirm Injection</span>
                            <span wire:loading wire:target="store">Processing...</span>
                        </x-button>
                    </div>
                </div>
            </form>
        </x-modal>
    @endif

    @if ($isDeleteModalOpen)
        <x-modal id="deleteNewsletterModal" 
            title="Confirm Purge" 
            subtitle="Permanently disconnect identity from matrix"
            variant="danger"
            wire:click="closeDeleteModal"
            class="text-center">
            
            <svg class="mx-auto w-12 h-12 text-red-500 mb-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1"><path d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
            
            <div class="flex gap-3">
                <x-button wire:click="closeDeleteModal" variant="outline" class="flex-1">Cancel</x-button>
                <x-button wire:click="delete" variant="danger" class="flex-1">Confirm</x-button>
            </div>
        </x-modal>
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