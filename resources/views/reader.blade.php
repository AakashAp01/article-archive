@extends('layout.app')
@section('title', $article->title)
@section('seo_description', $article->excerpt ?? Str::limit(strip_tags($article->content), 160))
@php
    $tags = $article->tags;

    if (is_string($tags)) {
        $tags = json_decode($tags, true);
    }

    $tags = is_array($tags) ? $tags : [];
@endphp

@section('keywords', implode(', ', $tags))
@section('og_type', 'article')
@section('og_title', $article->title)
@section('og_description', $article->excerpt ?? Str::limit(strip_tags($article->content), 160))
@section('og_image', $article->thumbnail)
@section('og_url', url()->current())

@section('content')
    @php
        $hex = $article->category->color_code ?? '#00ff88';
        [$r, $g, $b] = sscanf($hex, '#%02x%02x%02x');
        $accentColor = "$r, $g, $b";
    @endphp

    <style>
        :root {
            --accent: {{ $hex }};
            --accent-rgb: {{ $accentColor }};
        }

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

        .group:hover .group-hover\:text-accent-dynamic {
            color: var(--accent) !important;
        }

        .group:hover .group-hover\:border-accent-dynamic {
            border-color: var(--accent) !important;
        }

        .group:hover .group-hover\:bg-accent-dynamic {
            background-color: rgba(var(--accent-rgb), 0.3) !important;
        }

        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        .prose {
            max-width: 100%;
        }

        .prose p {
            margin-bottom: 1.5rem;
            line-height: 1.8;
            color: #a0a0a0;
        }

        .prose h2 {
            color: white;
            font-size: 2rem;
            margin-top: 4.5rem;
            margin-bottom: 2rem;
            font-weight: 300;
            letter-spacing: -0.03em;
            border-left: 2px solid var(--accent);
            padding-left: 1.25rem;
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

    <div class="fixed top-0 left-0 w-full h-1 bg-white/5 z-[100]">
        <div id="progress-bar" class="h-full w-0 transition-all duration-100 ease-out"
            style="background-color: var(--accent);"></div>
    </div>

    <div class="max-w-7xl mx-auto px-6 py-20 md:py-32 flex flex-col lg:flex-row gap-16 relative pb-15 lg:pb-15">

        <aside class="hidden lg:block w-64 shrink-0 order-1">
            <div class="sticky top-32">
                <x-section-header title="Table of Contents" />
                <ul class="space-y-4 border-l border-white/5 pl-6" id="toc-list">
                </ul>

                @if (isset($article->tags) && is_array($article->tags))
                    <div class="mt-3 pt-3 border-t border-white/10 border-dashed">
                        <div class="flex flex-wrap gap-2">
                            @foreach ($article->tags as $tag)
                                <x-badge :text="'#' . $tag" class="cursor-default hover:text-white transition-colors"
                                    style="border-color: rgba({{ $accentColor }}, 0.1);"
                                    onmouseover="this.style.borderColor='var(--accent)'; this.style.color='white';"
                                    onmouseout="this.style.borderColor='rgba({{ $accentColor }}, 0.1)'; this.style.color='#888';" />
                            @endforeach
                        </div>
                    </div>
                @endif

                <div class="mt-10">
                    <x-section-header title="Recommended" />
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
                                        class="text-[13px] text-[#555] mt-1 transition-colors group-hover:text-accent-dynamic">{{ $rec->date->format('M d') }}</span>
                                </div>
                            </li>
                        @empty
                            <li class="text-xs text-[#444] font-display italic pl-4 border-l border-white/5">No related
                                articles.</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </aside>

        <main class="flex-1 min-w-0 order-2">

            @if ($article->thumbnail)
                <div class="mb-6 w-100 h-[400px] overflow-hidden rounded-lg shadow-lg">
                    <img src="{{ $article->thumbnail }}" alt="{{ $article->title }}" class="w-full h-full object-cover">
                </div>
            @endif

            <article>
                <header class="mb-10 border-b border-white/10 pb-8">
                    <div class=" text-xs mb-6 flex flex-wrap items-center gap-6 uppercase text-accent-dynamic">
                        <span class="flex items-center gap-2">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
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

                    <h1
                        class="text-3xl md:text-4xl lg:text-5xl font-bold mb-10 tracking-tight leading-tight uppercase font-display">
                        {{ $article->title }}</h1>
                    <p class="text-xl md:text-2xl text-[#888] font-light leading-relaxed pl-8 italic"
                        style="border-left: 3px solid var(--accent);">{{ $article->excerpt }}</p>
                </header>

                <div id="article-content" class="prose prose-invert prose-lg max-w-none">
                    {!! Str::markdown($article->content) !!}
                </div>
            </article>

            @livewire('article-interactions', ['article' => $article])

            <nav class="border-t border-white/10 pt-10 mt-10 grid grid-cols-1 md:grid-cols-2 gap-6">
                <x-button type="a"
                    href="{{ auth()->check() && auth()->user()->role === 'admin' ? route('dashboard') : route('welcome') }}"
                    variant="outline" class="group !p-5 !justify-start gap-4 h-full">
                    <div
                        class="w-12 h-12 shrink-0 rounded-full border border-white/10 flex items-center justify-center group-hover:border-accent group-hover:text-accent transition-colors">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path d="m15 18-6-6 6-6" />
                        </svg>
                    </div>
                    <div class="flex flex-col text-left">
                        <span class="text-[10px] text-[#666] uppercase tracking-[0.2em] font-mono mb-1">Navigation</span>
                        <span class="text-sm font-bold text-gray-300 group-hover:text-white">RETURN TO ARCHIVE</span>
                    </div>
                </x-button>

                @if ($nextRead)
                    <x-button type="a" href="{{ route('article.show', $nextRead->slug) }}" variant="outline"
                        class="group !p-5 !justify-end gap-4 h-full">
                        <div class="flex flex-col text-right">
                            <span class="text-[10px] text-[#666] uppercase tracking-[0.2em] font-mono mb-1">Read
                                Next</span>
                            <span
                                class="text-sm font-bold text-gray-300 group-hover:text-white line-clamp-1 truncate">{{ Str::limit(strtoupper($nextRead->title), 20) }}</span>
                        </div>
                        <div
                            class="w-12 h-12 shrink-0 rounded-full border border-white/10 flex items-center justify-center group-hover:border-accent group-hover:text-accent transition-colors">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2">
                                <path d="m9 6 6 6-6 6" />
                            </svg>
                        </div>
                    </x-button>
                @endif
            </nav>

        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            if (typeof hljs !== 'undefined') hljs.highlightAll();

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

            window.addEventListener('scroll', () => {
                const scrollTop = window.scrollY;
                const docHeight = document.body.scrollHeight - window.innerHeight;
                document.getElementById('progress-bar').style.width = ((scrollTop / docHeight) * 100) + '%';
            });

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

        function toggleComments() {
            const wrapper = document.getElementById('comments-wrapper');

            if (wrapper.classList.contains('hidden')) {

                wrapper.classList.remove('hidden');

                setTimeout(() => {
                    wrapper.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }, 100);
            } else {
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
    </script>
@endsection
