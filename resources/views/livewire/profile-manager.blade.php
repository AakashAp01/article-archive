<main class="max-w-7xl mx-auto mt-32 px-6 pb-20 relative ">

    <x-page-header 
        title="My Profile" 
        subtitle="Manage your account details and security" 
    />

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
        <div class="lg:col-span-1">
            <div class="sticky top-32 space-y-6">

                <div class="bg-white/[0.02] border border-white/10 relative overflow-hidden shadow-2xl group">

                    <div class="absolute top-0 left-0 w-3 h-3 border-l border-t border-accent"></div>
                    <div class="absolute bottom-0 right-0 w-3 h-3 border-r border-b border-accent"></div>

                    <div class="p-8">
                        <div class="flex justify-center mb-6 relative">
                            <div class="relative w-32 h-32">

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

                                <label for="avatar_upload"
                                    class="absolute bottom-0 right-0 z-30 w-8 h-8 bg-black border border-white/20 rounded-full flex items-center justify-center cursor-pointer hover:border-accent hover:text-accent text-[#888] transition-all shadow-lg group/edit">

                                    <div wire:loading.remove wire:target="avatar">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                                        </svg>
                                    </div>

                                    <div wire:loading wire:target="avatar">
                                        <div
                                            class="w-4 h-4 border-2 border-accent border-t-transparent rounded-full animate-spin">
                                        </div>
                                    </div>

                                    <input type="file" id="avatar_upload" wire:model="avatar" class="hidden"
                                        accept="image/*">
                                </label>

                            </div>
                        </div>

                        <div class="text-center mb-8">
                            <h2 class="text-xl text-white font-bold mb-2">{{ Auth::user()->name }}</h2>
                            <p class="text-sm text-[#666] break-all">{{ Auth::user()->email }}</p>
                        </div>

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

        <div class="lg:col-span-2 space-y-10">

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
                        <textarea wire:model="bio" rows="4" placeholder="Write a bit about yourself..."
                            class="w-full bg-black/20 border border-white/10 px-4 py-3 text-sm text-white focus:outline-none focus:border-accent transition-all placeholder-white/20 font-display resize-none"></textarea>
                        @error('bio')
                            <span class="text-red-500 text-[10px] mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="flex justify-end pt-4 border-t border-white/5">
                        <x-button type="submit">
                            <span wire:loading.remove wire:target="updateProfile">Save Changes</span>
                            <span wire:loading wire:target="updateProfile">Saving...</span>
                        </x-button>
                    </div>
                </form>
            </div>

            <div class="bg-white/[0.02] border border-white/5 p-8 rounded-sm">
                <h3
                    class="text-sm uppercase font-display tracking-widest mb-6 border-b border-white/10 pb-4 flex items-center gap-2 text-white">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                        <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                    </svg>
                    Change Password
                </h3>

                <form wire:submit="updatePassword" class="space-y-6">
                    <div class="group">
                        <label
                            class="block text-[10px] text-[#666] uppercase tracking-widest mb-2 group-focus-within:text-accent transition-colors">Current Password</label>
                        <input wire:model="current_password" type="password"
                            class="w-full bg-black/20 border border-white/10 px-4 py-3 text-sm text-white focus:outline-none focus:border-accent transition-all font-mono tracking-widest">
                        @error('current_password')
                            <span class="text-red-500 text-[10px] mt-1 block uppercase">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="group">
                            <label
                                class="block text-[10px] text-[#666] uppercase tracking-widest mb-2 group-focus-within:text-accent transition-colors">New Password</label>
                            <input wire:model="password" type="password"
                                class="w-full bg-black/20 border border-white/10 px-4 py-3 text-sm text-white focus:outline-none focus:border-accent transition-all font-mono tracking-widest">
                            @error('password')
                                <span class="text-red-500 text-[10px] mt-1 block uppercase">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="group">
                            <label
                                class="block text-[10px] text-[#666] uppercase tracking-widest mb-2 group-focus-within:text-accent transition-colors">Confirm New Password</label>
                            <input wire:model="password_confirmation" type="password"
                                class="w-full bg-black/20 border border-white/10 px-4 py-3 text-sm text-white focus:outline-none focus:border-accent transition-all font-mono tracking-widest">
                        </div>
                    </div>

                    <div class="flex justify-end pt-4 border-t border-white/5">
                        <x-button type="submit" variant="danger" class="!bg-red-500/10 !text-red-400 hover:!bg-red-500 hover:!text-white border-red-500/30">
                            <span wire:loading.remove wire:target="updatePassword">Update Password</span>
                            <span wire:loading wire:target="updatePassword">Updating...</span>
                        </x-button>
                    </div>
                </form>
            </div>

            <div class="bg-red-500/[0.02] border border-red-500/20 p-8 rounded-sm relative overflow-hidden group">
                <h3
                    class="text-sm text-red-400 uppercase font-display tracking-widest mb-6 border-b border-red-500/10 pb-4 flex items-center gap-2">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <path d="M12 9v4"></path>
                        <path d="M12 17h.01"></path>
                        <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path>
                    </svg>
                    DANGER ZONE: DELETE ACCOUNT
                </h3>
                <div class="mb-6">
                    <p class="text-xs text-[#666] font-mono leading-relaxed uppercase tracking-tighter">
                        Once you delete your account, there is no going back. All your data, articles, and settings will be removed forever.
                    </p>
                </div>

                <form wire:submit="confirmDelete" class="space-y-6">
                    <div class="group">
                        <label class="block text-[10px] text-red-500/50 uppercase tracking-widest mb-2 font-mono">
                            Confirm Password
                        </label>
                        <input wire:model="delete_password" type="password"
                            placeholder="Your current password..."
                            class="w-full bg-black/40 border border-red-500/20 px-4 py-3 text-sm text-white focus:outline-none focus:border-red-500 transition-all font-mono tracking-widest placeholder-red-500/10">

                        @error('delete_password')
                            <span class="text-red-500 text-[10px] mt-1 block font-mono uppercase">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="flex justify-end pt-2">
                        <x-button type="submit" variant="danger" class="w-full md:w-auto">
                            <span wire:loading.remove wire:target="confirmDelete">DELETE ACCOUNT</span>
                            <span wire:loading wire:target="confirmDelete">DELETING...</span>
                        </x-button>
                    </div>
                </form>
            </div>

        </div>
    </div>
    @if ($isDeleteModalOpen)
        <x-modal id="deleteAccountModal" 
            title="Delete Account?" 
            subtitle="Are you sure you want to permanently delete your account?"
            variant="danger"
            wire:click="$set('isDeleteModalOpen', false)"
            class="text-center">
            
            <svg class="mx-auto w-12 h-12 text-red-500 mb-4" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="1">
                <path d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
            
            <div class="flex gap-3">
                <x-button wire:click="$set('isDeleteModalOpen', false)" variant="outline" class="flex-1">Cancel</x-button>
                <x-button wire:click="deleteAccount" variant="danger" class="flex-1">
                    <span wire:loading.remove wire:target="deleteAccount">Yes, Delete Account</span>
                    <span wire:loading wire:target="deleteAccount">Deleting...</span>                </x-button>
            </div>
        </x-modal>
    @endif
</main>

@script
    <script>
        Livewire.on('show-toast', (data) => {
            const payload = Array.isArray(data) ? data[0] : data;
            if (window.showToast) {
                window.showToast(payload.type, payload.title, payload.message);
            }
        });
    </script>
@endscript
