@props(['comment', 'replyingTo'])

<div class="group/item animate-fade-in" wire:key="comment-{{ $comment->id }}">

    {{-- 1. Comment Content --}}
    <div class="flex items-start gap-3 mb-2">
        {{-- Avatar --}}
        <div class="w-8 h-8 shrink-0 rounded-full overflow-hidden border border-white/10 bg-gradient-to-br from-gray-800 to-black flex items-center justify-center text-xs font-bold text-gray-400">
            @if ($comment->user->avatar)
                <img src="{{$comment->user->avatar }}" alt="{{ $comment->user->name }}" class="w-full h-full object-cover">
            @else
                {{ strtoupper(substr($comment->user->name, 0, 2)) }}
            @endif
        </div>

        <div class="flex-1">
            {{-- Header --}}
            <div class="flex items-baseline gap-2">
                <span class="text-sm text-gray-200 font-bold tracking-wide">{{ $comment->user->name }}</span>
                <span class="text-[13px] text-[#555] ">{{ $comment->created_at->diffForHumans() }}</span>
            </div>

            {{-- Body --}}
            <p class="text-sm text-[#888] leading-relaxed font-semibold mt-1">
                {{ $comment->body }}
            </p>

            {{-- Reply Trigger Button --}}
            @auth
                <button wire:click="setReplyingTo({{ $comment->id }})"
                    class="mt-3 text-xs  text-[#444] hover:text-accent-dynamic transition-colors flex items-center gap-1 font-bold">
                    
                    Reply
                </button>
            @endauth
        </div>
    </div>

    {{-- 2. Reply Form (Shows only if this specific comment is being replied to) --}}
    @if ($replyingTo === $comment->id)
        <div class="mt-3 ml-11 mb-6 animate-fade-in">
            <textarea wire:model="replyBody"
                class="w-full bg-[#0a0a0a] border border-white/10 rounded p-4 text-sm text-white focus:outline-none focus:border-accent-dynamic resize-none placeholder-white/20"
                rows="3" placeholder="Write your reply..."></textarea>
            @error('replyBody')
                <span class="text-red-500 text-xs text-end mb-1 block">{{ $message }}</span>
            @enderror
            <div class="flex gap-3">
                {{-- BIGGER REPLY BUTTON --}}
                <button wire:click="postReply({{ $comment->id }})"
                    class="px-6 py-1 bg-accent-dynamic text-black text-xs transition-colors tracking-wider">
                    Reply
                </button>
                
                {{-- MATCHING CANCEL BUTTON --}}
                <button wire:click="cancelReply"
                    class="px-6 py-1 bg-red-500/10 border border-red-500/30 text-red-500 text-xs  hover:bg-red-500 hover:text-white transition-all tracking-wider">
                    Cancel
                </button>
            </div>
            
        </div>
    @endif

    {{-- 3. RECURSIVE CHILDREN LOOP --}}
    @if ($comment->replies->count() > 0)
        <div class="ml-4 pl-4 border-l border-white/10 mt-3 space-y-4">
            @foreach ($comment->replies as $reply)
                <x-comment-item :comment="$reply" :replyingTo="$replyingTo" />
            @endforeach
        </div>
    @endif
</div>