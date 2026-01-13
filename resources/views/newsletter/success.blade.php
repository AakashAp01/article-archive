@extends('layout.error')
@section('title', 'Unsubscribed')
@section('content')

<div class="bg-bg text-white h-screen flex flex-col items-center justify-center relative overflow-hidden selection:bg-accent selection:text-black">

    {{-- Background Grid & Glow --}}
    <div class="absolute inset-0 bg-[linear-gradient(rgba(255,255,255,0.02)_1px,transparent_1px),linear-gradient(90deg,rgba(255,255,255,0.02)_1px,transparent_1px)] bg-[size:40px_40px] pointer-events-none"></div>

    {{-- Content --}}
    <div class="relative z-10 text-center px-6">
        <div class="font-display text-[#666] text-sm tracking-[0.3em] mb-4">
            // STATUS: OFFLINE
        </div>
        
        <h1 class="text-6xl md:text-7xl font-light tracking-tighter mb-2 opacity-90 text-[#888]">
            SEVERED
        </h1>
        
        <div class="h-px w-24 bg-white/10 mx-auto my-8"></div>

        <p class="font-display text-[#666] text-sm max-w-md mx-auto leading-relaxed mb-10">
            {{ $message ?? 'You have been successfully removed from the database.' }}
        </p>

        <a href="{{ route('welcome') }}" class="group inline-flex items-center gap-3 border border-white/10 bg-white/5 px-8 py-4 hover:border-white/30 hover:bg-white/10 transition-all duration-300">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="text-[#666] group-hover:text-white transition-colors"><path d="m12 19-7-7 7-7"/><path d="M19 12H5"/></svg>
            <span class="font-display text-xs uppercase tracking-widest text-[#888] group-hover:text-white">Return to Home</span>
        </a>
    </div>

</div>
@endsection