<main class="max-w-7xl mx-auto mt-32 px-6 pb-20 relative ">

    {{-- Header --}}
    <div class="mb-12 border-b border-white/10 pb-6 flex justify-between items-end">
        <div>
            <h1 class="text-2xl text-white font-semibold mb-2">Profile</h1>
            <p class="text-sm text-[#666] uppercase tracking-widest">User Profile Configuration</p>
        </div>
        <div class="hidden md:block text-[10px] font-mono text-[#444]">
            ID: {{ Auth::id() }} // CLASS: {{ Auth::user()->type === 'admin' ? 'ADMIN' : 'USER' }}
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">

        {{-- LEFT COLUMN: Identity Card --}}
        <div class="lg:col-span-1">
            <div class="sticky top-32 space-y-6">

                <div class="bg-white/[0.02] border border-white/10 relative overflow-hidden shadow-2xl group">

                    {{-- Corners --}}
                    <div class="absolute top-0 left-0 w-3 h-3 border-l border-t border-accent"></div>
                    <div class="absolute bottom-0 right-0 w-3 h-3 border-r border-b border-accent"></div>

                    {{-- PADDING CONTAINER --}}
                    <div class="p-8">

                        {{-- 1. AVATAR SECTION --}}
                        <div class="flex justify-center mb-6 relative">
                            <div class="relative w-32 h-32">

                        
                                {{-- Actual Image / Initials --}}
                                <div
                                    class="w-full h-full rounded-full overflow-hidden border-2 border-white/10 relative z-10 bg-black">
                                    @if ($current_avatar_url)
                                        <img src="{{ $current_avatar_url }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center bg-[#111]">
                                            <span class="text-3xl font-mono text-[#666]">
                                                {{ substr(Auth::user()->name, 0, 2) }}
                                            </span>
                                        </div>
                                    @endif
                                </div>

                                {{-- EDIT BUTTON --}}
                                <label for="avatar_upload"
                                    class="absolute bottom-0 right-0 z-30 w-8 h-8 bg-black border border-white/20 rounded-full flex items-center justify-center cursor-pointer hover:border-accent hover:text-accent text-[#888] transition-all shadow-lg group/edit">

                                    {{-- Pencil Icon (Hidden when loading) --}}
                                    <div wire:loading.remove wire:target="avatar">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                                        </svg>
                                    </div>

                                    {{-- Spinner (Shown when loading) --}}
                                    <div wire:loading wire:target="avatar">
                                        <div
                                            class="w-4 h-4 border-2 border-accent border-t-transparent rounded-full animate-spin">
                                        </div>
                                    </div>

                                    {{-- Hidden Input --}}
                                    <input type="file" id="avatar_upload" wire:model="avatar" class="hidden"
                                        accept="image/*">
                                </label>

                            </div>
                        </div>

                        {{-- 2. BASIC INFO --}}
                        <div class="text-center mb-8">
                            <h2 class="text-xl text-white font-bold mb-2">{{ Auth::user()->name }}</h2>
                            <p class="text-sm text-[#666] break-all">{{ Auth::user()->email }}</p>
                        </div>

                        {{-- 3. BOTTOM DETAILS --}}
                        <div class="border-t border-white/10 pt-6 space-y-4">
                            <div class="flex justify-between items-center">
                                <span class="text-[13px] uppercase tracking-widest text-[#555]">Email Status</span>
                                <span
                                    class="flex items-center gap-2 text-[13px] uppercase tracking-widest font-mono text-green-400">
                                    @if (Auth::user()->email_verified_at)
                                        Verified
                                    @else
                                        Unverified
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- RIGHT COLUMN: Forms --}}
        <div class="lg:col-span-2 space-y-10">

            {{-- 1. General Info Form --}}
            <div class="bg-white/[0.02] border border-white/5 p-8 rounded-sm">
                <h3
                    class="text-md uppercase font-bold tracking-widest mb-6 border-b border-white/10 pb-4 flex items-center gap-2">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="3">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                        <circle cx="12" cy="7" r="4"></circle>
                    </svg>
                    Personal Details
                </h3>

                <form wire:submit="updateProfile" class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="group">
                            <label
                                class="block text-[10px] text-[#666] uppercase tracking-widest mb-2 group-focus-within:text-accent transition-colors">Full
                                Name</label>
                            <input wire:model="name" type="text"
                                class="w-full bg-black/20 border border-white/10 px-4 py-3 text-sm text-white focus:outline-none focus:border-accent transition-all placeholder-white/20 font-display">
                            @error('name')
                                <span class="text-red-500 text-[10px] mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="group">
                            <label
                                class="block text-[10px] text-[#666] uppercase tracking-widest mb-2 group-focus-within:text-accent transition-colors">Email
                                Address</label>
                            <input wire:model="email" type="email"
                                class="w-full bg-black/20 border border-white/10 px-4 py-3 text-sm text-white focus:outline-none focus:border-accent transition-all placeholder-white/20 font-display">
                            @error('email')
                                <span class="text-red-500 text-[10px] mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="group">
                        <label
                            class="block text-[10px] text-[#666] uppercase tracking-widest mb-2 group-focus-within:text-accent transition-colors">Website
                            URL</label>
                        <input wire:model="website" type="url" placeholder="https://example.com"
                            class="w-full bg-black/20 border border-white/10 px-4 py-3 text-sm text-white focus:outline-none focus:border-accent transition-all placeholder-white/20 font-display">
                        @error('website')
                            <span class="text-red-500 text-[10px] mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="group">
                        <label
                            class="block text-[10px] text-[#666] uppercase tracking-widest mb-2 group-focus-within:text-accent transition-colors">About You</label>
                        <textarea wire:model="bio" rows="4" placeholder="Enter personnel description..."
                            class="w-full bg-black/20 border border-white/10 px-4 py-3 text-sm text-white focus:outline-none focus:border-accent transition-all placeholder-white/20 font-display resize-none"></textarea>
                        @error('bio')
                            <span class="text-red-500 text-[10px] mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="flex justify-end pt-4 border-t border-white/5">
                        <button type="submit"
                            class="group bg-white/5 border border-white/10 hover:border-accent hover:bg-accent/10 px-6 py-2 transition-all flex items-center gap-3">
                            <span class="text-xs text-white uppercase tracking-widest group-hover:text-accent">Update
                                </span>
                            <div wire:loading wire:target="updateProfile"
                                class="w-3 h-3 border-2 border-accent border-t-transparent rounded-full animate-spin">
                            </div>
                        </button>
                    </div>
                </form>
            </div>

            {{-- 2. Password Form --}}
            <div class="bg-white/[0.02] border border-white/5 p-8 rounded-sm">
                <h3
                    class="text-md uppercase font-bold tracking-widest mb-6 border-b border-white/10 pb-4 flex items-center gap-2">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="3">
                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                        <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                    </svg>
                    Change Password
                </h3>

                <form wire:submit="updatePassword" class="space-y-6">
                    <div class="group">
                        <label
                            class="block text-[10px] text-[#666] uppercase tracking-widest mb-2 group-focus-within:text-accent transition-colors">Current
                            Password</label>
                        <input wire:model="current_password" type="password"
                            class="w-full bg-black/20 border border-white/10 px-4 py-3 text-sm text-white focus:outline-none focus:border-accent transition-all font-mono tracking-widest">
                        @error('current_password')
                            <span class="text-red-500 text-[10px] mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="group">
                            <label
                                class="block text-[10px] text-[#666] uppercase tracking-widest mb-2 group-focus-within:text-accent transition-colors">New
                                Password</label>
                            <input wire:model="password" type="password"
                                class="w-full bg-black/20 border border-white/10 px-4 py-3 text-sm text-white focus:outline-none focus:border-accent transition-all font-mono tracking-widest">
                            @error('password')
                                <span class="text-red-500 text-[10px] mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="group">
                            <label
                                class="block text-[10px] text-[#666] uppercase tracking-widest mb-2 group-focus-within:text-accent transition-colors">Confirm
                                Password</label>
                            <input wire:model="password_confirmation" type="password"
                                class="w-full bg-black/20 border border-white/10 px-4 py-3 text-sm text-white focus:outline-none focus:border-accent transition-all font-mono tracking-widest">
                        </div>
                    </div>

                    <div class="flex justify-end pt-4 border-t border-white/5">
                        <button type="submit"
                            class="group bg-red-500/10 border border-red-500/30 hover:border-red-500 hover:bg-red-500/20 px-6 py-2 transition-all flex items-center gap-3">
                            <span
                                class="text-xs text-red-400 uppercase tracking-widest group-hover:text-red-300">Update</span>
                            <div wire:loading wire:target="updatePassword"
                                class="w-3 h-3 border-2 border-red-500 border-t-transparent rounded-full animate-spin">
                            </div>
                        </button>
                    </div>
                </form>
            </div>

            {{-- 3. Account Termination (Danger Zone) --}}
            <div class="bg-red-500/[0.02] border border-red-500/20 p-8 rounded-sm relative overflow-hidden group">
                <h3
                    class="text-md text-red-400 uppercase font-bold tracking-widest mb-6 border-b border-red-500/10 pb-4 flex items-center gap-2">

                    <!-- Warning / Exclamation Icon -->
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 9v4"></path>
                        <path d="M12 17h.01"></path>
                        <path
                            d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z">
                        </path>
                    </svg>

                    Delete Account
                </h3>
                <div class="mb-3">
                    <p class="text-sm text-[#888] font-mono leading-relaxed">
                        Once you delete your account, there is no going back. Please be certain.
                    </p>
                </div>

                <form wire:submit="deleteAccount" class="space-y-6">
                    <div class="group">
                        <label class="block text-[10px] text-red-500/70 uppercase tracking-widest mb-2">
                            Password
                        </label>
                        <input wire:model="delete_password" type="password"
                            placeholder="Enter your password to confirm"
                            class="w-full bg-black/40 border border-red-500/20 px-4 py-3 text-sm text-white focus:outline-none focus:border-red-500 transition-all font-mono tracking-widest placeholder-red-500/20">

                        @error('delete_password')
                            <span class="text-red-500 text-[10px] mt-1 block font-mono">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="flex justify-end pt-2">
                        {{-- Updated Button: Triggers confirmDelete to check password & open modal --}}
                        <button type="button" wire:click="confirmDelete"
                            class="group bg-red-500/10 border border-red-500/30 hover:border-red-500 hover:bg-red-500/20 px-6 py-2 transition-all flex items-center gap-3">

                            <span class="text-xs text-red-400 uppercase tracking-widest group-hover:text-red-300">
                                Delete Account
                            </span>

                            {{-- Loading Spinner --}}
                            <div wire:loading wire:target="confirmDelete"
                                class="w-3 h-3 border-2 border-red-500 border-t-transparent rounded-full animate-spin">
                            </div>
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
    {{-- Delete Modal --}}
    @if ($isDeleteModalOpen)
        <div class="fixed inset-0 z-50 flex items-center justify-center px-4">

            {{-- Backdrop --}}
            <div class="absolute inset-0 bg-black/90 backdrop-blur-sm" wire:click="$set('isDeleteModalOpen', false)">
            </div>

            {{-- Modal Content --}}
            <div
                class="relative w-full max-w-sm p-6 bg-[#0a0a0a] border border-red-500/30 shadow-[0_0_30px_rgba(255,0,0,0.1)] z-10 text-center">

                <svg class="mx-auto w-12 h-12 text-red-500 mb-4" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="1">
                    <path
                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>

                <h3 class="text-lg text-white font-light mb-2">Confirm Deletion</h3>
                <p class="text-xs text-[#888] font-mono mb-6">Permanently delete this account?</p>

                <div class="flex gap-3">
                    {{-- Cancel Button --}}
                    <button wire:click="$set('isDeleteModalOpen', false)"
                        class="flex-1 bg-white/5 border border-white/10 text-white py-3 text-[10px] font-bold uppercase tracking-widest hover:bg-white/10 transition-colors">
                        Cancel
                    </button>

                    {{-- Confirm Button (Triggering Actual Delete) --}}
                    <button wire:click="deleteAccount"
                        class="flex-1 bg-red-600/20 border border-red-500/50 text-red-500 py-3 text-[10px] font-bold uppercase tracking-widest hover:bg-red-600 hover:text-white transition-all flex justify-center items-center gap-2">
                        <span>Confirm</span>

                        <div wire:loading wire:target="deleteAccount"
                            class="w-3 h-3 border-2 border-white/50 border-t-transparent rounded-full animate-spin">
                        </div>
                    </button>
                </div>
            </div>
        </div>
    @endif
</main>

{{-- Toast Script --}}
@script
    <script>
        Livewire.on('show-toast', (data) => {
            const payload = Array.isArray(data) ? data[0] : data;
            if (window.showToast) {
                window.showToast(payload.type, payload.title, payload.message);
            } else {
                console.error('window.showToast function is not loaded.');
            }
        });
    </script>
@endscript
