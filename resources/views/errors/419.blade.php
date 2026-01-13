@extends('layout.error')
@section('title', '419 Page Expired')
@section('content')
    <div class="bg-bg text-white h-screen flex flex-col items-center justify-center relative overflow-hidden">

        <div class="relative z-10 text-center px-6">
            <h1 class="text-6xl md:text-8xl font-light text-white/10 mb-4 select-none">
                TIMEOUT
            </h1>

            <div class="relative -top-8">
                <div class="inline-block bg-warn/10 border border-warn/20 px-4 py-1 rounded-full mb-6">
                    <span class="text-[10px] font-display text-warn uppercase tracking-widest">Signal Lost</span>
                </div>

                <p class="font-display text-[#888] text-sm max-w-sm mx-auto leading-relaxed mb-8">
                    The secure handshake has expired due to inactivity. The data stream was severed to prevent corruption.
                </p>

                <button onclick="window.location.reload();"
                    class="group inline-flex items-center gap-2 text-white hover:text-warn transition-colors">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" class="group-hover:rotate-180 transition-transform duration-500">
                        <path d="M21.5 2v6h-6M2.5 22v-6h6M2 11.5a10 10 0 0 1 18.8-4.3M22 12.5a10 10 0 0 1-18.8 4.3" />
                    </svg>
                    <span
                        class="font-display text-xs uppercase tracking-widest border-b border-transparent group-hover:border-warn pb-0.5">Reconnect</span>
                </button>
            </div>
        </div>

    </div>
@endsection
