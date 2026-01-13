@extends('layout.error')
@section('title', '500 Internal Server Error')
@section('content')
    <div class="bg-bg text-white h-screen flex flex-col items-center justify-center relative overflow-hidden">

        {{-- Red Glow for Error --}}
        <div
            class="absolute inset-0 bg-[radial-gradient(circle_at_center,rgba(255,51,51,0.05)_0%,transparent_70%)] pointer-events-none">
        </div>

        <div class="relative z-10 text-center px-6 border border-white/10 p-12 bg-black/40 backdrop-blur-sm max-w-lg w-full">
            <div class="flex justify-center mb-6">
                <div class="w-16 h-16 border border-danger/30 rounded-full flex items-center justify-center bg-danger/5">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="1.5" class="text-danger">
                        <path
                            d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z" />
                        <line x1="12" y1="9" x2="12" y2="13" />
                        <line x1="12" y1="17" x2="12.01" y2="17" />
                    </svg>
                </div>
            </div>

            <h1 class="text-4xl font-light tracking-tight mb-2">
                CRITICAL FAILURE
            </h1>
            <p class="font-display text-danger text-xs tracking-widest mb-8">ERROR_CODE_500 // INTERNAL_SERVER_ERROR</p>

            <p class="font-display text-[#888] text-sm leading-relaxed mb-8">
                The system encountered an unrecoverable logic paradox. Core dump initialized. Engineers have been notified
                of the anomaly.
            </p>

            <a href="{{ url('/') }}"
                class="inline-block w-full bg-white text-black font-display text-xs font-bold uppercase py-4 hover:bg-gray-200 transition-colors">
                Attempt System Restart
            </a>
        </div>

    </div>
@endsection
