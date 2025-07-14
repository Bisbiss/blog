<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title') - Syaifulloh</title>
    <meta name="description" content="Syaifulloh Lampung Cerdas">
    <meta name="keywords" content="Syaifulloh, Lampung, Cerdas, Syaifulloh Lampung, Syaifulloh Cerdas, Syaifulloh Lampung Cerdas, Syaifulloh Lampung Cerdas">
    <meta name="author" content="Syaifulloh">
    <meta name="copyright" content="Syaifulloh">
    <meta name="robots" content="index, follow">
    <meta name="language" content="Indonesia">
    <meta name="distribution" content="Global">
    <meta name="rating" content="General">
    <meta name="revisit-after" content="7 days">
    <meta name="googlebot" content="index, follow">
    <meta name="bingbot" content="index, follow">
    <meta name="yandexbot" content="index, follow">
    <meta name="pinterest" content="nopin">
    <meta name="author" content="Syaifulloh">
    <meta name="copyright" content="Syaifulloh">
    <meta name="robots" content="index, follow">
    <meta name="language" content="Indonesia">
    <meta name="distribution" content="Global">
    <meta name="rating" content="General">
    <meta name="revisit-after" content="7 days">
    <meta name="googlebot" content="index, follow">
    <meta name="bingbot" content="index, follow">
    <meta name="yandexbot" content="index, follow">
    <meta name="pinterest" content="nopin">
    <link rel="icon" href="/image/logo.png" type="image/png">

    @vite(['resources/css/app.css'])
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
</head>
<body class="bg-gray-100 text-gray-800 font-sans">

    <header class="bg-white dark:bg-gray-900 shadow-md">
        <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
            {{-- KIRI: Nama --}}
            <a href="/" class="text-xl font-bold text-amber-600 dark:text-amber-400">
                <img src="/image/logo.png" class="w-10 h-10">
            </a>

            {{-- KANAN: Dark Mode Toggle --}}
            <button id="dark-toggle" class="text-gray-700 dark:text-gray-200 hover:text-amber-600 text-xl">
                🌙
            </button>
        </div>
    </header>


    {{-- MAIN CONTENT --}}
    <main class="min-h-screen">
        @yield('content')
    </main>

    {{-- FOOTER --}}
    <footer class="bg-gray-800 text-gray-300 text-center py-6 text-sm">
        <a href="https://lampungcerdas.com">
            &copy; {{ date('Y') }} Lampung Cerdas. All rights reserved.
        </a>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const toggleBtn = document.getElementById('dark-toggle');
            const html = document.documentElement;

            // Icons for light and dark mode
            const lightIcon = '🔆'; // sun icon for light mode
            const darkIcon = '🌙';  // moon icon for dark mode

            // Initialize icon based on current theme
            function updateIcon() {
                if (html.classList.contains('dark')) {
                    toggleBtn.textContent = lightIcon;
                } else {
                    toggleBtn.textContent = darkIcon;
                }
            }

            // Check localStorage or system preference and set theme
            if (localStorage.getItem('theme') === 'dark' || 
                (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                html.classList.add('dark');
            } else {
                html.classList.remove('dark');
            }
            updateIcon();

            toggleBtn.addEventListener('click', () => {
                html.classList.toggle('dark');
                if (html.classList.contains('dark')) {
                    localStorage.setItem('theme', 'dark');
                } else {
                    localStorage.setItem('theme', 'light');
                }
                updateIcon();
            });
        });
    </script>

</body>
</html>
