<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="{{ asset('bi-cart4.svg') }}" type="image/x-icon">
    <title inertia>{{ config('app.name', 'Laravel') }}</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('loader.css') }}" />

    <!-- Scripts -->
    @routes
    @vite(['resources/js/app.js', "resources/js/pages/{$page['component']}.vue"])
    @inertiaHead
</head>

<body class="bg-skin-default font-sans antialiased">
    @inertia
    <div id="loading-bg">
        <div class="loading-logo">
            <!-- SVG Logo -->
            <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 16 16">
                <path fill="#696CFF"
                    d="M0 2.5A.5.5 0 0 1 .5 2H2a.5.5 0 0 1 .485.379L2.89 4H14.5a.5.5 0 0 1 .485.621l-1.5 6A.5.5 0 0 1 13 11H4a.5.5 0 0 1-.485-.379L1.61 3H.5a.5.5 0 0 1-.5-.5M3.14 5l.5 2H5V5zM6 5v2h2V5zm3 0v2h2V5zm3 0v2h1.36l.5-2zm1.11 3H12v2h.61zM11 8H9v2h2zM8 8H6v2h2zM5 8H3.89l.5 2H5zm0 5a1 1 0 1 0 0 2a1 1 0 0 0 0-2m-2 1a2 2 0 1 1 4 0a2 2 0 0 1-4 0m9-1a1 1 0 1 0 0 2a1 1 0 0 0 0-2m-2 1a2 2 0 1 1 4 0a2 2 0 0 1-4 0" />
            </svg>
        </div>
        <div class="loading">
            <div class="effect-1 effects"></div>
            <div class="effect-2 effects"></div>
            <div class="effect-3 effects"></div>
        </div>
    </div>
    <script>
        const loaderColor = localStorage.getItem('sneat-initial-loader-bg') || '#FFFFFF'
        const primaryColor = localStorage.getItem('sneat-initial-loader-color') || '#696CFF'

        if (loaderColor)
            document.documentElement.style.setProperty('--initial-loader-bg', loaderColor)

        if (primaryColor)
            document.documentElement.style.setProperty('--initial-loader-color', primaryColor)

        document.addEventListener('DOMContentLoaded', () => {
            const loadingBg = document.getElementById('loading-bg');

            // Wait for Inertia to load the initial page
            if (window.Inertia) {
                window.Inertia.on('navigate', (event) => {
                    if (event.detail.completed) {
                        loadingBg.classList.add('hidden');
                    }
                });
            } else {
                // Fallback for hiding loader after basic DOM load
                loadingBg.classList.add('hidden');
            }
        });
    </script>
</body>

</html>
