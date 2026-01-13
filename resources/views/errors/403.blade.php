@extends('layout.error')
@section('title', '403 Forbidden')
@section('content')

<div class="bg-bg text-white h-screen flex flex-col items-center justify-center relative overflow-hidden">

    {{-- Scanlines effect --}}
    <div class="absolute inset-0 bg-[linear-gradient(rgba(18,16,16,0)_50%,rgba(0,0,0,0.25)_50%),linear-gradient(90deg,rgba(255,0,0,0.06),rgba(0,255,0,0.02),rgba(0,0,255,0.06))] bg-[size:100%_4px,3px_100%] pointer-events-none z-20"></div>

    <div class="relative z-10 text-center px-6">
        <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" class="text-[#444] mx-auto mb-6"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>

        <h1 class="font-display text-2xl md:text-3xl text-white uppercase tracking-[0.2em] mb-4">
            Access Denied
        </h1>
        
        <div class="bg-white/5 border border-white/10 p-4 inline-block mb-8">
            <code class="font-display text-warn text-xs">
                > Security Clearance: INSUFFICIENT<br>
                > Protocol: 403_FORBIDDEN<br>
                > User: {{ auth()->user()->name ?? 'GUEST' }}
            </code>
        </div>

        <div>
            <a href="{{ url()->previous() }}" class="text-[#666] hover:text-white font-display text-xs uppercase tracking-widest border-b border-transparent hover:border-white transition-all pb-1">
                < Return to Safe Zone
            </a>
        </div>
    </div>

</body>
@endsection