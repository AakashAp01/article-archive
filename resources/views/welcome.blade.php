<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Akash//Ap') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Barlow+Semi+Condensed:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Bebas+Neue&family=Fredoka:wght@300..700&family=M+PLUS+Rounded+1c&display=swap" rel="stylesheet">

    <!--Styles-->
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


                    spacing: {
                        '128': '32rem',
                    }
                }
            }
        }
    </script>
</head>

<body class="font-body bg-[#0a0a0f] select-none">
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
    @php
        $user = App\Models\User::find(Auth::id());
    @endphp
    <div id="app" data-user='@json($user)'></div>
    <x-cookie-consent />
    @viteReactRefresh
    @vite(['resources/js/app.jsx'])
</body>

</html>
