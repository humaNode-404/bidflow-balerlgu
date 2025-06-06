<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ asset('bidflow-favicon.svg') }}" type="image/x-icon">
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
            <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="100"
                height="100" viewBox="718,315,100,100">
                <g id="document" fill-opacity="0" fill="#ffffff" fill-rule="nonzero" stroke="#000000" stroke-width="0"
                    stroke-linecap="butt" stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray=""
                    stroke-dashoffset="0" font-family="none" font-weight="none" font-size="none" text-anchor="none"
                    style="mix-blend-mode: normal">
                    <rect x="5026" y="1575" transform="scale(0.14286,0.2)" width="700" height="500" id="Shape 1 1"
                        vector-effect="non-scaling-stroke" />
                </g>
                <g fill="none" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="none"
                    stroke-linejoin="none" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0"
                    font-family="none" font-weight="none" font-size="none" text-anchor="none"
                    style="mix-blend-mode: normal">
                    <g id="stage">
                        <g id="layer1 1">
                            <path d="" id="Path 1" fill="none" stroke="#000000" stroke-linecap="round"
                                stroke-linejoin="round" />
                            <g id="Group 1" fill="#696cff" stroke="none" stroke-linecap="butt" stroke-linejoin="miter"
                                font-family="none" font-weight="none" font-size="NaN" text-anchor="start" />
                            <g id="Group 1" fill="#696cff" stroke="none" stroke-linecap="butt" stroke-linejoin="miter"
                                font-family="none" font-weight="none" font-size="NaN" text-anchor="start" />
                            <g id="Group 1" fill="#696cff" stroke="none" stroke-linecap="butt" stroke-linejoin="miter">
                                <circle cx="210.11511" cy="110.64811" transform="scale(3.63129,3.63129)" r="1.5"
                                    id="Shape 1" />
                                <circle cx="217.11511" cy="110.64811" transform="scale(3.63129,3.63129)" r="1.5"
                                    id="Shape 1" />
                                <path
                                    d="M790.2235,392.71707c1.49714,-0.00443 2.83814,-0.92725 3.3771,-2.32402l10.27655,-26.7263h-7.77096l-8.38828,21.78774h-24.11177l-16.30449,-39.109c-1.13049,-2.70999 -3.78159,-4.47259 -6.71789,-4.46649h-8.46091v7.26258h8.46091l17.24863,41.32408c0.55704,1.35603 1.87484,2.24406 3.34079,2.2514z"
                                    id="Path 1" />
                                <path
                                    d="M773.71754,354.10238c-0.67387,-0.24135 -1.41581,0.10927 -1.65716,0.78315c-0.24135,0.67387 0.10927,1.41581 0.78315,1.65716l12.20158,4.37007c0.67387,0.24135 1.41581,-0.10927 1.65716,-0.78315c0.24135,-0.67387 -0.10927,-1.41581 -0.78315,-1.65716zM770.31235,359.76616c0.24135,-0.67387 0.98329,-1.0245 1.65716,-0.78315l12.20158,4.37007c0.67387,0.24135 1.0245,0.98329 0.78315,1.65716c-0.24135,0.67387 -0.98329,1.0245 -1.65716,0.78315l-12.20158,-4.37007c-0.67387,-0.24135 -1.0245,-0.98329 -0.78315,-1.65716M768.56432,364.64679c0.24135,-0.67387 0.98329,-1.0245 1.65716,-0.78315l4.88063,1.74803c0.67387,0.24135 1.0245,0.98329 0.78315,1.65716c-0.24135,0.67387 -0.98329,1.0245 -1.65716,0.78315l-4.88063,-1.74803c-0.67387,-0.24135 -1.0245,-0.98329 -0.78315,-1.65716"
                                    id="CompoundPath 1" />
                                <path
                                    d="M789.59689,340.51623l-13.42173,-4.80707c-2.6955,-0.96541 -5.66325,0.43711 -6.62866,3.1326l-10.48816,29.28378c-0.96541,2.6955 0.43711,5.66325 3.1326,6.62866l19.52252,6.99211c2.6955,0.96541 5.66325,-0.43711 6.62866,-3.1326l8.30313,-23.18299zM788.72288,342.95654l-1.74803,4.88063c-0.72406,2.02162 0.32783,4.24744 2.34945,4.97149l4.88063,1.74803l-8.30313,23.18299c-0.4827,1.34775 -1.96658,2.04901 -3.31433,1.5663l-19.52252,-6.99211c-1.34775,-0.4827 -2.04901,-1.96658 -1.5663,-3.31433l10.48816,-29.28378c0.4827,-1.34775 1.96658,-2.04901 3.31433,-1.5663z"
                                    id="CompoundPath 1" />
                                <path
                                    d="M752.39052,336.93416c-0.54743,0.23282 -0.80246,0.86534 -0.56963,1.41277c0.23282,0.54743 0.86534,0.80246 1.41277,0.56963l11.89444,-5.05881c0.54743,-0.23282 0.80246,-0.86534 0.56963,-1.41277c-0.23282,-0.54743 -0.86534,-0.80246 -1.41277,-0.56963zM753.50715,342.31175c-0.23282,-0.54743 0.02221,-1.17995 0.56963,-1.41277l11.89444,-5.05881c0.54743,-0.23282 1.17995,0.02221 1.41277,0.56963c0.23282,0.54743 -0.02221,1.17995 -0.56963,1.41277l-11.89444,5.05881c-0.54743,0.23282 -1.17995,-0.02221 -1.41277,-0.56963M755.76306,344.86379c-0.54743,0.23282 -0.80246,0.86534 -0.56963,1.41277c0.23282,0.54743 0.86534,0.80246 1.41277,0.56963l11.89444,-5.05881c0.54743,-0.23282 0.80246,-0.86534 0.56963,-1.41277c-0.23282,-0.54743 -0.86534,-0.80246 -1.41277,-0.56963zM757.44933,348.8286c-0.54743,0.23282 -0.80246,0.86534 -0.56963,1.41277c0.23282,0.54743 0.86534,0.80246 1.41277,0.56963l5.94722,-2.52941c0.54743,-0.23282 0.80246,-0.86534 0.56963,-1.41277c-0.23282,-0.54743 -0.86534,-0.80246 -1.41277,-0.56963z"
                                    id="CompoundPath 1" />
                                <path
                                    d="M744.75703,335.49876c-0.9313,-2.18971 0.08884,-4.71978 2.27854,-5.65108l15.85925,-6.74509c2.18971,-0.9313 4.71978,0.08884 5.65108,2.27854l10.11763,23.78887c0.9313,2.18971 -0.08884,4.71978 -2.27854,5.65108l-15.85925,6.74509c-2.18971,0.9313 -4.71978,-0.08884 -5.65108,-2.27854zM763.73795,325.085l-15.85925,6.74509c-1.09485,0.46565 -1.60492,1.73069 -1.13927,2.82554l10.11763,23.78887c0.46565,1.09485 1.73069,1.60492 2.82554,1.13927l15.85925,-6.74509c1.09485,-0.46565 1.60492,-1.73069 1.13927,-2.82554l-10.11763,-23.78887c-0.46565,-1.09485 -1.73069,-1.60492 -2.82554,-1.13927"
                                    id="CompoundPath 1" />
                            </g>
                        </g>
                    </g>
                </g>
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
