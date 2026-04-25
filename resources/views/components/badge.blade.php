@props([
    'variant' => 'default', 
    'text' => null,
])

@php
    $variants = [
        'default' => 'border-white/10 text-[#888] bg-white/5',
        'success' => 'border-accent/50 text-accent bg-accent/10',
        'danger' => 'border-red-500/50 text-red-500 bg-red-500/10',
        'warning' => 'border-yellow-500/50 text-yellow-500 bg-yellow-500/10',
        'blue' => 'border-blue-500/30 text-blue-400 bg-blue-500/5',
        'purple' => 'border-purple-500/50 text-purple-400 bg-purple-500/10',
    ];

    $classes = 'px-3 py-1 text-[10px] uppercase tracking-widest border font-display ' . ($variants[$variant] ?? $variants['default']);
@endphp

<span {{ $attributes->merge(['class' => $classes]) }}>
    {{ $text ?? $slot }}
</span>
