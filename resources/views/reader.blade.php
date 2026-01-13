@extends('layout.app')
@section('title', $article->title)

@section('content')
    {{-- 1. PREPARE COLOR VARIABLES --}}
    @php
        $hex = $article->category->color_code ?? '#00ff88';
        // Convert Hex to RGB for opacity support
        [$r, $g, $b] = sscanf($hex, '#%02x%02x%02x');
        $accentColor = "$r, $g, $b";
    @endphp

    <style>
        /* Define the Dynamic Color Variable */
        :root {
            --accent: {{ $hex }};
            --accent-rgb: {{ $accentColor }};
        }

        /* Utility Classes for Dynamic Colors */
        .text-accent-dynamic {
            color: var(--accent) !important;
        }

        .bg-accent-dynamic {
            background-color: var(--accent) !important;
        }

        .border-accent-dynamic {
            border-color: var(--accent) !important;
        }

        .hover\:text-accent-dynamic:hover {
            color: var(--accent) !important;
        }

        /* Group Hovers */
        .group:hover .group-hover\:text-accent-dynamic {
            color: var(--accent) !important;
        }

        .group:hover .group-hover\:border-accent-dynamic {
            border-color: var(--accent) !important;
        }

        .group:hover .group-hover\:bg-accent-dynamic {
            background-color: rgba(var(--accent-rgb), 0.3) !important;
        }

        /* Custom Scrollbar Hide */
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        /* Typography & Markdown Overrides */
        .prose {
            max-width: 100%;
        }

        .prose p {
            margin-bottom: 1.5rem;
            line-height: 1.8;
            color: #a0a0a0;
        }

        /* H2 now uses the dynamic variable for the left border */
        .prose h2 {
            color: white;
            font-size: 1.8rem;
            margin-top: 4rem;
            margin-bottom: 1.5rem;
            font-weight: 300;
            letter-spacing: -0.02em;
            border-left: 2px solid var(--accent);
            padding-left: 1rem;
        }

        .prose h3 {
            color: #e0e0e0;
            font-size: 1.4rem;
            margin-top: 2.5rem;
            margin-bottom: 1rem;
            font-weight: 400;
        }

        .prose ul {
            list-style-type: disc;
            padding-left: 1.5rem;
            color: #888;
            margin-bottom: 1.5rem;
        }

        .prose strong {
            color: #fff;
            font-weight: 600;
        }

        .prose a {
            color: var(--accent);
            text-decoration: underline;
            text-underline-offset: 4px;
        }

        .prose blockquote {
            border-left-color: #333;
            color: #666;
            font-style: italic;
        }

        .prose img {
            border-radius: 4px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            margin: 2rem 0;
        }

        .prose pre {
            background: #050508;
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 4px;
            padding: 1.5rem;
            overflow-x: auto;
        }

        .prose code {
            color: var(--accent);
            font-family: 'Courier New', monospace;
            font-size: 0.9em;
        }

        .prose pre code {
            color: inherit;
            background: transparent;
            padding: 0;
        }

        /* Comment Drawer & Interaction Animations */
        .drawer-backdrop {
            background-color: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(4px);
        }

        .slide-over {
            transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }

        @keyframes heart-burst {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.3);
            }

            100% {
                transform: scale(1);
            }
        }

        .animate-heart {
            animation: heart-burst 0.3s ease-in-out;
        }
    </style>

    {{-- Progress Bar --}}
    <div class="fixed top-0 left-0 w-full h-1 bg-white/5 z-[100]">
        <div id="progress-bar" class="h-full w-0 transition-all duration-100 ease-out"
            style="background-color: var(--accent);"></div>
    </div>

    <div class="max-w-7xl mx-auto px-6 py-20 md:py-32 flex flex-col lg:flex-row gap-16 relative pb-15 lg:pb-15">

        {{-- SIDEBAR (Desktop Only) --}}
        <aside class="hidden lg:block w-64 shrink-0 order-1">
            <div class="sticky top-32">
                {{-- TABLE OF CONTENTS --}}
                <h3 class="text-sm font-bold text-[#888] uppercase tracking-widest mb-6 border-b border-white/10 pb-4">
                    Table of Contents</h3>
                <ul class="space-y-4 border-l border-white/5 pl-6" id="toc-list">
                    {{-- Javascript populates this --}}
                </ul>

                {{-- TAGS --}}
                <div class="mt-3 pt-3 border-t border-white/10 border-dashed">
                    <div class="flex flex-wrap gap-2">
                        @if (isset($article->tags) && is_array($article->tags))
                            @foreach ($article->tags as $tag)
                                <span
                                    class="px-3 py-1 bg-white/5 text-[10px] text-[#888] border border-white/5 uppercase font-display hover:text-white transition-colors cursor-default"
                                    style="border-color: rgba({{ $accentColor }}, 0.1);"
                                    onmouseover="this.style.borderColor='var(--accent)'; this.style.color='white';"
                                    onmouseout="this.style.borderColor='rgba({{ $accentColor }}, 0.1)'; this.style.color='#888';">
                                    #{{ $tag }}
                                </span>
                            @endforeach
                        @endif
                    </div>
                </div>

                {{-- DESKTOP RECOMMENDATIONS --}}
                <div class="mt-10">
                    <h4
                        class="text-sm font-bold text-[#888] uppercase tracking-widest mb-6 border-b border-white/10 pb-4">
                        Recommended</h4>
                    <ul class="space-y-5">
                        @forelse ($recommendedArticles as $rec)
                            <li class="group flex items-start gap-3">
                                <span
                                    class="mt-1.5 w-1.5 h-1.5 rounded-full transition-all duration-300 shrink-0 group-hover:shadow-[0_0_8px_var(--accent)]"
                                    style="background-color: rgba({{ $accentColor }}, 0.3);"
                                    onmouseover="this.style.backgroundColor='var(--accent)'"
                                    onmouseout="this.style.backgroundColor='rgba({{ $accentColor }}, 0.3)'"></span>
                                <div class="flex flex-col">
                                    <a href="{{ route('article.show', $rec->slug) }}"
                                        class="text-sm text-[#666] group-hover:text-white transition-colors leading-snug font-semibold">{{ $rec->title }}</a>
                                    <span
                                        class="text-[10px] text-[#444] mt-1 transition-colors group-hover:text-accent-dynamic">{{ $rec->date->format('M d') }}</span>
                                </div>
                            </li>
                        @empty
                            <li class="text-xs text-[#444] font-display italic pl-4 border-l border-white/5">No related
                                transmissions.</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </aside>

        {{-- MAIN CONTENT --}}
        <main class="flex-1 min-w-0 order-2">

            @if ($article->thumbnail)
                <div class="mb-6 w-100 h-[400px] overflow-hidden rounded-lg shadow-lg">
                    <img src="{{ $article->thumbnail }}" alt="{{ $article->title }}" class="w-full h-full object-cover">
                </div>
            @endif

            <header class="mb-10 border-b border-white/10 pb-8">
                {{-- Meta Data --}}
                <div class=" text-xs mb-6 flex flex-wrap items-center gap-6 uppercase text-accent-dynamic">
                    <span class="flex items-center gap-2">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="text-[{{ $accentColor }}]">
                            <path d="M3 7h5l2 3h11v9H3z"></path>
                            <path d="M3 7V5h6l2 2h10v3"></path>
                        </svg>
                        {{ $article->category->name ?? 'Uncategorized' }}
                    </span>
                    <span class="flex items-center gap-2">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <rect width="18" height="18" x="3" y="4" rx="2" ry="2" />
                            <line x1="16" x2="16" y1="2" y2="6" />
                            <line x1="8" x2="8" y1="2" y2="6" />
                            <line x1="3" x2="21" y1="10" y2="10" />
                        </svg>
                        {{ $article->date->format('M d, Y') }}
                    </span>
                    <span class="flex items-center gap-2">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <circle cx="12" cy="12" r="10" />
                            <polyline points="12 6 12 12 16 14" />
                        </svg>
                        {{ ceil(str_word_count(strip_tags($article->content)) / 200) }} min read
                    </span>
                </div>

                <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold mb-8">
                    {{ $article->title }}</h1>
                <p class="text-xl md:text-2xl text-[#888] font-semibold leading-relaxed pl-6 italic"
                    style="border-left: 2px solid var(--accent);">{{ $article->excerpt }}</p>
            </header>

            {{-- Article Content --}}
            <article id="article-content" class="prose prose-invert prose-lg max-w-none">
                {!! \Illuminate\Support\Str::markdown($article->content) !!}
            </article>

            @livewire('article-interactions', ['article' => $article])

            {{-- FOOTER NAVIGATION --}}
            <div class="border-t border-white/10 pt-5 mt-4 flex flex-col md:flex-row gap-6">
                {{-- Previous --}}
                <a href="{{ route('dashboard') }}"
                    class="group flex-1 flex items-center gap-4 p-4 border border-white/10 hover:border-white/30 hover:bg-white/5 transition-all">
                    <div
                        class="w-10 h-10 shrink-0 rounded-full border border-white/20 flex items-center justify-center group-hover:border-accent-dynamic group-hover:text-accent-dynamic transition-colors bg-black">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path d="m15 18-6-6 6-6" />
                        </svg>
                    </div>
                    <div class="flex flex-col">
                        <span class=" text-[10px] text-[#666] uppercase tracking-widest">Return</span>
                        <span class="text-sm font-medium text-gray-300 group-hover:text-white">Index / Archive</span>
                    </div>
                </a>
                {{-- Next --}}
                @if ($nextRead)
                    <a href="{{ route('article.show', $nextRead->slug) }}"
                        class="group flex-1 flex items-center justify-between md:justify-end gap-4 p-4 border border-white/10 hover:border-accent-dynamic hover:bg-white/5 transition-all text-right">
                        <div class="flex flex-col items-start md:items-end">
                            <span class=" text-[10px] text-[#666] uppercase tracking-widest">Next Read</span>
                            <span
                                class="text-sm font-medium text-gray-300 group-hover:text-white line-clamp-1">{{ $nextRead->title }}</span>
                        </div>
                        <div
                            class="w-10 h-10 shrink-0 rounded-full border border-white/20 flex items-center justify-center group-hover:border-accent-dynamic group-hover:text-accent-dynamic transition-colors bg-black">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2">
                                <path d="m9 6 6 6-6 6" />
                            </svg>
                        </div>
                    </a>
                @endif
            </div>

        </main>
    </div>


    <script>
        document.addEventListener('DOMContentLoaded', () => {
            if (typeof hljs !== 'undefined') hljs.highlightAll();

            // 1. Dynamic Table of Contents
            const articleContent = document.getElementById('article-content');
            const tocList = document.getElementById('toc-list');
            const headers = articleContent.querySelectorAll('h2');

            if (headers.length === 0) {
                tocList.innerHTML =
                    '<li class="text-xs text-[#444] font-display italic">No subsections found.</li>';
            }

            headers.forEach((header, index) => {
                const anchorId = 'section-' + index;
                header.id = anchorId;
                header.classList.add('section-observe', 'scroll-mt-32');
                const num = (index + 1).toString().padStart(2, '0');
                const li = document.createElement('li');
                li.className = 'group relative toc-item';
                li.setAttribute('data-target', anchorId);
                li.innerHTML = `
                    <span class="indicator absolute -left-[27px] top-1.5 w-1.5 h-1.5 rounded-full opacity-0 transition-opacity bg-accent-dynamic"></span>
                    <a href="#${anchorId}" class="text-sm text-[#666] hover:text-accent-dynamic transition-colors text-left font-semibold block">
                        <span class="text-accent-dynamic opacity-50 mr-2 text-xs ">${num}</span> ${header.innerText}
                    </a>`;
                tocList.appendChild(li);
            });

            // 2. Scroll Progress Bar
            window.addEventListener('scroll', () => {
                const scrollTop = window.scrollY;
                const docHeight = document.body.scrollHeight - window.innerHeight;
                document.getElementById('progress-bar').style.width = ((scrollTop / docHeight) * 100) + '%';
            });

            // 3. TOC Observer
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        document.querySelectorAll('.toc-item .indicator').forEach(el => el.classList
                            .remove('opacity-100'));
                        document.querySelectorAll('.toc-item a').forEach(el => el.classList.remove(
                            'text-accent-dynamic'));
                        const id = entry.target.getAttribute('id');
                        const activeItem = document.querySelector(`.toc-item[data-target="${id}"]`);
                        if (activeItem) {
                            activeItem.querySelector('.indicator').classList.add('opacity-100');
                            activeItem.querySelector('a').classList.add('text-accent-dynamic');
                        }
                    }
                });
            }, {
                root: null,
                rootMargin: '-20% 0px -60% 0px',
                threshold: 0
            });
            headers.forEach(section => observer.observe(section));
        });

        // 4. Helper Functions (Global Scope)

        // UPDATED: Toggle Static Comment Section
        function toggleComments() {
            const wrapper = document.getElementById('comments-wrapper');

            if (wrapper.classList.contains('hidden')) {
                // Show
                wrapper.classList.remove('hidden');
                // Smooth scroll to the comments
                setTimeout(() => {
                    wrapper.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }, 100);
            } else {
                // Hide
                wrapper.classList.add('hidden');
            }
        }

        function copyToClipboard(btn) {
            const url = btn.getAttribute('data-url');
            navigator.clipboard.writeText(url).then(() => {
                const tooltip = btn.querySelector('#copy-tooltip');
                tooltip.classList.remove('opacity-0');
                setTimeout(() => tooltip.classList.add('opacity-0'), 2000);
            });
        }

        function toggleLike(btn) {
            const icons = document.querySelectorAll('.like-icon');
            icons.forEach(icon => {
                if (icon.getAttribute('fill') === 'none') {
                    icon.setAttribute('fill', 'currentColor');
                    icon.classList.remove('text-[#666]', 'text-[#888]');
                    icon.classList.add('text-red-500', 'animate-heart');
                } else {
                    icon.setAttribute('fill', 'none');
                    icon.classList.add('text-[#666]');
                    icon.classList.remove('text-red-500', 'animate-heart');
                }
            });
        }

        function nativeShare() {
            if (navigator.share) {
                navigator.share({
                    title: '{{ $article->title }}',
                    text: 'Check out this article: {{ $article->excerpt }}',
                    url: '{{ url()->current() }}',
                }).catch(console.error);
            } else {
                navigator.clipboard.writeText('{{ url()->current() }}');
                alert('Link copied to clipboard!');
            }
        }

        // NEW: Report Function
        function reportArticle() {
            if (confirm('Do you want to report this article for inappropriate content?')) {
                // Add your backend logic here
                alert('Thank you. We have received your report and will review it shortly.');
            }
        }
    </script>
@endsection
