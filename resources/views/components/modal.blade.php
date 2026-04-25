@props([
    'id',
    'title' => null,
    'subtitle' => null,
    'variant' => 'default', 
])

@php
    $borderClass = $variant === 'danger' ? 'border-red-500/30' : 'border-white/10';
    $cornerClass = $variant === 'danger' ? 'border-red-500' : 'border-accent';
    $glowClass = $variant === 'danger' ? 'shadow-[0_0_30px_rgba(255,0,0,0.1)]' : 'shadow-2xl';
@endphp

<div id="{{ $id }}" class="fixed inset-0 z-50 flex items-center justify-center {{ $attributes->get('class') }}" 
    @if($attributes->has('wire:model')) wire:model="{{ $attributes->get('wire:model') }}" @endif>
    
    <div class="absolute inset-0 bg-black/80 backdrop-blur-sm" {{ $attributes->whereStartsWith('wire:click') }}></div>
    
    <div class="relative w-full max-w-lg p-8 bg-[#0a0a0a] border {{ $borderClass }} {{ $glowClass }} z-10">
        
        <button {{ $attributes->whereStartsWith('wire:click') }} class="absolute top-4 right-4 text-[#666] hover:text-white transition-colors">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M18 6L6 18M6 6l12 12" />
            </svg>
        </button>

        @if($title || $subtitle)
            <div class="mb-6">
                @if($title)
                    <h2 class="text-xl text-white font-light">{{ $title }}</h2>
                @endif
                @if($subtitle)
                    <p class="text-[10px] text-[#666] uppercase tracking-widest font-mono mt-1">{{ $subtitle }}</p>
                @endif
            </div>
        @endif

        <div class="space-y-6">
            {{ $slot }}
        </div>

        <div class="absolute top-0 left-0 w-3 h-3 border-l border-t {{ $cornerClass }}"></div>
        <div class="absolute bottom-0 right-0 w-3 h-3 border-r border-b {{ $cornerClass }}"></div>
    </div>
</div>
