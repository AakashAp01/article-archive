@props([
    'title',
    'subtitle' => null,
])

<header {{ $attributes->merge(['class' => 'mb-8 border-b border-white/10 pb-6']) }}>
    <h1 class="text-2xl md:text-3xl font-bold text-white mb-2">{{ $title }}</h1>
    
    @if($subtitle)
        <p class="text-[#666] text-xs uppercase tracking-widest font-display">{{ $subtitle }}</p>
    @endif
</header>
