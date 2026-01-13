@props([
    'title',
    'count',
    'href' => null,
    'color' => 'blue',
    'progress' => 50
])

@php
    $Tag = $href ? 'a' : 'div';
@endphp

<{{ $Tag }}
    @if($href) href="{{ $href }}" @endif
    class="block bg-white/5 border border-white/10 p-6 rounded-sm group
           hover:border-{{ $color }}-500 hover:bg-white/[0.07]
           transition-all cursor-pointer">

    <div class="flex justify-between items-start mb-4">
        <div>
            <p class="text-[10px] text-[#888] uppercase tracking-widest mb-1">
                {{ $title }}
            </p>
            <h3 class="text-3xl text-white font-light">
                {{ number_format($count) }}
            </h3>
        </div>

        <div class="p-2 bg-{{ $color }}-500/10 rounded-sm text-{{ $color }}-400 group-hover:text-{{ $color }}-300">
            {{ $icon }}
        </div>
    </div>

    <div class="w-full bg-white/10 h-1 mt-2">
        <div
            class="bg-{{ $color }}-500 h-1 transition-all group-hover:w-full"
            style="width: {{ $progress }}%">
        </div>
    </div>
</{{ $Tag }}>
