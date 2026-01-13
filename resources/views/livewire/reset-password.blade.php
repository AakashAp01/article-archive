{{-- OUTER CONTAINER --}}
<div class="min-h-screen w-full flex items-center justify-center px-4 pt-32 pb-12 md:px-8 relative overflow-hidden">

    {{-- CARD --}}
    <div class="w-full max-w-md relative z-10">

        {{-- Header --}}
        <div class="mb-8 md:mb-10 text-center">
            <div
                class="inline-flex items-center gap-2 text-accent border border-accent/30 px-3 py-1 rounded-full text-[10px] mb-4 bg-accent/5 backdrop-blur-sm">
                <span class="w-1.5 h-1.5 rounded-full bg-accent animate-pulse"></span>
                SYSTEM OVERRIDE
            </div>

            <h1 class="text-2xl md:text-3xl text-white font-bold tracking-tight mb-2">
                Update Credentials
            </h1>
            <p class="text-sm text-[#666] px-4">
                Establish new security password.
            </p>
        </div>

        {{-- FORM --}}
        <form wire:submit="submit" class="space-y-4 md:space-y-5">

            {{-- Email (Read Only - for verification context) --}}
            <div class="group opacity-70 pointer-events-none">
                <label class="block text-[10px] uppercase tracking-widest text-[#888] mb-2">Email</label>
                <input wire:model="email" type="email" readonly
                    class="w-full bg-white/5 border border-white/10 rounded-sm px-4 py-3 text-sm text-[#888] outline-none cursor-not-allowed">
            </div>

            {{-- New Password --}}
            <div class="group animate-fade-in-down">
                <label
                    class="block text-[10px] uppercase tracking-widest text-[#888] mb-2 group-focus-within:text-accent transition-colors">
                    New Password
                </label>
                <input wire:model="password" type="password"
                    class="w-full bg-white/5 border border-white/10 rounded-sm px-4 py-3 text-sm text-white outline-none focus:border-accent focus:bg-white/10 transition-all placeholder-white/20"
                    placeholder="••••••••••••">
                @error('password')
                    <span class="text-red-500 text-[10px] mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            {{-- Confirm Password --}}
            <div class="group animate-fade-in-down" style="animation-delay: 100ms;">
                <label
                    class="block text-[10px] uppercase tracking-widest text-[#888] mb-2 group-focus-within:text-accent transition-colors">
                    Confirm Password
                </label>
                <input wire:model="password_confirmation" type="password"
                    class="w-full bg-white/5 border border-white/10 rounded-sm px-4 py-3 text-sm text-white outline-none focus:border-accent focus:bg-white/10 transition-all placeholder-white/20"
                    placeholder="••••••••••••">
            </div>

            {{-- Submit Button --}}
            <div class="pt-4">
                <button type="submit"
                    class="group w-full relative overflow-hidden bg-green-500/10 border border-green-500/50 hover:bg-green-500 text-green-500 hover:text-white py-3.5 transition-all duration-300 active:scale-[0.98]">

                    {{-- Hover Fill Effect --}}
                    <div
                        class="absolute inset-0 w-0 bg-green-500 transition-all duration-[250ms] ease-out group-hover:w-full opacity-10">
                    </div>

                    <div class="relative flex items-center justify-center gap-2">
                        <span wire:loading.remove wire:target="submit"
                            class="font-display uppercase tracking-widest text-xs font-bold transition-colors">
                            Confirm Change
                        </span>
                        <span wire:loading wire:target="submit"
                            class="font-display uppercase tracking-widest text-xs font-bold transition-colors">
                            Processing...
                        </span>
                    </div>
                </button>
            </div>
        </form>
    </div>
</div>