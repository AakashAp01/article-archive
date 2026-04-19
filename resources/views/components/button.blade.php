@props([
    'variant' => 'primary', // primary, secondary, outline, danger, accent-outline
    'type' => 'button',     // button, submit, a
    'href' => null,
])

@php
    $baseClasses = 'group flex items-center justify-center gap-3 transition-all font-display uppercase tracking-widest text-xs px-6 py-3';
    
    $variants = [
        'primary' => 'bg-white text-black hover:bg-accent',
        'secondary' => 'bg-white/5 border border-white/20 text-white hover:border-accent hover:bg-accent/10',
        'outline' => 'border border-white/10 text-[#666] hover:bg-white/5 hover:text-white',
        'danger' => 'bg-red-500/10 border border-red-500/50 text-red-500 hover:bg-red-500 hover:text-white',
        'accent-outline' => 'border border-accent/20 bg-accent/5 text-accent hover:bg-accent hover:text-black',
    ];

    $classes = $baseClasses . ' ' . ($variants[$variant] ?? $variants['primary']);
@endphp

@if ($type === 'a')
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </button>
@endif
