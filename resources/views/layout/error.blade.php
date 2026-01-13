<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') | {{ env('APP_NAME') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600|courier-prime:400,700" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        bg: '#0a0a0f',
                        accent: '#00ff88', 
                        warn: '#ffcc00', 
                        danger: '#ff3333'
                    },
                    fontFamily: {
                        display: ['Courier Prime', 'monospace'],
                        body: ['Instrument Sans', 'sans-serif']
                    },
                }
            }
        }
    </script>
</head>

<body>
    @yield('content')
</body>

</html>
