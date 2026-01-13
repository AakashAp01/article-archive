{{-- OUTER CONTAINER --}}
<div class="min-h-screen w-full flex items-center justify-center px-4 pt-32 pb-12 md:px-8 relative overflow-hidden">

    {{-- CARD --}}
    <div class="w-full max-w-md relative z-10">

        {{-- Header --}}
        <div class="mb-8 md:mb-10 text-center">
            <div
                class="inline-flex items-center gap-2 text-accent border border-accent/30 px-3 py-1 rounded-full text-sm mb-4 bg-accent/5 backdrop-blur-sm">
                <span class="w-1.5 h-1.5 rounded-full bg-accent animate-pulse"></span>
                SECURE GATEWAY
            </div>

            <h1 class="text-2xl md:text-3xl font-bold text-white tracking-tight mb-2">
                @if ($isForgotPassword)
                    Credential Recovery
                @elseif ($isLoginMode)
                    Identify Yourself
                @else
                    New User Uplink
                @endif
            </h1>
            <p class="text-sm text-[#666] px-4">
                @if ($isForgotPassword)
                    Target email for neural reset link.
                @elseif ($isLoginMode)
                    Enter credentials to access the grid.
                @else
                    Establish a new neural identity.
                @endif
            </p>
        </div>

        <form wire:submit="submit" class="space-y-4 md:space-y-5">

            {{-- Success Message --}}
            @if (session()->has('status'))
                <div
                    class="bg-green-500/10 border border-green-500/20 text-green-500 text-sm px-4 py-3 rounded-sm text-center uppercase tracking-wider">
                    {{ session('status') }}
                </div>
            @endif

            {{-- 1. OTP INPUT SECTION (Only visible in OTP Mode) --}}
            @if ($isOtpMode)
                <div class="animate-fade-in-down">
                    <div class="bg-blue-500/10 border border-blue-500/20 p-4 mb-4 rounded-sm text-center">
                        <p class="text-xs text-blue-400 mb-2">Verification Code Sent</p>
                        <p class="text-sm text-[#888]">Please enter the 6-digit code sent to your email.</p>
                    </div>

                    <div class="group">
                        <label
                            class="block text-sm uppercase tracking-widest text-[#888] mb-2 group-focus-within:text-accent transition-colors">One-Time
                            Password</label>
                        <input wire:model="otp" type="text" maxlength="6"
                            class="w-full bg-white/5 border border-white/10 rounded-sm px-4 py-3 text-center text-xl tracking-[0.5em] font-mono text-white outline-none focus:border-accent focus:bg-white/10 transition-all placeholder-white/10"
                            placeholder="000000">
                        @error('otp')
                            <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="text-center mt-4">
                        <button type="button" wire:click="$set('isOtpMode', false)"
                            class="text-xs text-[#666] hover:text-white border-b border-[#666] hover:border-accent  outline-none">
                            Wrong email? Go Back
                        </button>
                    </div>
                </div>

                {{-- 2. STANDARD FORM (Hidden if in OTP Mode) --}}
            @else
                {{-- Name (Register Only) --}}
                @if (!$isLoginMode && !$isForgotPassword)
                    <div class="group animate-fade-in-down">
                        <label
                            class="block text-sm uppercase tracking-widest text-[#888] mb-2 group-focus-within:text-accent transition-colors">Username</label>
                        <input wire:model="name" type="text"
                            class="w-full bg-white/5 border border-white/10 rounded-sm px-4 py-3 text-sm text-white outline-none focus:border-accent focus:bg-white/10 transition-all placeholder-white/20"
                            placeholder="John Doe">
                        @error('name')
                            <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>
                @endif

                {{-- Email --}}
                <div class="group">
                    <label
                        class="block text-sm uppercase tracking-widest text-[#888] mb-2 group-focus-within:text-accent transition-colors">Email</label>
                    <input wire:model="email" type="email"
                        class="w-full bg-white/5 border border-white/10 rounded-sm px-4 py-3 text-sm text-white outline-none focus:border-accent focus:bg-white/10 transition-all placeholder-white/20"
                        placeholder="user@domain.com">
                    @error('email')
                        <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Password (Not needed for Forgot Password) --}}
                @if (!$isForgotPassword)
                    <div class="group">
                        <div class="flex justify-between items-center mb-2">
                            <label
                                class="block text-sm uppercase tracking-widest text-[#888] group-focus-within:text-accent transition-colors">Password</label>
                            @if ($isLoginMode)
                                <button type="button" wire:click="enableForgotPassword"
                                    class="text-sm text-red-500 hover:text-white transition-colors uppercase tracking-wider outline-none">
                                    Lost Password ?
                                </button>
                            @endif
                        </div>
                        <input wire:model="password" type="password"
                            class="w-full bg-white/5 border border-white/10 rounded-sm px-4 py-3 text-sm text-white outline-none focus:border-accent focus:bg-white/10 transition-all placeholder-white/20"
                            placeholder="••••••••••••">
                        @error('password')
                            <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>
                @endif

            @endif

            {{-- Submit Button --}}
            <div class="pt-4">
                <button type="submit"
                    class="group w-full relative overflow-hidden bg-green-500/10 border border-green-500/50 hover:bg-green-500 text-green-500 hover:text-white py-3.5 transition-all duration-300 active:scale-[0.98]">

                    <div
                        class="absolute inset-0 w-0 bg-green-500 transition-all duration-[250ms] ease-out group-hover:w-full opacity-10">
                    </div>

                    <div class="relative flex items-center justify-center gap-2">
                        <span wire:loading.remove wire:target="submit"
                            class="font-display uppercase tracking-widest text-xs font-bold transition-colors">
                            @if ($isForgotPassword)
                                Initialize Reset
                            @elseif ($isOtpMode)
                                Verify    
                            @elseif ($isLoginMode)
                                Login
                            @else
                                Sign Up
                            @endif
                        </span>
                        <span wire:loading wire:target="submit"
                            class="font-display uppercase tracking-widest text-xs font-bold transition-colors">
                            Processing...
                        </span>
                    </div>
                </button>
            </div>
        </form>

        {{-- Divider --}}
        <div class="relative my-8 text-center">
            <div class="absolute inset-0 flex items-center" aria-hidden="true">
                <div class="w-full border-t border-white/10"></div>
            </div>
            <span class="relative bg-[#0a0a0f] px-4 text-sm text-[#666] uppercase tracking-widest">
                {{ $isForgotPassword ? 'Or Return To' : 'Or Authenticate With' }}
            </span>
        </div>

        {{-- GOOGLE LOGIN BUTTON (Only show if NOT in forgot password mode to keep UI clean, or keep it if preferred. I kept it hidden in reset mode for focus) --}}
        @if (!$isForgotPassword)
            <a href="{{ route('google.login') }}"
                class="flex items-center justify-center gap-3 w-full bg-white text-gray-700 hover:bg-gray-100 border border-gray-300 py-3 transition-all duration-300 group rounded-sm relative overflow-hidden">
                <svg class="w-5 h-5 flex-shrink-0" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"
                        fill="#4285F4" />
                    <path
                        d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"
                        fill="#34A853" />
                    <path
                        d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"
                        fill="#FBBC05" />
                    <path
                        d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"
                        fill="#EA4335" />
                </svg>
                <span class="text-xs font-bold tracking-wider uppercase">Sign in with Google</span>
            </a>
        @endif

        {{-- Toggle Mode Footer --}}
        <div class="mt-8 text-center">
            @if ($isForgotPassword)
                <button wire:click="cancelForgotPassword"
                    class="text-xs text-[#666] hover:text-accent transition-colors font-mono uppercase tracking-wider">
                    <span class="underline decoration-accent/50 underline-offset-4">Abort Reset Sequence</span>
                </button>
            @else
                <button wire:click="toggleMode" wire:loading.attr="disabled"
                    class="text-xs text-[#666] hover:text-accent transition-colors font-mono disabled:opacity-50">
                    @if ($isLoginMode)
                        New here? <span class="underline decoration-accent/50 underline-offset-4">Create Account</span>
                    @else
                        Already have an account? <span class="underline decoration-accent/50 underline-offset-4">Access
                            Login</span>
                    @endif
                </button>
            @endif
        </div>

    </div>
</div>
