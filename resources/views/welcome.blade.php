@extends('layouts.app')

@section('full_title', $site['home_title'])

@push('schema')
    {!! \App\Support\StructuredData::render([[
        '@type' => 'ProfilePage',
        '@id' => route('home') . '#webpage',
        'url' => route('home'),
        'name' => $site['home_title'] ?: $site['site_name'],
        'inLanguage' => 'id-ID',
        'isPartOf' => ['@id' => \App\Support\StructuredData::websiteId()],
        'mainEntity' => ['@id' => \App\Support\StructuredData::personId()],
        'about' => ['@id' => \App\Support\StructuredData::personId()],
    ]]) !!}
@endpush

@php
    // Kelas lengkap ditulis di sini supaya terdeteksi Tailwind saat build
    $socialColors = [
        'pink' => 'bg-pink-600 hover:bg-pink-700',
        'sky' => 'bg-sky-600 hover:bg-sky-700',
        'blue' => 'bg-blue-600 hover:bg-blue-700',
        'slate' => 'bg-slate-600 hover:bg-slate-700',
        'red' => 'bg-red-600 hover:bg-red-700',
        'emerald' => 'bg-emerald-600 hover:bg-emerald-700',
        'amber' => 'bg-amber-600 hover:bg-amber-700',
    ];
    $achievementImages = array_values(array_filter((array) $site['achievement_images']));
    $heroStats = array_values(array_filter((array) $site['hero_stats'], fn ($stat) => filled($stat['value'] ?? null)));

    // Kata terakhir judul hero diberi warna aksen, contoh: "Saya <Syaifulloh>"
    $heroTitle = trim((string) $site['hero_title']);
    $heroTitleStart = str_contains($heroTitle, ' ') ? Str::beforeLast($heroTitle, ' ') : '';
    $heroTitleEnd = str_contains($heroTitle, ' ') ? Str::afterLast($heroTitle, ' ') : $heroTitle;
    $services = array_values(array_filter((array) $site['services'], fn ($s) => filled($s['title'] ?? null)));
@endphp

@section('content')
<div class="text-gray-800 bg-gray-100 dark:bg-gray-900 dark:text-gray-200">

    {{-- Hero: foto tampil lebih dulu di mobile --}}
    <section class="relative px-4 pt-10 pb-16 overflow-hidden md:pt-16 md:pb-20">
        @if ($site['hero_particles'])
            {{-- Latar partikel (particles.js), diisi canvas oleh resources/js/hero-particles.js --}}
            <div id="hero-particles" aria-hidden="true" class="absolute inset-0 pointer-events-none"></div>
        @endif
        <div aria-hidden="true" class="absolute rounded-full pointer-events-none top-20 -right-32 w-96 h-96 bg-amber-400/20 blur-3xl"></div>
        <div aria-hidden="true" class="absolute rounded-full pointer-events-none bottom-24 -left-40 w-80 h-80 bg-amber-300/20 blur-3xl dark:bg-amber-500/10"></div>

        <div class="relative mx-auto max-w-7xl">
            <div class="md:flex md:items-center md:gap-8">
                @if ($site['hero_image'])
                    <div class="relative max-w-sm mx-auto mb-8 md:order-2 md:w-2/5 md:max-w-none md:mb-0">
                        <div aria-hidden="true" class="absolute rounded-full inset-x-[8%] bottom-0 aspect-square bg-gradient-to-tr from-amber-500 to-amber-300 dark:from-amber-600 dark:to-amber-400"></div>
                        <img src="{{ asset('storage/' . $site['hero_image']) }}" alt="{{ $site['site_name'] }}{{ $site['hero_tagline'] ? ', ' . $site['hero_tagline'] : '' }}" fetchpriority="high" class="relative w-full h-auto">
                    </div>
                @endif

                <div @class(['flex flex-col md:order-1 md:pr-8', 'md:w-3/5' => $site['hero_image']])>
                    @if ($site['hero_greeting'])
                        <span class="self-start px-4 py-1 mb-4 text-sm font-semibold rounded-full text-amber-700 bg-amber-100 dark:text-amber-300 dark:bg-amber-500/10">
                            {{ $site['hero_greeting'] }}
                        </span>
                    @endif
                    <h1 class="mb-5 text-4xl font-extrabold tracking-tight md:text-5xl lg:text-6xl">
                        {{ $heroTitleStart }} <span class="text-amber-600 dark:text-amber-400">{{ $heroTitleEnd }}</span>
                        @if ($site['hero_tagline'])
                            <span class="block mt-3 text-xl font-bold tracking-normal text-gray-600 md:text-2xl dark:text-gray-300">{{ $site['hero_tagline'] }}</span>
                        @endif
                    </h1>
                    <div class="mb-8 text-gray-600 prose max-w-none dark:text-gray-300 md:text-lg">
                        {!! $site['hero_text'] !!}
                    </div>
                    @if (! empty($site['social_links']))
                        <div class="flex flex-col gap-3 sm:flex-row sm:flex-wrap">
                            @foreach ($site['social_links'] as $social)
                                <a href="{{ $social['url'] }}" target="_blank" rel="noopener"
                                   class="w-full px-6 py-3 font-semibold text-center text-white transition rounded-lg shadow-sm sm:w-auto hover:-translate-y-0.5 hover:shadow-md {{ $socialColors[$social['color'] ?? 'slate'] ?? $socialColors['slate'] }}">
                                    {{ $social['label'] }}
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            {{-- Angka pencapaian --}}
            @if ($heroStats)
                <dl @class([
                    'grid grid-cols-2 gap-px mt-12 overflow-hidden bg-gray-200 shadow-sm rounded-2xl dark:bg-gray-700',
                    'md:grid-cols-4' => count($heroStats) === 4,
                    'md:grid-cols-3' => count($heroStats) === 3,
                ])>
                    @foreach ($heroStats as $stat)
                        <div class="flex flex-col px-4 py-6 text-center bg-white dark:bg-gray-800">
                            <dt class="text-sm text-gray-500 dark:text-gray-400">{{ $stat['label'] ?? '' }}</dt>
                            <dd class="order-first mb-1 text-2xl font-extrabold md:text-3xl text-amber-600 dark:text-amber-400">{{ $stat['value'] }}</dd>
                        </div>
                    @endforeach
                </dl>
            @endif
        </div>
    </section>

    {{-- About --}}
    @if ($site['about_text'] || $site['about_image'])
        <section id="about" class="max-w-5xl px-4 py-16 mx-auto" data-reveal>
            <x-section-heading :title="$site['about_title']" class="mb-10" />
            <div class="max-w-4xl mx-auto md:flex md:items-center md:gap-12">
                @if ($site['about_image'])
                    <div class="mb-8 overflow-hidden md:w-1/2 md:mb-0 rounded-3xl bg-gradient-to-b from-amber-100 to-amber-50 dark:from-gray-700 dark:to-gray-800">
                        <img src="{{ asset('storage/' . $site['about_image']) }}" alt="{{ $site['about_title'] }}" loading="lazy" class="object-cover w-full h-auto">
                    </div>
                @endif
                <div class="text-gray-700 prose md:w-1/2 dark:text-gray-300 md:text-lg">
                    {!! $site['about_text'] !!}
                </div>
            </div>
        </section>
    @endif

    {{-- Layanan: ringkasan program, mengarah ke halaman pilar /pemateri-trainer-lampung --}}
    @if ($services)
        <section id="layanan" class="px-4 py-16 bg-white dark:bg-gray-800">
            <div class="max-w-6xl mx-auto" data-reveal>
                <x-section-heading :title="$site['services_title']" class="mb-4" />
                <p class="max-w-3xl mx-auto mb-10 text-center text-gray-600 md:text-lg dark:text-gray-400">
                    Seminar, workshop, dan pelatihan untuk sekolah, kampus, instansi, perusahaan, dan UMKM — di Lampung dan seluruh Indonesia.
                </p>
                <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach (array_slice($services, 0, 6) as $service)
                        <div class="flex flex-col p-6 border-t-4 shadow-sm rounded-xl bg-gray-50 border-amber-500 dark:bg-gray-900">
                            <h3 class="text-lg font-bold leading-snug">{{ $service['title'] }}</h3>
                            @if (filled($service['audience'] ?? null))
                                <p class="mt-1 text-sm font-semibold text-amber-700 dark:text-amber-400">{{ $service['audience'] }}</p>
                            @endif
                            @if (filled($service['description'] ?? null))
                                <p class="mt-3 text-sm text-gray-600 dark:text-gray-400">{{ $service['description'] }}</p>
                            @endif
                        </div>
                    @endforeach
                </div>
                <div class="mt-10 text-center">
                    <a href="{{ route('services') }}" class="inline-block px-6 py-3 font-semibold text-white transition rounded-lg shadow-sm bg-amber-600 hover:bg-amber-700">
                        Lihat program &amp; cara mengundang pemateri &rarr;
                    </a>
                </div>
            </div>
        </section>
    @endif

    {{-- Detail profil (accordion) --}}
    @if ($profileSections->isNotEmpty())
        <section id="detail" class="px-4 py-16">
            <div class="max-w-5xl mx-auto" data-reveal>
                <x-section-heading :title="$site['profile_title']" class="mb-10" />
                <div class="space-y-4">
                    @foreach ($profileSections as $section)
                        <details class="p-6 transition bg-white border-l-4 border-transparent shadow-sm group rounded-xl open:border-amber-500 open:shadow-md dark:bg-gray-800" @if ($loop->first) open @endif>
                            <summary class="flex items-center justify-between gap-4 text-lg font-semibold list-none cursor-pointer md:text-xl [&::-webkit-details-marker]:hidden">
                                {{ $section->title }}
                                <span class="flex items-center justify-center flex-shrink-0 w-8 h-8 transition rounded-full bg-amber-100 text-amber-600 group-open:rotate-180 dark:bg-amber-500/10">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" /></svg>
                                </span>
                            </summary>
                            <div class="mt-4 text-gray-700 prose max-w-none dark:text-gray-300">
                                {!! $section->content !!}
                            </div>
                        </details>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- Media & Publikasi --}}
    @if ($site['media_image'])
        <section id="media-publikasi" class="max-w-5xl px-4 py-16 mx-auto" data-reveal>
            <x-section-heading :title="$site['media_title']" class="mb-10" />
            <div class="max-w-4xl mx-auto">
                <img src="{{ asset('storage/' . $site['media_image']) }}" alt="{{ $site['media_title'] }}" loading="lazy" class="object-cover w-full h-auto shadow-lg rounded-xl">
            </div>
        </section>
    @endif

    {{-- Buku: grid 4 kolom --}}
    @if ($books->isNotEmpty())
        <section id="buku" class="max-w-6xl px-4 py-16 mx-auto" data-reveal>
            <x-section-heading :title="$site['books_title']" class="mb-4" />
            @if ($site['books_subtitle'])
                <p class="text-xl font-semibold text-center text-gray-700 md:text-2xl dark:text-gray-300">{{ $site['books_subtitle'] }}</p>
            @endif
            @if ($site['books_text'])
                <p class="mt-1 text-center text-gray-600 md:text-lg dark:text-gray-400">{{ $site['books_text'] }}</p>
            @endif

            <div class="grid grid-cols-2 gap-6 mt-10 md:grid-cols-4">
                @foreach ($books as $book)
                    <div class="flex flex-col overflow-hidden bg-white shadow-md group rounded-xl card-lift dark:bg-gray-800">
                        <div class="overflow-hidden bg-white">
                            <img src="{{ asset('storage/' . $book->cover) }}" alt="{{ $book->title }}" loading="lazy" class="object-contain w-full p-3 transition duration-500 aspect-[3/4] group-hover:scale-105">
                        </div>
                        <div class="flex flex-col flex-1 p-4 text-center border-t-2 border-amber-500">
                            <h3 class="font-semibold leading-snug">{{ $book->title }}</h3>
                            @if ($book->description)
                                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400 line-clamp-3">{{ $book->description }}</p>
                            @endif
                            @if ($book->url)
                                <a href="{{ $book->url }}" target="_blank" rel="noopener" class="self-center inline-block px-4 py-1.5 mt-3 text-sm font-semibold text-white transition rounded-full bg-amber-600 hover:bg-amber-700">
                                    Lihat buku
                                </a>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    @endif

    {{-- Artikel: carousel 4 per baris --}}
    @if ($posts->isNotEmpty())
        <section id="artikel" class="max-w-6xl px-4 py-16 mx-auto" data-reveal>
            <div class="flex items-center justify-between gap-4 mb-8">
                <x-section-heading :title="$site['articles_title']" align="left" />
                <a href="{{ route('posts.index') }}" class="font-semibold text-amber-600 hover:text-amber-700 whitespace-nowrap">Lihat semua &rarr;</a>
            </div>
            <x-carousel :label="$site['articles_title']" :rows="2">
                @foreach ($posts as $post)
                    @include('posts._card', ['post' => $post, 'class' => 'carousel-item'])
                @endforeach
            </x-carousel>
        </section>
    @endif

    {{-- Gallery: carousel 4 per baris, klik untuk memperbesar --}}
    @if ($galleryItems->isNotEmpty())
        <section id="galeri" class="px-4 py-16 bg-white dark:bg-gray-800">
            <div class="max-w-6xl mx-auto" data-reveal>
                <div class="flex items-center justify-between gap-4 mb-8">
                    <x-section-heading :title="$site['gallery_title']" align="left" />
                    <a href="{{ route('gallery.index') }}" class="font-semibold text-amber-600 hover:text-amber-700 whitespace-nowrap">Lihat semua &rarr;</a>
                </div>
                <x-carousel :label="$site['gallery_title']" :rows="2">
                    @foreach ($galleryItems as $item)
                        @include('gallery._card', ['item' => $item, 'class' => 'carousel-item'])
                    @endforeach
                </x-carousel>
            </div>
        </section>
        <x-lightbox />
    @endif

    {{-- Achievements: daftar + slider foto --}}
    @if ($achievements->isNotEmpty() || $achievementImages)
        <section id="achievement" class="max-w-5xl px-4 py-16 mx-auto" data-reveal>
            <x-section-heading :title="$site['achievements_title']" class="mb-10" />
            <div class="max-w-5xl mx-auto md:flex md:items-center md:gap-10">
                @if ($achievements->isNotEmpty())
                    <div @class(['md:w-1/2' => $achievementImages])>
                        @if ($site['achievements_subtitle'])
                            <h3 class="mb-4 text-xl font-bold">{{ $site['achievements_subtitle'] }}</h3>
                        @endif
                        <ul class="space-y-3 text-gray-700 dark:text-gray-300">
                            @foreach ($achievements as $achievement)
                                <li class="flex items-start gap-3 p-4 bg-white shadow-sm rounded-xl dark:bg-gray-800">
                                    <span class="flex items-center justify-center flex-shrink-0 rounded-full w-9 h-9 bg-amber-100 text-amber-600 dark:bg-amber-500/10">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.974a1 1 0 00.95.69h4.18c.969 0 1.371 1.24.588 1.81l-3.388 2.462a1 1 0 00-.364 1.118l1.287 3.974c.3.922-.755 1.688-1.54 1.118l-3.388-2.462a1 1 0 00-1.175 0l-3.388 2.462c-.784.57-1.838-.196-1.54-1.118l1.287-3.974a1 1 0 00-.364-1.118L2.045 9.4c-.783-.57-.38-1.81.588-1.81h4.18a1 1 0 00.95-.69l1.286-3.974z"/>
                                        </svg>
                                    </span>
                                    @if ($achievement->url)
                                        <a href="{{ $achievement->url }}" target="_blank" rel="noopener" class="self-center underline decoration-amber-500/50 underline-offset-4 hover:text-amber-600">{{ $achievement->title }}</a>
                                    @else
                                        <span class="self-center">{{ $achievement->title }}</span>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if ($achievementImages)
                    <div @class(['mt-8 md:mt-0', 'md:w-1/2' => $achievements->isNotEmpty()])>
                        <x-carousel :label="$site['achievements_title']" wrap class="!gap-0 !pt-0 !pb-0 rounded-xl shadow-lg">
                            @foreach ($achievementImages as $image)
                                <img src="{{ asset('storage/' . $image) }}" alt="{{ $site['achievements_title'] }} {{ $loop->iteration }}" loading="lazy"
                                     class="object-cover w-full bg-white shrink-0 snap-start h-80 dark:bg-gray-800">
                            @endforeach
                        </x-carousel>
                    </div>
                @endif
            </div>
        </section>
    @endif

    {{-- Kontak: kartu ajakan kolaborasi --}}
    @if ($site['contact_whatsapp'])
        <section id="contact" class="px-4 pt-8 pb-20" data-reveal>
            <div class="relative max-w-5xl px-6 py-14 mx-auto overflow-hidden text-center text-white bg-gray-900 shadow-xl rounded-3xl md:px-12 dark:bg-gray-800 dark:ring-1 dark:ring-white/10">
                <div aria-hidden="true" class="absolute rounded-full pointer-events-none -top-24 -right-16 w-72 h-72 bg-amber-500/30 blur-3xl"></div>
                <div aria-hidden="true" class="absolute rounded-full pointer-events-none -bottom-24 -left-16 w-72 h-72 bg-amber-400/20 blur-3xl"></div>

                <div class="relative">
                    <x-section-heading :title="$site['contact_title']" class="mb-6" />
                    @if ($site['contact_text'])
                        <p class="max-w-2xl mx-auto mb-8 text-lg text-gray-300">{{ $site['contact_text'] }}</p>
                    @endif
                    <a href="https://wa.me/{{ $site['contact_whatsapp'] }}" target="_blank" rel="noopener"
                       class="inline-flex items-center gap-2 px-8 py-3 font-semibold text-white transition rounded-full shadow-lg bg-emerald-500 hover:bg-emerald-600 hover:-translate-y-0.5">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H8.25m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H12m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 0 1-2.555-.337A5.972 5.972 0 0 1 5.41 20.97a5.969 5.969 0 0 1-.474-.065 4.48 4.48 0 0 0 .978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25Z" /></svg>
                        {{ $site['contact_button'] ?: 'Chat via WhatsApp' }}
                    </a>
                </div>
            </div>
        </section>
    @endif
</div>
@endsection
