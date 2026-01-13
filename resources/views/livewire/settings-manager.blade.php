<main class="max-w-7xl mx-auto mt-32 px-6 pb-20 relative">

    {{-- Page Header --}}
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-12 border-b border-white/10 pb-6">
        <div>
            <h1 class="text-2xl text-white font-light mb-2">Configuration</h1>
            <p class="text-xs text-[#666] uppercase tracking-widest">System Environment Variables</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">

        {{-- LEFT COLUMN: Modules Sidebar --}}
        <div class="lg:col-span-1 space-y-6">
            
            {{-- Module List --}}
            <div class="bg-[#0a0a0a] border border-white/10 p-2 rounded-sm sticky top-32">
                <div class="px-4 py-3 border-b border-white/5 mb-2 flex justify-between items-center">
                    <span class="text-[10px] text-[#666] uppercase tracking-widest">Modules</span>
                    <button wire:click="openAddGroupModal" class="text-accent hover:text-white transition-colors" title="New Module">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 5v14M5 12h14"/></svg>
                    </button>
                </div>

                <div class="space-y-1">
                    @foreach($groups as $group)
                        <button wire:click="switchTab('{{ $group }}')"
                            class="w-full text-left px-4 py-3 text-xs uppercase tracking-wider font-mono border-l-2 transition-all duration-300 flex items-center justify-between group rounded-r-sm
                            {{ $activeGroup === $group ? 'border-accent bg-accent/5 text-white' : 'border-transparent text-[#888] hover:bg-white/5 hover:text-white' }}">
                            {{ str_replace('_', ' ', $group) }}
                            
                            @if($activeGroup === $group)
                                <span class="w-1.5 h-1.5 rounded-full bg-accent animate-pulse"></span>
                            @endif
                        </button>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- RIGHT COLUMN: Active Module Settings --}}
        <div class="lg:col-span-3">
            
            {{-- Module Header & Controls --}}
            <div class="bg-white/[0.02] border border-white/5 p-6 rounded-sm mb-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <div class="flex items-center gap-3">
                        <h2 class="text-2xl text-white font-light uppercase tracking-wide">{{ str_replace('_', ' ', $activeGroup) }}</h2>
                        <button wire:click="openEditGroupModal" class="text-[#444] hover:text-white transition-colors" title="Rename Module">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                        </button>
                    </div>
                    <code class="text-[10px] text-[#666] font-mono mt-1 block">settings('{{ $activeGroup }}.key')</code>
                </div>

                <div class="flex items-center gap-3">
                    <button wire:click="openDeleteGroupModal" class="px-4 py-2 border border-red-500/20 text-red-500/60 hover:text-red-500 hover:bg-red-500/10 text-[10px] uppercase tracking-widest transition-all">
                        Delete Module
                    </button>
                    <button wire:click="openAddKeyModal" class="px-4 py-2 bg-accent/10 border border-accent/20 text-accent hover:bg-accent hover:text-black text-[10px] uppercase tracking-widest transition-all font-bold flex items-center gap-2">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path d="M12 5v14M5 12h14"/></svg>
                        Add Variable
                    </button>
                </div>
            </div>

            {{-- Grid Headers --}}
            <div class="hidden md:grid grid-cols-12 gap-4 text-[10px] uppercase tracking-widest text-[#666] px-6 pb-2 font-display">
                <div class="col-span-4">Variable Key</div>
                <div class="col-span-7">Value Configuration</div>
                <div class="col-span-1 text-right">Action</div>
            </div>

            {{-- Settings List --}}
            <div class="space-y-2">
                @forelse($settings as $setting)
                    <div class="group relative bg-black/20 border border-white/5 hover:border-white/20 transition-all duration-300 p-4 rounded-sm">
                        <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center">
                            
                            {{-- Key Name --}}
                            <div class="col-span-4">
                                <label class="block text-xs text-white uppercase tracking-wider font-bold mb-1">
                                    {{ $setting->key }}
                                </label>
                                <span class="text-[10px] text-[#555] font-mono select-all">
                                    {{ $activeGroup }}.{{ $setting->key }}
                                </span>
                            </div>

                            {{-- Value Input --}}
                            <div class="col-span-7">
                                <div class="relative group/input">
                                    @if(strlen($setting->value) > 60)
                                        <textarea 
                                            wire:change="updateSetting({{ $setting->id }}, $event.target.value)"
                                            class="w-full bg-[#050505] border border-white/10 px-3 py-2 text-sm text-[#ddd] focus:text-white focus:outline-none focus:border-accent transition-all placeholder-[#333] font-mono resize-y rounded-sm"
                                            rows="2">{{ $setting->value }}</textarea>
                                    @else
                                        <input type="text" 
                                            value="{{ $setting->value }}"
                                            wire:change="updateSetting({{ $setting->id }}, $event.target.value)"
                                            class="w-full bg-[#050505] border border-white/10 px-3 py-2 text-sm text-[#ddd] focus:text-white focus:outline-none focus:border-accent transition-all placeholder-[#333] font-mono rounded-sm">
                                    @endif
                                    
                                    {{-- Save Indicator --}}
                                    <div class="absolute right-2 top-2 w-1.5 h-1.5 bg-accent rounded-full opacity-0 transition-opacity" 
                                         wire:loading.class="opacity-100" 
                                         wire:target="updateSetting({{ $setting->id }}, $event.target.value)">
                                    </div>
                                </div>
                            </div>

                            {{-- Delete --}}
                            <div class="col-span-1 text-right">
                                @if(!$setting->is_locked)
                                    <button wire:click="confirmDelete({{ $setting->id }})" class="text-[#333] hover:text-red-500 transition-colors">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/></svg>
                                    </button>
                                @else
                                    <div class="flex justify-end text-[#333] cursor-not-allowed" title="System Protected">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                                    </div>
                                @endif
                            </div>

                        </div>
                        
                        {{-- Hover Corner Accents --}}
                        <div class="absolute top-0 left-0 w-1.5 h-1.5 border-l border-t border-white/10 group-hover:border-accent transition-colors"></div>
                        <div class="absolute bottom-0 right-0 w-1.5 h-1.5 border-r border-b border-white/10 group-hover:border-accent transition-colors"></div>
                    </div>
                @empty
                    <div class="py-16 text-center border border-dashed border-white/10 rounded-sm">
                        <p class="text-[#666] mb-4 font-display text-xs uppercase tracking-widest">No variables defined in this module.</p>
                        <button wire:click="openAddKeyModal" class="text-accent hover:underline text-[10px] uppercase tracking-widest font-display">Initialize First Parameter</button>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    {{-- ================= MODALS ================= --}}

    {{-- 1. ADD MODULE MODAL --}}
    @if($isAddGroupModalOpen)
        <div class="fixed inset-0 z-50 flex items-center justify-center">
            <div class="absolute inset-0 bg-black/90 backdrop-blur-sm" wire:click="closeAddGroupModal"></div>
            <div class="relative w-full max-w-sm p-8 bg-[#0a0a0a] border border-white/10 shadow-2xl z-10">
                <div class="flex justify-between items-start mb-6">
                    <h2 class="text-lg text-white font-light">New Module</h2>
                    <button wire:click="closeAddGroupModal" class="text-[#666] hover:text-white"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6L6 18M6 6l12 12"/></svg></button>
                </div>
                <div class="space-y-6">
                    <div>
                        <label class="block text-[10px] text-[#888] uppercase tracking-widest mb-2 font-mono">Module Identifier</label>
                        <input wire:model="newGroupName" type="text" class="w-full bg-white/5 border border-white/10 px-4 py-3 text-white focus:outline-none focus:border-accent transition-colors placeholder-white/20 font-mono text-sm" placeholder="e.g. aws_s3">
                        @error('newGroupName') <span class="text-red-500 text-[10px] uppercase mt-1 block">{{ $message }}</span> @enderror
                    </div>
                    <button wire:click="createGroup" class="w-full bg-white text-black hover:bg-accent px-6 py-3 uppercase tracking-widest text-xs transition-all duration-300 font-bold">Initialize Module</button>
                </div>
            </div>
        </div>
    @endif

    {{-- 2. EDIT MODULE MODAL --}}
    @if($isEditGroupModalOpen)
        <div class="fixed inset-0 z-50 flex items-center justify-center">
            <div class="absolute inset-0 bg-black/90 backdrop-blur-sm" wire:click="closeEditGroupModal"></div>
            <div class="relative w-full max-w-sm p-8 bg-[#0a0a0a] border border-white/10 shadow-2xl z-10">
                <div class="flex justify-between items-start mb-6">
                    <h2 class="text-lg text-white font-light">Rename Module</h2>
                    <button wire:click="closeEditGroupModal" class="text-[#666] hover:text-white"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6L6 18M6 6l12 12"/></svg></button>
                </div>
                <div class="space-y-6">
                    <div>
                        <label class="block text-[10px] text-[#888] uppercase tracking-widest mb-2 font-mono">New Identifier</label>
                        <input wire:model="editingGroupName" type="text" class="w-full bg-white/5 border border-white/10 px-4 py-3 text-white focus:outline-none focus:border-accent transition-colors placeholder-white/20 font-mono text-sm">
                        @error('editingGroupName') <span class="text-red-500 text-[10px] uppercase mt-1 block">{{ $message }}</span> @enderror
                    </div>
                    <div class="bg-yellow-500/10 border border-yellow-500/20 p-3">
                        <p class="text-[10px] text-yellow-500/80 font-mono">Warning: This will update code references for all variables in this group.</p>
                    </div>
                    <button wire:click="updateGroup" class="w-full bg-white text-black hover:bg-accent px-6 py-3 uppercase tracking-widest text-xs transition-all duration-300 font-bold">Update Identifier</button>
                </div>
            </div>
        </div>
    @endif

    {{-- 3. ADD VARIABLE MODAL --}}
    @if($isAddKeyModalOpen)
        <div class="fixed inset-0 z-50 flex items-center justify-center">
            <div class="absolute inset-0 bg-black/90 backdrop-blur-sm" wire:click="closeAddKeyModal"></div>
            <div class="relative w-full max-w-md p-8 bg-[#0a0a0a] border border-white/10 shadow-2xl z-10">
                <div class="flex justify-between items-start mb-6">
                    <h2 class="text-lg text-white font-light">Inject Variable</h2>
                    <button wire:click="closeAddKeyModal" class="text-[#666] hover:text-white"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6L6 18M6 6l12 12"/></svg></button>
                </div>
                <div class="space-y-6">
                    <div>
                        <label class="block text-[10px] text-[#888] uppercase tracking-widest mb-2 font-mono">Key Name</label>
                        <input wire:model="newKey" type="text" class="w-full bg-white/5 border border-white/10 px-4 py-3 text-white focus:outline-none focus:border-accent transition-colors placeholder-white/20 font-mono text-sm" placeholder="e.g. bucket_name">
                        @error('newKey') <span class="text-red-500 text-[10px] uppercase mt-1 block">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-[10px] text-[#888] uppercase tracking-widest mb-2 font-mono">Initial Value</label>
                        <textarea wire:model="newValue" class="w-full bg-white/5 border border-white/10 px-4 py-3 text-white focus:outline-none focus:border-accent transition-colors placeholder-white/20 font-mono text-sm" rows="3" placeholder="Enter value..."></textarea>
                    </div>
                    <button wire:click="addSetting" class="w-full bg-white text-black hover:bg-accent px-6 py-3 uppercase tracking-widest text-xs transition-all duration-300 font-bold">Inject Parameter</button>
                </div>
            </div>
        </div>
    @endif

    {{-- 4. DELETE KEY CONFIRM --}}
    @if ($isDeleteModalOpen)
        <div class="fixed inset-0 z-50 flex items-center justify-center">
            <div class="absolute inset-0 bg-black/90 backdrop-blur-sm" wire:click="closeDeleteModal"></div>
            <div class="relative w-full max-w-sm p-6 bg-[#0a0a0a] border border-red-500/30 shadow-[0_0_30px_rgba(255,0,0,0.1)] z-10 text-center">
                <svg class="mx-auto w-12 h-12 text-red-500 mb-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1"><path d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                <h3 class="text-lg text-white font-light mb-2">Confirm Purge</h3>
                <p class="text-xs text-[#888] font-mono mb-6">Permanently remove this variable?</p>
                <div class="flex gap-3">
                    <button wire:click="closeDeleteModal" class="flex-1 bg-white/5 border border-white/10 text-white py-3 text-[10px] uppercase tracking-widest hover:bg-white/10">Cancel</button>
                    <button wire:click="deleteSetting" class="flex-1 bg-red-600/20 border border-red-500/50 text-red-500 py-3 text-[10px] uppercase tracking-widest hover:bg-red-600 hover:text-white transition-all">Confirm</button>
                </div>
            </div>
        </div>
    @endif

    {{-- 5. DELETE GROUP CONFIRM --}}
    @if ($isDeleteGroupModalOpen)
        <div class="fixed inset-0 z-50 flex items-center justify-center">
            <div class="absolute inset-0 bg-black/90 backdrop-blur-sm" wire:click="closeDeleteGroupModal"></div>
            <div class="relative w-full max-w-sm p-6 bg-[#0a0a0a] border border-red-500/30 shadow-[0_0_30px_rgba(255,0,0,0.1)] z-10 text-center">
                <svg class="mx-auto w-12 h-12 text-red-500 mb-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1"><path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/></svg>
                <h3 class="text-lg text-white font-light mb-2">Nuclear Option</h3>
                <p class="text-xs text-[#888] font-mono mb-6">Delete Module "{{ $activeGroup }}" and ALL contained variables? This cannot be undone.</p>
                <div class="flex gap-3">
                    <button wire:click="closeDeleteGroupModal" class="flex-1 bg-white/5 border border-white/10 text-white py-3 text-[10px] uppercase tracking-widest hover:bg-white/10">Cancel</button>
                    <button wire:click="deleteGroup" class="flex-1 bg-red-600/20 border border-red-500/50 text-red-500 py-3 text-[10px] uppercase tracking-widest hover:bg-red-600 hover:text-white transition-all">Confirm</button>
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
            }
        });
    </script>
@endscript