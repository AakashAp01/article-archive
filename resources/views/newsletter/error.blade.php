@extends('layout.error')
@section('title', 'Link Error')
@section('content')

<div class="bg-bg text-white h-screen flex flex-col items-center justify-center relative overflow-hidden selection:bg-yellow-500 selection:text-black">

    {{-- Background Grid --}}
    <div class="absolute inset-0 bg-[linear-gradient(rgba(255,255,255,0.02)_1px,transparent_1px),linear-gradient(90deg,rgba(255,255,255,0.02)_1px,transparent_1px)] bg-[size:40px_40px] pointer-events-none"></div>

    {{-- Content --}}
    <div class="relative z-10 text-center px-6">
        <div class="font-display text-yellow-500 text-sm tracking-[0.3em] mb-4">
            // LINK_EXPIRED
        </div>
        
        <h1 class="text-6xl md:text-7xl font-light tracking-tighter mb-2 opacity-90">
            INVALID
        </h1>
        
        <div class="h-px w-24 bg-yellow-500/50 mx-auto my-8"></div>

        <p class="font-display text-[#888] text-sm max-w-md mx-auto leading-relaxed mb-10">
            {{ $message ?? 'The link you followed is invalid or has already been processed.' }}
        </p>

        <a href="{{ route('welcome') }}" class="group inline-flex items-center gap-3 border border-white/10 bg-white/5 px-8 py-4 hover:border-yellow-500 hover:bg-yellow-500/10 transition-all duration-300">
            <span class="font-display text-xs uppercase tracking-widest text-white group-hover:text-yellow-500">Return to Safety</span>
        </a>
    </div>

</div>
@endsection