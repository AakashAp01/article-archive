@extends('layout.error')
@section('title', '503 - Under Maintenance')
@section('content')
<div class="bg-bg text-white h-screen flex flex-col items-center justify-center relative overflow-hidden selection:bg-red-500 selection:text-black">

    {{-- Background Grid & Glow --}}
    <div class="absolute inset-0 bg-[linear-gradient(rgba(255,255,255,0.02)_1px,transparent_1px),linear-gradient(90deg,rgba(255,255,255,0.02)_1px,transparent_1px)] bg-[size:40px_40px] pointer-events-none"></div>
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[500px] h-[500px] bg-red-500/5 rounded-full blur-[120px] pointer-events-none"></div>

    {{-- Content --}}
    <div class="relative z-10 text-center px-6">
        <div class="font-display text-red-500 text-sm tracking-[0.3em] mb-4 animate-pulse">
            MAINTENANCE
        </div>
        
        <h1 class="text-8xl md:text-9xl font-light tracking-tighter mb-2 opacity-90">
            503
        </h1>
        
        <div class="h-px w-24 bg-red-500/50 mx-auto my-8"></div>

        <p class="font-display text-[#888] text-sm max-w-md mx-auto leading-relaxed mb-10">
            We're currently performing some maintenance. We'll be back shortly!
        </p>

        <a href="{{ route('welcome') }}" class="group inline-flex items-center gap-3 border border-white/10 bg-white/5 px-8 py-4 hover:border-red-500 hover:bg-red-500/10 transition-all duration-300">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="text-[#666] group-hover:text-red-500 transition-colors"><path d="m12 19-7-7 7-7"/><path d="M19 12H5"/></svg>
            <span class="font-display text-xs uppercase tracking-widest text-white group-hover:text-red-500">Check Again</span>
        </a>
    </div>

    {{-- Decor --}}
    <div class="absolute bottom-10 right-10 font-display text-[10px] text-[#444]">
        SYS_ID: {{ uniqid() }}
    </div>

</div>
@endsection