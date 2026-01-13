@extends('layout.error')
@section('title', '503 Service Unavailable')
@section('content')
<div class="bg-bg text-white h-screen flex flex-col items-center justify-center relative overflow-hidden">

    {{-- Animated Grid Background --}}
    <div class="absolute inset-0 bg-[linear-gradient(rgba(0,255,136,0.03)_1px,transparent_1px),linear-gradient(90deg,rgba(0,255,136,0.03)_1px,transparent_1px)] bg-[size:100px_100px]"></div>

    <div class="relative z-10 flex flex-col items-center text-center px-6">
        
        {{-- Spinning Loader --}}
        <div class="relative w-24 h-24 mb-10">
            <div class="absolute inset-0 border-t-2 border-accent rounded-full animate-spin"></div>
            <div class="absolute inset-3 border-r-2 border-white/20 rounded-full animate-spin [animation-duration:3s]"></div>
            <div class="absolute inset-0 flex items-center justify-center font-display text-xs text-accent">
                SYS
            </div>
        </div>

        <h1 class="text-4xl md:text-5xl font-light text-white mb-4">
            System Maintenance
        </h1>

        <p class="font-display text-[#888] text-xs uppercase tracking-widest max-w-md leading-relaxed">
            Core systems are undergoing scheduled recalibration. 
            <br>Estimated return: Shortly.
        </p>
    </div>

    <div class="absolute bottom-8 left-0 w-full text-center">
        <span class="inline-flex items-center gap-2 px-3 py-1 bg-white/5 rounded-full border border-white/5">
            <span class="w-1.5 h-1.5 bg-yellow-500 rounded-full animate-pulse"></span>
            <span class="text-[10px] text-[#666] font-display uppercase">Standby Mode Active</span>
        </span>
    </div>

</div>
@endsection