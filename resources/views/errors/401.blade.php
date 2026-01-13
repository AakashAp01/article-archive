@extends('layout.error')
@section('title', '401 Unauthorized')
@section('content')
    <div class="bg-bg text-white h-screen flex flex-col items-center justify-center relative overflow-hidden">
        <div
            class="absolute inset-0 bg-[radial-gradient(circle_at_top,rgba(255,255,255,0.03)_0%,transparent_50%)] pointer-events-none">
        </div>

        <div class="relative z-10 text-center px-6 max-w-md w-full">
            {{-- Lock Icon --}}
            <div
                class="mx-auto w-16 h-16 border border-white/10 rounded-full flex items-center justify-center mb-8 relative">
                <div class="absolute inset-0 rounded-full border border-accent/20 animate-ping"></div>
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
                    class="text-white">
                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2" />
                    <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                </svg>
            </div>

            <h1 class="font-display text-xl text-white uppercase tracking-[0.2em] mb-2">
                Identity Unverified
            </h1>
            <p class="text-xs text-[#666] font-display mb-8">ERROR_401 // AUTHENTICATION_REQUIRED</p>

            <p class="text-sm text-[#888] leading-relaxed mb-8">
                This sector requires valid biometric signatures. Your session is either invalid or has not yet been
                established.
            </p>

            <a href="{{ route('login') }}"
                class="block w-full border border-accent bg-accent/10 py-3 text-accent font-display text-xs uppercase tracking-widest hover:bg-accent hover:text-black transition-all duration-300">
                Initiate Login Sequence
            </a>
        </div>
    </div>
@endsection
