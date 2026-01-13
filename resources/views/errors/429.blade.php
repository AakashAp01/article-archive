@extends('layout.error')
@section('title', '429 Too Many Requests')
@section('content')
    <div class="bg-bg text-white h-screen flex flex-col items-center justify-center relative overflow-hidden">

        {{-- Progress Bar for Cooldown --}}
        <div class="absolute top-0 left-0 w-full h-1 bg-white/5">
            <div class="h-full bg-danger w-full animate-[shrink_60s_linear_forwards]"></div>
        </div>

        <div class="relative z-10 text-center px-6 max-w-md">
            <div class="font-display text-danger text-sm tracking-[0.2em] mb-4">
                TRAFFIC_ANOMALY
            </div>

            <h1 class="text-3xl text-white font-light mb-6">
                Rate Limit Exceeded
            </h1>

            <div class="bg-white/5 border border-white/10 p-6 rounded-sm mb-8">
                <p class="text-xs text-[#888] font-display leading-relaxed">
                    Your request frequency exceeds safety parameters. To preserve grid stability, your connection has been
                    temporarily throttled.
                </p>
            </div>

            <p class="text-[10px] text-[#444] font-display uppercase">
                // Please wait for system cooldown...
            </p>
        </div>

        <style>
            @keyframes shrink {
                from {
                    width: 100%;
                }

                to {
                    width: 0%;
                }
            }
        </style>

    </div>
@endsection
