@extends('layout.error')
@section('title', '405 Method Not Allowed')
@section('content')

    <div class="bg-bg text-white h-screen flex flex-col items-center justify-center relative overflow-hidden">

        <div
            class="absolute inset-0 bg-[repeating-linear-gradient(45deg,rgba(255,255,255,0.01)_0px,rgba(255,255,255,0.01)_1px,transparent_1px,transparent_10px)] pointer-events-none">
        </div>

        <div class="relative z-10 text-center px-6">

            <div class="mb-6 flex justify-center">
                <div class="relative">
                    <div class="absolute -inset-2 bg-white/5 rounded-full blur-md"></div>
                    <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="1.5" class="text-gray-400 relative z-10">
                        <path d="m16 16 2.29 2.29a1 1 0 0 0 1.42 0l2.29-2.29" />
                        <path d="M22 16v-5a5 5 0 0 0-5-5h-4" />
                        <path d="m8 8-2.29-2.29a1 1 0 0 0-1.42 0L2 8" />
                        <path d="M2 8v5a5 5 0 0 0 5 5h4" />
                    </svg>
                </div>
            </div>

            <h1 class="text-4xl md:text-5xl font-light text-white mb-2 tracking-tight">
                Invalid Protocol
            </h1>
            <p class="font-display text-xs text-[#666] uppercase tracking-[0.2em] mb-8">
                ERROR_405 // METHOD_NOT_ALLOWED
            </p>

            <div class="max-w-md mx-auto bg-white/5 border border-white/10 p-6 rounded-sm mb-8">
                <p class="text-sm text-[#888] font-display leading-relaxed">
                    The action you attempted is not compatible with this resource endpoint.
                    <br><span class="text-[#555] text-xs mt-2 block">(e.g., Attempting GET on a POST route)</span>
                </p>
            </div>

            <a href="{{ url('/') }}"
                class="group inline-flex items-center gap-2 text-white hover:text-accent transition-colors">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    class="group-hover:-translate-x-1 transition-transform">
                    <path d="m12 19-7-7 7-7" />
                    <path d="M19 12H5" />
                </svg>
                <span
                    class="font-display text-xs uppercase tracking-widest border-b border-transparent group-hover:border-accent pb-0.5">Return
                    to Base</span>
            </a>
        </div>

    </div>
@endsection
