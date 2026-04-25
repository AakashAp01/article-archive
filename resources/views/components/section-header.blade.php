@props([
    'title',
    'subtitle' => null,
])

<div {{ $attributes->merge(['class' => 'border-b border-white/10 pb-2 mb-2']) }}>
    <h2 class="text-sm font-bold text-[#888] uppercase tracking-widest mb-1">{{ $title }}</h2>
    @if($subtitle)
        <p class="text-[10px] text-[#666] uppercase tracking-widest font-display">{{ $subtitle }}</p>
    @endif
</div>
