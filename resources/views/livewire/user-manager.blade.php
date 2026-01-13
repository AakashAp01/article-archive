<main class="max-w-7xl mx-auto mt-32 px-6 pb-20 relative ">

    {{-- Header Section --}}
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-12 border-b border-white/10 pb-6">
        <div>
            <h1 class="text-2xl text-white font-semibold mb-2">Users</h1>
            <p class="text-xs text-[#666] uppercase tracking-widest">System Access Control</p>
        </div>

        <div class="flex flex-col md:flex-row items-center gap-4 w-full md:w-auto">
            <div class="relative w-full md:w-64 group">
                <input wire:model.live.debounce.300ms="search" type="text"
                    class="w-full bg-black/20 border border-white/10 px-10 py-3 text-xs text-white focus:outline-none focus:border-accent transition-all placeholder-white/20 font-display uppercase tracking-wider"
                    placeholder="SEARCH PERSONNEL...">
                <div
                    class="absolute left-3 top-1/2 -translate-y-1/2 text-white/30 group-focus-within:text-accent transition-colors">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <circle cx="11" cy="11" r="8"></circle>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                    </svg>
                </div>
            </div>

            <button wire:click="openModal"
                class="w-full md:w-auto group flex items-center justify-center gap-3 bg-white/5 border border-white/20 hover:border-accent px-6 py-3 transition-all hover:bg-accent/10">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" class="text-white group-hover:text-accent transition-colors">
                    <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                    <circle cx="8.5" cy="7" r="4"></circle>
                    <line x1="20" y1="8" x2="20" y2="14"></line>
                    <line x1="23" y1="11" x2="17" y2="11"></line>
                </svg>
                <span class="text-xs text-white uppercase tracking-widest group-hover:text-accent font-display">Uplink
                    New User</span>
            </button>
        </div>
    </div>


    {{-- Data Table --}}
    <div class="space-y-4">

        {{-- Headers --}}
        <div
            class="hidden md:grid grid-cols-12 gap-4 text-[10px] uppercase tracking-widest text-[#666] px-6 pb-2 font-display">
            <div class="col-span-1">ID</div>
            <div class="col-span-1">Name</div>
            <div class="col-span-2">Email</div>
            <div class="col-span-2 text-center">Type</div>
            <div class="col-span-2 text-center">Verification</div>
            <div class="col-span-2 text-center">Status</div>
            <div class="col-span-2 text-right">Controls</div>
        </div>


        {{-- Rows --}}
        @forelse($users as $user)
            <div
                class="group relative bg-white/[0.02] border hover:border-accent/50 transition-all duration-300 p-6 md:p-4 rounded-sm
            {{-- Conditional Styling for Deleted Users --}}
            {{ $user->trashed() ? 'border-red-500/20 opacity-60 grayscale-[0.5]' : 'border-white/5' }}">

                <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center">

                    {{-- ID --}}
                    <div class="col-span-1 text-[#666] font-display text-xs">
                        <span class="md:hidden mr-2 uppercase tracking-widest text-[10px]">ID:</span>
                        #{{ str_pad($user->id, 3, '0', STR_PAD_LEFT) }}
                    </div>

                    {{-- Identity --}}
                    <div class="col-span-1 md:col-span-1">
                        <div class="flex items-center gap-3">
                            <div class="text-sm font-medium text-white group-hover:text-accent transition-colors">
                                {{ $user->name }}
                            </div>
                        </div>
                    </div>

                    {{-- Email --}}
                    <div class="col-span-1 md:col-span-2 flex items-center md:justify-start">
                        <div class="text-[11px] font-mono text-[#888] break-all">
                            {{ $user->email }}
                        </div>
                    </div>

                    {{-- Role --}}
                    <div class="col-span-1 md:col-span-2 flex md:justify-center">
                        @if (!$user->trashed())
                            <button wire:click="toggleType({{ $user->id }})"
                                class="px-3 py-1 text-[10px] uppercase tracking-widest border transition-all duration-300
                            {{ $user->type === 'admin'
                                ? 'border-purple-500/50 text-purple-400 bg-purple-500/10 hover:bg-purple-500/20'
                                : 'border-blue-500/30 text-blue-400 bg-blue-500/5 hover:bg-blue-500/10' }}">
                                {{ $user->type }}
                            </button>
                        @else
                            <span
                                class="text-[10px] uppercase text-[#444] border border-[#333] px-2 py-1 cursor-not-allowed">
                                {{ $user->type }}
                            </span>
                        @endif
                    </div>

                    {{-- Verification --}}
                    <div class="col-span-1 md:col-span-2 flex md:justify-center">
                        @if (!$user->trashed())
                            <button wire:click="toggleVerification({{ $user->id }})"
                                class="flex items-center gap-2 group/verify transition-all">
                                <div
                                    class="w-6 h-6 rounded-full border flex items-center justify-center transition-all
                                {{ $user->email_verified_at
                                    ? 'border-accent text-accent bg-accent/10'
                                    : 'border-white/20 text-[#666] bg-transparent group-hover/verify:border-accent group-hover/verify:text-accent' }}">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="3">
                                        <polyline points="20 6 9 17 4 12"></polyline>
                                    </svg>
                                </div>
                                <span
                                    class="text-[10px] font-mono uppercase tracking-widest {{ $user->email_verified_at ? 'text-accent' : 'text-[#666] group-hover/verify:text-white' }}">
                                    {{ $user->email_verified_at ? 'Verified' : 'Pending' }}
                                </span>
                            </button>
                        @else
                            <span class="text-[10px] font-mono text-[#444]">--</span>
                        @endif
                    </div>

                    {{-- Status (Active / Blocked / Deleted) --}}
                    <div class="col-span-1 md:col-span-2 flex md:justify-center">
                        @if ($user->trashed())
                            {{-- DELETED STATE (Red Dot) --}}
                            <div class="flex items-center gap-2">
                                <span class="relative flex h-2 w-2">
                                    <span
                                        class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                                    <span class="relative inline-flex rounded-full h-2 w-2 bg-red-500"></span>
                                </span>
                                <span
                                    class="text-[10px] uppercase tracking-widest text-red-500 font-bold">Terminated</span>
                            </div>
                        @else
                            {{-- ACTIVE/BLOCKED TOGGLE --}}
                            <button wire:click="toggleStatus({{ $user->id }})" class="flex items-center gap-3">
                                <div
                                    class="relative inline-flex h-5 w-10 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none 
                                {{ $user->status == 1 ? 'bg-green-500/20' : 'bg-white/10' }}">
                                    <span aria-hidden="true"
                                        class="pointer-events-none inline-block h-4 w-4 transform rounded-full shadow ring-0 transition duration-200 ease-in-out 
                                    {{ $user->status == 1 ? 'translate-x-5 bg-green-500' : 'translate-x-0 bg-[#666]' }}">
                                    </span>
                                </div>
                                <span
                                    class="text-[10px] uppercase tracking-widest font-display {{ $user->status == 1 ? 'text-green-500' : 'text-[#666]' }}">
                                    {{ $user->status == 1 ? 'Active' : 'Blocked' }}
                                </span>
                            </button>
                        @endif
                    </div>

                    {{-- Actions --}}
                    <div
                        class="col-span-1 md:col-span-2 flex items-center justify-start md:justify-end gap-2 mt-4 md:mt-0 pt-4 md:pt-0 border-t md:border-t-0 border-white/5">

                        @if ($user->trashed())
                            {{-- 1. RESTORE BUTTON (Only visible if Deleted) --}}
                            <button wire:click="restore({{ $user->id }})" title="Restore Account"
                                class="w-8 h-8 flex items-center justify-center border border-green-500/30 bg-green-500/10 text-green-400 hover:bg-green-500 hover:text-white transition-all">
                                {{-- Undo / Refresh Icon --}}
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2">
                                    <path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"></path>
                                    <path d="M3 3v5h5"></path>
                                </svg>
                            </button>
                        @else
                            {{-- 2. LOGIN AS USER (Only visible if Active) --}}
                            @if ($user->id !== auth()->id())
                                <button wire:click="loginAsUser({{ $user->id }})" title="Simulate User Session"
                                    class="w-8 h-8 flex items-center justify-center border border-accent/20 bg-accent/5 text-accent hover:bg-accent hover:text-black transition-all">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2">
                                        <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"></path>
                                        <polyline points="10 17 15 12 10 7"></polyline>
                                        <line x1="15" y1="12" x2="3" y2="12"></line>
                                    </svg>
                                </button>
                            @endif

                            {{-- 3. EDIT (Only visible if Active) --}}
                            <button wire:click="edit({{ $user->id }})"
                                class="w-8 h-8 flex items-center justify-center border border-white/10 bg-black/20 text-[#888] hover:border-white hover:text-white hover:bg-white/5 transition-all">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2">
                                    <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z" />
                                </svg>
                            </button>
                        @endif

                        {{-- 4. DELETE (Permanent Purge if already deleted, Soft Delete otherwise) --}}
                        <button wire:click="confirmDelete({{ $user->id }})"
                            title="{{ $user->trashed() ? 'Permanently Delete' : 'Archive User' }}"
                            class="w-8 h-8 flex items-center justify-center border transition-all
                            {{ $user->trashed()
                                ? 'border-red-600 bg-red-600/20 text-red-500 hover:bg-red-600 hover:text-white'
                                : 'border-red-500/20 bg-red-500/5 text-red-400 hover:border-red-500 hover:bg-red-500 hover:text-white' }}">

                            @if ($user->trashed())
                                {{-- Double Cross (Permanent) --}}
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2">
                                    <path d="M18 6L6 18M6 6l12 12"></path>
                                </svg>
                            @else
                                {{-- Standard Trash --}}
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2">
                                    <path d="M3 6h18" />
                                    <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6" />
                                    <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2" />
                                </svg>
                            @endif
                        </button>
                    </div>
                </div>

                {{-- Decor --}}
                <div class="absolute top-0 left-0 w-2 h-2 border-l border-t border-white/20 group-hover:border-accent">
                </div>
                <div
                    class="absolute bottom-0 right-0 w-2 h-2 border-r border-b border-white/20 group-hover:border-accent">
                </div>
            </div>
        @empty
            <div class="py-20 text-center border border-dashed border-white/10 rounded-sm">
                <p class="text-[#666] mb-4 font-display">No personnel found matching query parameters.</p>
                <button wire:click="openModal"
                    class="text-accent hover:underline text-sm uppercase font-display">Uplink First User</button>
            </div>
        @endforelse

        <div class="pt-6">
            {{ $users->links() }}
        </div>
    </div>

    {{-- Create/Edit Modal --}}
    @if ($isModalOpen)
        <div class="fixed inset-0 z-50 flex items-center justify-center">
            <div class="absolute inset-0 bg-black/80 backdrop-blur-sm" wire:click="closeModal"></div>
            <div class="relative w-full max-w-lg p-8 bg-[#0a0a0a] border border-white/10 shadow-2xl z-10">

                <div class="flex justify-between items-start mb-6">
                    <div>
                        <h2 class="text-xl text-white font-light">{{ $userId ? 'Modify Profile' : 'New Uplink' }}</h2>
                        <p class="text-[10px] text-[#666] uppercase tracking-widest font-mono mt-1">Personnel Data
                            Entry</p>
                    </div>
                    <button wire:click="closeModal" class="text-[#666] hover:text-white transition-colors">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path d="M18 6L6 18M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <form wire:submit="store">
                    <div class="space-y-6">
                        <div class="grid grid-cols-2 gap-4">
                            <div class="col-span-2 md:col-span-1">
                                <label
                                    class="block text-[10px] text-[#888] uppercase tracking-widest mb-2 font-mono">Full
                                    Name</label>
                                <input wire:model="name" type="text"
                                    class="w-full bg-white/5 border border-white/10 px-4 py-3 text-white focus:outline-none focus:border-accent transition-colors font-mono text-sm">
                                @error('name')
                                    <span class="text-red-500 text-[10px] uppercase mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-span-2 md:col-span-1">
                                <label
                                    class="block text-[10px] text-[#888] uppercase tracking-widest mb-2 font-mono">Role
                                    Protocol</label>
                                <select wire:model="type"
                                    class="w-full bg-black border border-white/10 px-4 py-3 text-white focus:outline-none focus:border-accent transition-colors font-mono text-sm uppercase">
                                    <option value="user">User (Standard)</option>
                                    <option value="admin">Admin (Root)</option>
                                </select>
                            </div>
                        </div>

                        <div>
                            <label class="block text-[10px] text-[#888] uppercase tracking-widest mb-2 font-mono">Email
                                Address</label>
                            <input wire:model="email" type="email"
                                class="w-full bg-white/5 border border-white/10 px-4 py-3 text-white focus:outline-none focus:border-accent transition-colors font-mono text-sm">
                            @error('email')
                                <span class="text-red-500 text-[10px] uppercase mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-[10px] text-[#888] uppercase tracking-widest mb-2 font-mono">
                                Password {{ $userId ? '(Leave empty to keep current)' : '(Required)' }}
                            </label>
                            <input wire:model="password" type="password"
                                class="w-full bg-white/5 border border-white/10 px-4 py-3 text-white focus:outline-none focus:border-accent transition-colors font-mono text-sm">
                            @error('password')
                                <span class="text-red-500 text-[10px] uppercase mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Status Checkbox --}}
                        <div class="flex items-center gap-3 border border-white/10 p-3 bg-white/5">
                            <input wire:model="status" type="checkbox" id="modalActive" value="1"
                                class="w-4 h-4 rounded border-gray-300 text-accent focus:ring-accent bg-transparent">
                            <label for="modalActive"
                                class="text-xs text-white font-mono uppercase tracking-wide">Account Access
                                Active</label>
                        </div>

                        <div class="pt-4 border-t border-white/5">
                            <button type="submit"
                                class="w-full bg-white text-black hover:bg-accent px-6 py-3 uppercase tracking-widest text-xs transition-all duration-300 relative">
                                <span wire:loading.remove
                                    wire:target="store">{{ $userId ? 'Update Profile' : 'Initialize User' }}</span>
                                <span wire:loading wire:target="store">Processing...</span>
                            </button>
                        </div>
                    </div>
                </form>

                <div class="absolute top-0 left-0 w-3 h-3 border-l border-t border-accent"></div>
                <div class="absolute bottom-0 right-0 w-3 h-3 border-r border-b border-accent"></div>
            </div>
        </div>
    @endif

    {{-- Delete Modal --}}
    @if ($isDeleteModalOpen)
        <div class="fixed inset-0 z-50 flex items-center justify-center">
            <div class="absolute inset-0 bg-black/90 backdrop-blur-sm" wire:click="closeModal"></div>
            <div
                class="relative w-full max-w-sm p-6 bg-[#0a0a0a] border border-red-500/30 shadow-[0_0_30px_rgba(255,0,0,0.1)] z-10 text-center">
                <svg class="mx-auto w-12 h-12 text-red-500 mb-4" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="1">
                    <path
                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                <h3 class="text-lg text-white font-light mb-2">Confirm Termination</h3>
                <p class="text-xs text-[#888] font-mono mb-6">Permanently purge this user profile?</p>
                <div class="flex gap-3">
                    <button wire:click="closeModal"
                        class="flex-1 bg-white/5 border border-white/10 text-white py-3 text-[10px]  uppercase tracking-widest hover:bg-white/10">Cancel</button>
                    <button wire:click="delete"
                        class="flex-1 bg-red-600/20 border border-red-500/50 text-red-500 py-3 text-[10px]  uppercase tracking-widest hover:bg-red-600 hover:text-white transition-all">Confirm</button>
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
