<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'AkashAp') | AkashAp.Dev</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600|courier-prime:400,700" rel="stylesheet" />

    <link rel="stylesheet" href="https://unpkg.com/easymde/dist/easymde.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/highlight.min.js"></script>
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/styles/atom-one-dark.min.css">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        bg: '#0a0a0f',
                        'card-bg': 'rgba(255, 255, 255, 0.03)',
                        'card-border': 'rgba(255, 255, 255, 0.1)',
                        accent: '#00ff88',
                        'text-main': '#e0e0e0',
                        'text-muted': '#888',
                    },
                }
            }
        }
    </script>

    <style>
        /* Global Scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
        }

        ::-webkit-scrollbar-track {
            background: #0a0a0f;
        }

        ::-webkit-scrollbar-thumb {
            background: #333;
            border-radius: 3px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #00ff88;
        }

        /* Utility */
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        .text-glow {
            text-shadow: 0 0 10px rgba(0, 255, 136, 0.5);
        }
    </style>

    @stack('styles')
    @livewireStyles
</head>

<body
    class="bg-bg text-text-main antialiased min-h-screen flex flex-col font-display selection:bg-accent selection:text-black">
    @unless (request()->routeIs(['article.create', 'article.edit']))
        @include('layout.nav')
    @endunless
    <div class="flex-1 w-full relative">
        @yield('content')
        {{ $slot ?? '' }}
    </div>
    @unless (request()->routeIs(['article.create', 'article.edit']))
        @include('layout.footer')
    @endunless
    <x-toast />
    <x-confirm-modal />
    @stack('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://unpkg.com/easymde/dist/easymde.min.js"></script>
    @livewireScripts
</body>

</html>
