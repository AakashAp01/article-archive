@extends('layout.error')
@section('title', 'Confirm Unsubscription')
@section('content')

    <div
        class="bg-bg text-white h-screen flex flex-col items-center justify-center relative overflow-hidden selection:bg-red-500 selection:text-black">

        {{-- Background Grid & Glow --}}
        <div
            class="absolute inset-0 bg-[linear-gradient(rgba(255,255,255,0.02)_1px,transparent_1px),linear-gradient(90deg,rgba(255,255,255,0.02)_1px,transparent_1px)] bg-[size:40px_40px] pointer-events-none">
        </div>
        <div
            class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[500px] h-[500px] bg-red-500/5 rounded-full blur-[120px] pointer-events-none">
        </div>

        {{-- Content --}}
        <div class="relative z-10 text-center px-6 w-full max-w-lg">
            <div class="font-display text-red-500 text-sm tracking-[0.3em] mb-4 animate-pulse">
                // TERMINATION_PROTOCOL
            </div>

            <h1 class="text-5xl md:text-6xl font-light tracking-tighter mb-2 opacity-90">
                DISCONNECT
            </h1>

            <div class="h-px w-24 bg-red-500/50 mx-auto my-8"></div>

            <p class="font-display text-[#888] text-sm max-w-md mx-auto leading-relaxed mb-8">
                You are about to sever your connection to the newsletter frequency. This action cannot be undone.
            </p>

            {{-- FORM --}}
            <form action="{{ route('newsletter.unsubscribe.process') }}" method="POST" class="text-left w-full">
                @csrf
                <input type="hidden" name="token" value="{{ $encoded_email }}">

                <div class="mb-8">
                    <label class="font-display text-[10px] uppercase tracking-widest text-[#666] mb-3 block text-center">
                        Optional: Reason for leaving
                    </label>
                    <textarea name="reason" rows="2"
                        class="w-full bg-black/40 border border-white/10 px-4 py-3 text-sm text-white focus:border-red-500 outline-none placeholder-[#444] text-center resize-none transition-all focus:bg-white/5"
                        placeholder="Content irrelevant? Too frequent?"></textarea>
                </div>

                <div class="flex flex-col items-center gap-4">
                    <button type="submit"
                        class="group w-full md:w-auto inline-flex justify-center items-center gap-3 border border-red-500/30 bg-red-500/10 px-8 py-4 hover:border-red-500 hover:bg-red-500 hover:text-white transition-all duration-300">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" class="text-red-500 group-hover:text-white transition-colors">
                            <path d="M18.36 6.64a9 9 0 1 1-12.73 0"></path>
                            <line x1="12" y1="2" x2="12" y2="12"></line>
                        </svg>
                        <span
                            class="font-display text-xs uppercase tracking-widest text-red-500 group-hover:text-white">Confirm
                            Termination</span>
                    </button>

                    <a href="{{ url('/') }}"
                        class="text-[#444] hover:text-[#888] font-display text-[10px] uppercase tracking-widest transition-colors mt-2">
                        Abort & Return Home
                    </a>
                </div>
            </form>
        </div>

    </div>
@endsection
