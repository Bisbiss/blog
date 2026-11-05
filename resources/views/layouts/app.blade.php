@php
    // Nilai @section('x', $nilai) sudah di-escape Blade; di-decode dulu supaya tidak dobel escape saat dicetak
    $section = fn (string $name) => html_entity_decode(trim($__env->yieldContent($name)), ENT_QUOTES | ENT_HTML5, 'UTF-8');
    $pageTitle = $section('title');
    $fullTitle = $section('full_title') ?: ($pageTitle ? $pageTitle . ' - ' . $site['site_name'] : $site['site_name']);
    $metaDescription = $section('meta_description') ?: $site['site_description'];
    $logo = $site['logo'] ? asset('storage/' . $site['logo']) : null;
    $defaultShareImage = $site['og_image'] ?: $site['hero_image'];
    $shareImage = $section('meta_image') ?: ($defaultShareImage ? asset('storage/' . $defaultShareImage) : null);
    // Halaman paginasi (?page=2) punya canonical sendiri supaya tidak dianggap duplikat halaman 1
    $page = (int) request()->query('page', 1);
    $canonical = url()->current() . ($page > 1 ? '?page=' . $page : '');
    $navLinks = [
        ['label' => 'Beranda', 'route' => 'home'],
        ['label' => 'Layanan', 'route' => 'services'],
        ['label' => 'Artikel', 'route' => 'posts.index'],
        ['label' => 'Gallery', 'route' => 'gallery.index'],
    ];
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $fullTitle }}</title>
    <meta name="description" content="{{ $metaDescription }}">
    @if ($site['site_keywords'])
        <meta name="keywords" content="{{ $site['site_keywords'] }}">
    @endif
    <meta name="author" content="{{ $site['site_name'] }}">
    <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1">
    <link rel="canonical" href="{{ $canonical }}">
    <link rel="alternate" type="text/plain" title="Ringkasan untuk AI (llms.txt)" href="{{ route('llms') }}">

    {{-- Sinyal lokasi (SEO lokal Lampung) --}}
    <meta name="geo.region" content="ID-LA">
    @if ($site['seo_city'])
        <meta name="geo.placename" content="{{ $site['seo_city'] }}, {{ $site['seo_region'] }}">
    @endif

    {{-- Open Graph & Twitter: tampilan saat link dibagikan --}}
    <meta property="og:site_name" content="{{ $site['site_name'] }}">
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:title" content="{{ $fullTitle }}">
    <meta property="og:description" content="{{ $metaDescription }}">
    <meta property="og:url" content="{{ $canonical }}">
    <meta property="og:locale" content="id_ID">
    @if ($shareImage)
        <meta property="og:image" content="{{ $shareImage }}">
        <meta property="og:image:alt" content="{{ $fullTitle }}">
    @endif
    <meta name="twitter:card" content="{{ $shareImage ? 'summary_large_image' : 'summary' }}">
    <meta name="twitter:title" content="{{ $fullTitle }}">
    <meta name="twitter:description" content="{{ $metaDescription }}">
    @if ($shareImage)
        <meta name="twitter:image" content="{{ $shareImage }}">
    @endif

    {{-- Structured data: identitas situs & Syaifulloh, ditambah node khusus dari tiap halaman --}}
    {!! \App\Support\StructuredData::render(\App\Support\StructuredData::base($site)) !!}
    @stack('schema')

    @if ($logo)
        <link rel="icon" href="{{ $logo }}">
    @endif

    {{-- Dijalankan sebelum render supaya tidak ada kedipan putih di dark mode --}}
    <script>
        if (localStorage.getItem('theme') === 'dark' ||
            (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        }
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('head')
</head>
<body class="font-sans text-gray-800 bg-gray-100 dark:bg-gray-900 dark:text-gray-200">

    <header class="sticky top-0 z-30 bg-white/90 shadow-md backdrop-blur dark:bg-gray-900/90">
        <div class="flex items-center justify-between gap-4 px-4 py-3 mx-auto max-w-7xl">
            <a href="{{ route('home') }}" class="flex items-center gap-2 text-xl font-bold text-amber-600 dark:text-amber-400">
                @if ($logo)
                    <img src="{{ $logo }}" alt="{{ $site['site_name'] }}" class="w-10 h-10">
                @else
                    {{ $site['site_name'] }}
                @endif
            </a>

            <nav class="flex items-center gap-1 text-sm font-semibold sm:gap-4">
                @foreach ($navLinks as $link)
                    <a href="{{ route($link['route']) }}"
                       @class([
                           'px-2 py-1 rounded transition hover:text-amber-600',
                           'text-amber-600 dark:text-amber-400' => request()->routeIs($link['route']),
                       ])>
                        {{ $link['label'] }}
                    </a>
                @endforeach

                <button id="dark-toggle" type="button" class="ml-1 text-xl" aria-label="Ganti tema terang/gelap">
                    🌙
                </button>
            </nav>
        </div>
    </header>

    <main class="min-h-screen">
        @yield('content')
    </main>

    <footer class="text-gray-400 bg-gray-900 border-t-4 border-amber-500">
        <div class="grid max-w-6xl gap-10 px-4 py-12 mx-auto md:grid-cols-3">
            <div>
                <a href="{{ route('home') }}" class="flex items-center gap-3 text-lg font-bold text-white">
                    @if ($logo)
                        <img src="{{ $logo }}" alt="" class="w-10 h-10">
                    @endif
                    {{ $site['site_name'] }}
                </a>
                @if ($site['site_description'])
                    <p class="mt-4 text-sm leading-relaxed">{{ $site['site_description'] }}</p>
                @endif
                @if ($site['seo_city'])
                    <p class="mt-3 text-sm">
                        Berbasis di {{ $site['seo_city'] }}, {{ $site['seo_region'] }} —
                        <a href="{{ route('services') }}" class="underline decoration-amber-500/50 underline-offset-4 hover:text-amber-400">melayani undangan pemateri &amp; trainer di seluruh Indonesia</a>.
                    </p>
                @endif
            </div>

            <div>
                <h2 class="mb-4 text-sm font-semibold tracking-wider text-white uppercase">Navigasi</h2>
                <ul class="space-y-2 text-sm">
                    @foreach ($navLinks as $link)
                        <li><a href="{{ route($link['route']) }}" class="transition hover:text-amber-400">{{ $link['label'] }}</a></li>
                    @endforeach
                </ul>
            </div>

            @if (! empty($site['social_links']) || $site['contact_whatsapp'])
                <div>
                    <h2 class="mb-4 text-sm font-semibold tracking-wider text-white uppercase">Terhubung</h2>
                    <ul class="space-y-2 text-sm">
                        @foreach ((array) $site['social_links'] as $social)
                            <li><a href="{{ $social['url'] }}" target="_blank" rel="noopener" class="transition hover:text-amber-400">{{ $social['label'] }}</a></li>
                        @endforeach
                        @if ($site['contact_whatsapp'])
                            <li><a href="https://wa.me/{{ $site['contact_whatsapp'] }}" target="_blank" rel="noopener" class="transition hover:text-amber-400">WhatsApp</a></li>
                        @endif
                    </ul>
                </div>
            @endif
        </div>

        <div class="py-5 text-sm text-center border-t border-gray-800">
            @if ($site['footer_url'])
                <a href="{{ $site['footer_url'] }}" class="hover:text-white">&copy; {{ date('Y') }} {{ $site['footer_text'] }}</a>
            @else
                &copy; {{ date('Y') }} {{ $site['footer_text'] }}
            @endif
        </div>
    </footer>

    {{-- Tombol melayang: kembali ke atas & WhatsApp --}}
    <div class="fixed z-40 flex flex-col items-center gap-3 bottom-5 right-5">
        <button type="button" data-back-to-top aria-label="Kembali ke atas"
                class="flex items-center justify-center w-11 h-11 text-white transition duration-300 rounded-full shadow-lg bg-amber-600 hover:bg-amber-700">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 10.5 12 3m0 0 7.5 7.5M12 3v18" /></svg>
        </button>
        @if ($site['contact_whatsapp'])
            <a href="https://wa.me/{{ $site['contact_whatsapp'] }}" target="_blank" rel="noopener" aria-label="Chat via WhatsApp"
               class="flex items-center justify-center text-white transition rounded-full shadow-lg w-14 h-14 bg-emerald-500 hover:bg-emerald-600 hover:scale-105">
                <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H8.25m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H12m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 0 1-2.555-.337A5.972 5.972 0 0 1 5.41 20.97a5.969 5.969 0 0 1-.474-.065 4.48 4.48 0 0 0 .978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25Z" /></svg>
            </a>
        @endif
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const toggleBtn = document.getElementById('dark-toggle');
            const html = document.documentElement;

            function updateIcon() {
                toggleBtn.textContent = html.classList.contains('dark') ? '🔆' : '🌙';
            }

            updateIcon();

            toggleBtn.addEventListener('click', () => {
                html.classList.toggle('dark');
                localStorage.setItem('theme', html.classList.contains('dark') ? 'dark' : 'light');
                updateIcon();
            });
        });
    </script>
    @stack('scripts')
</body>
</html>
