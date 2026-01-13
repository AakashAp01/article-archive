<div x-data="{
    commentsOpen: false,
    reportModalOpen: false
}" @close-report-modal.window="reportModalOpen = false">

<div class="my-5 py-8 border border-white/5 bg-white/[0.02]">
    <div class="flex flex-col items-center justify-center gap-5">
        <h3 class="text-[10px] uppercase tracking-widest text-[#666]">End of Article</h3>

        <div class="flex flex-wrap justify-center gap-3">

            {{-- Like Button --}}
            <button wire:click="toggleLike"
                class="group relative flex items-center gap-2 px-4 py-2  border border-white/10 hover:border-red-500/50 hover:bg-red-500/5 transition-all">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="{{ $isLiked ? 'currentColor' : 'none' }}"
                    stroke="currentColor" stroke-width="2"
                    class="{{ $isLiked ? 'text-red-500' : 'text-[#666]' }} group-hover:text-red-500 transition-colors">
                    <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                </svg>
                <span class="font-display text-xs uppercase tracking-wider text-gray-300">{{ $isLiked ? 'Liked' : 'Like' }}</span>
            </button>

            {{-- Save Button --}}
            <button wire:click="toggleSave"
                class="group relative flex items-center gap-2 px-4 py-2  border border-white/10 hover:border-blue-500/50 hover:bg-blue-500/5 transition-all">
                <svg width="14" height="14" viewBox="0 0 24 24"
                    fill="{{ $isSaved ? 'currentColor' : 'none' }}" stroke="currentColor" stroke-width="2"
                    class="{{ $isSaved ? 'text-blue-500' : 'text-[#666]' }} group-hover:text-blue-500 transition-colors">
                    <path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"></path>
                </svg>
                <span class="font-display text-xs uppercase tracking-wider text-gray-300">{{ $isSaved ? 'Saved' : 'Save' }}</span>
            </button>

            {{-- Discuss Button --}}
            <button
                @click="commentsOpen = !commentsOpen; if(commentsOpen) $nextTick(() => $el.scrollIntoView({ behavior: 'smooth' }))"
                class="group relative flex items-center gap-2 px-4 py-2  border border-white/10 hover:border-white/30 hover:bg-white/5 transition-all">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" class="text-[#666] group-hover:text-white transition-colors">
                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                </svg>
                <span class="font-display text-xs uppercase tracking-wider text-gray-300">Discuss</span>
                @if ($commentsCount > 0)
                    <span class="flex items-center justify-center h-4 px-1.5  bg-white/10 text-[9px] font-bold text-white group-hover:bg-white/20 transition-colors">
                        {{ $commentsCount }}
                    </span>
                @endif
            </button>

            {{-- Share Button --}}
            <button onclick="nativeShare()"
                class="group relative flex items-center gap-2 px-4 py-2  border border-white/10 hover:border-[var(--accent)] hover:bg-white/5 transition-all">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" class="text-[#666] group-hover:text-[var(--accent)] transition-colors">
                    <circle cx="18" cy="5" r="3"></circle>
                    <circle cx="6" cy="12" r="3"></circle>
                    <circle cx="18" cy="19" r="3"></circle>
                    <line x1="8.59" y1="13.51" x2="15.42" y2="17.49"></line>
                    <line x1="15.41" y1="6.51" x2="8.59" y2="10.49"></line>
                </svg>
                <span class="font-display text-xs uppercase tracking-wider text-gray-300">Share</span>
            </button>

            {{-- Report Button --}}
            <button @click="reportModalOpen = true"
                class="group relative flex items-center gap-2 px-4 py-2  border border-white/10 hover:border-yellow-500/50 hover:bg-yellow-500/5 transition-all">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" class="text-[#666] group-hover:text-yellow-500 transition-colors">
                    <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path>
                    <line x1="12" y1="9" x2="12" y2="13"></line>
                    <line x1="12" y1="17" x2="12.01" y2="17"></line>
                </svg>
                <span class="font-display text-xs uppercase tracking-wider text-gray-300">Report</span>
            </button>

        </div>
    </div>
</div>
    {{-- 2. REPORT MODAL --}}
    <div x-show="reportModalOpen" style="display: none;"
        class="fixed inset-0 z-[100] flex items-center justify-center p-4"
        x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">

        {{-- Backdrop --}}
        <div class="absolute inset-0 bg-black/90 backdrop-blur-sm" @click="reportModalOpen = false"></div>

        {{-- Modal Content --}}
        <div class="relative w-full max-w-md bg-[#0a0a0f] p-8 shadow-2xl overflow-hidden"
            @click.stop>

            {{-- Technical Decor Lines --}}
            <div class="absolute top-0 left-0 w-2 h-2 border-l border-t border-yellow-500"></div>
            <div class="absolute bottom-0 right-0 w-2 h-2 border-r border-b border-yellow-500"></div>

            <div class="text-center relative z-10">
                {{-- Warning Icon (Animated) --}}
                <div
                    class="mx-auto w-16 h-16 border border-yellow-500/20  flex items-center justify-center mb-6 bg-yellow-500/5 relative">
                    <div class="absolute inset-0  border border-yellow-500/20 animate-ping opacity-20">
                    </div>
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="1.5" class="text-yellow-500">
                        <path
                            d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z">
                        </path>
                        <line x1="12" y1="9" x2="12" y2="13"></line>
                        <line x1="12" y1="17" x2="12.01" y2="17"></line>
                    </svg>
                </div>

                <h3 class="text-xl text-white font-light mb-2 tracking-tight">Report Content</h3>

                <div class="mb-8">
                    <p class="text-sm text-[#888] font-light mb-4 leading-relaxed">
                        Identify the interference pattern detected in this article.
                    </p>

                    {{-- Styled Select Input --}}
                    <div class="relative group text-left">
                        <select wire:model="reportReason"
                            class="w-full bg-[#050505] border border-white/10 text-sm text-gray-300 p-3 pr-10 focus:border-yellow-500/50 focus:outline-none focus:bg-white/[0.02] transition-colors appearance-none font-light cursor-pointer">
                            <option class="bg-[#050505]" value="" disabled selected>Select a reason...</option>
                            <option class="bg-[#050505]" value="spam">Spam or Misleading</option>
                            <option class="bg-[#050505]" value="harassment">Harassment or Hate Speech</option>
                            <option class="bg-[#050505]" value="misinformation">Factually Incorrect</option>
                            <option class="bg-[#050505]" value="other">Other Issue</option>
                        </select>

                        {{-- Custom Chevron --}}
                        <div
                            class="absolute right-3 top-3.5 pointer-events-none text-[#666] group-hover:text-white transition-colors">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2">
                                <path d="M6 9l6 6 6-6" />
                            </svg>
                        </div>
                    </div>

                    @error('reportReason')
                        <span
                            class="text-red-500 text-start text-[10px] font-[Courier] uppercase mt-2 block tracking-wider">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Action Buttons --}}
                <div class="flex gap-4">
                    <button type="button" @click="reportModalOpen = false"
                        class="flex-1 py-3 border border-white/10 text-[#666] text-xs font-[Courier] uppercase tracking-widest hover:bg-white/5 hover:text-white transition-colors">
                        Cancel
                    </button>

                    <button type="button" wire:click="report" wire:loading.attr="disabled"
                        class="flex-1 py-3 bg-yellow-500/10 border border-yellow-500/50 text-yellow-500 text-xs font-[Courier] uppercase tracking-widest hover:bg-yellow-500 hover:text-black transition-all disabled:opacity-50 disabled:cursor-not-allowed">
                        <span wire:loading.remove wire:target="report">Proceed</span>
                        <span wire:loading wire:target="report">Sending...</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- 3. COMMENT SECTION --}}
    <div x-show="commentsOpen" x-transition.duration.500ms class="mt-5 pt-5 border-t border-white/10">

        {{-- Main Comment Input (Root Level) --}}
        @auth
            <div class="mb-12 bg-white/[0.02] p-6  border border-white/5">
                <label class="text-sm font-semibold text-[#666] tracking-widest mb-4 block">Leave a
                    comment</label>
                <textarea wire:model="body" placeholder="Share your thoughts..."
                    class="w-full bg-[#0a0a0a] border border-white/10  p-4 text-sm text-white focus:outline-none focus:border-accent-dynamic transition-colors resize-none h-32 placeholder-gray-600 font-light"></textarea>
                <div>
                    @error('body')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>

                <div class="flex justify-end items-center mt-4">
                    <button wire:click="postComment"
                        class="px-5 py-2.5 border border-accent-dynamic text-accent-dynamic hover:bg-accent-dynamic hover:text-black text-xs tracking-widest transition-all font-bold disabled:opacity-50">
                        <span wire:loading.remove wire:target="postComment">Comment</span>
                        <span wire:loading wire:target="postComment">Posting...</span>
                    </button>
                </div>
            </div>
        @else
            <div class="mb-12 bg-white/[0.02] p-6  border border-white/5 text-center">
                <p class="text-[#888] text-sm">Please <a href="{{ route('login') }}"
                        class="text-accent-dynamic underline">login</a> to participate.</p>
            </div>
        @endauth

        {{-- RECURSIVE LIST START --}}
        <div class="space-y-5">
            @forelse($comments as $comment)
                {{-- We pass 'replyingTo' so the child knows when to open its form --}}
                <x-comment-item :comment="$comment" :replyingTo="$replyingTo" />
            @empty
                <p class="text-[#666] italic text-sm text-center">No signals detected yet. Be the first to transmit.
                </p>
            @endforelse
        </div>

    </div>

    <script>
        document.addEventListener('livewire:initialized', () => {
            @this.on('article-reported', () => {
                alert('Article flagged. Administrators will review the content.');
            });
        });

        // Native share function (kept from previous code)
        function nativeShare() {
            if (navigator.share) {
                navigator.share({
                    title: '{{ $article->title }}',
                    text: 'Check out this article',
                    url: window.location.href,
                }).catch(console.error);
            } else {
                navigator.clipboard.writeText(window.location.href);
                alert('Link copied to clipboard!');
            }
        }
    </script>
</div>
