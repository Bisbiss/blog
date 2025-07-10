<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Personal Site')</title>
    @vite(['resources/css/app.css'])
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
                🌓
            </button>
        </div>
    </header>


    {{-- MAIN CONTENT --}}
    <main class="min-h-screen">
        @yield('content')
    </main>

    {{-- FOOTER --}}
    <footer class="bg-gray-800 text-gray-300 text-center py-6 text-sm">
        &copy; {{ date('Y') }} Syaifulloh. All rights reserved.
    </footer>

    <script>
    // === Dark Mode Toggle ===
    const toggleBtn = document.getElementById('dark-toggle');
    const html = document.documentElement;

    // Cek localStorage
    if (localStorage.getItem('theme') === 'dark' || 
        (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
        html.classList.add('dark');
    } else {
        html.classList.remove('dark');
    }

    toggleBtn.addEventListener('click', () => {
        html.classList.toggle('dark');
        if (html.classList.contains('dark')) {
            localStorage.setItem('theme', 'dark');
        } else {
            localStorage.setItem('theme', 'light');
        }
    });
</script>

</body>
</html>
