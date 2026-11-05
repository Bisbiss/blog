@extends('layouts.app')

@use('App\Support\StructuredData')

@php
    $services = array_values(array_filter((array) $site['services'], fn ($s) => filled($s['title'] ?? null)));
    $faqs = array_values(array_filter((array) $site['faqs'], fn ($f) => filled($f['question'] ?? null) && filled($f['answer'] ?? null)));
    $formats = array_values(array_filter((array) $site['service_formats']));
    $areas = array_values(array_filter((array) $site['area_served']));
    $credentials = array_values(array_filter((array) $site['credentials']));
    $heroStats = array_values(array_filter((array) $site['hero_stats'], fn ($stat) => filled($stat['value'] ?? null)));
    $waMessage = 'Halo, saya ingin mengundang ' . $site['site_name'] . ' sebagai pemateri/trainer. Nama instansi: ..., tanggal & lokasi acara: ..., jumlah peserta: ..., tema: ...';
    $waLink = $site['contact_whatsapp'] ? 'https://wa.me/' . $site['contact_whatsapp'] . '?text=' . rawurlencode($waMessage) : null;
@endphp

@section('title', $site['services_title'])
@section('meta_description', \Illuminate\Support\Str::limit(strip_tags((string) $site['services_intro']), 158))

@push('schema')
    {!! StructuredData::render([
        StructuredData::service($site),
        StructuredData::faq($faqs),
        StructuredData::breadcrumbs(['Beranda' => route('home'), 'Layanan Pemateri & Trainer' => route('services')]),
    ]) !!}
@endpush

@section('content')
<div class="text-gray-800 bg-gray-100 dark:bg-gray-900 dark:text-gray-200">

    {{-- Pembuka: jawaban langsung "siapa pemateri/trainer di Lampung" --}}
    <section class="px-4 pt-8 pb-14 md:pt-12">
        <div class="max-w-5xl mx-auto">
            <nav class="mb-6 text-sm text-gray-500 dark:text-gray-400" aria-label="Breadcrumb">
                <a href="{{ route('home') }}" class="hover:text-amber-600">Beranda</a>
                <span class="mx-1">/</span>
                <span aria-current="page">Layanan Pemateri &amp; Trainer</span>
            </nav>

            <span class="inline-block px-4 py-1 mb-4 text-sm font-semibold rounded-full text-amber-700 bg-amber-100 dark:text-amber-300 dark:bg-amber-500/10">
                Seminar · Workshop · Training · Pelatihan
            </span>
            <h1 class="mb-6 text-3xl font-extrabold leading-tight tracking-tight md:text-5xl">{{ $site['services_title'] }}</h1>
            <p class="max-w-3xl text-lg leading-relaxed text-gray-700 md:text-xl dark:text-gray-300">{{ strip_tags((string) $site['services_intro']) }}</p>

            <div class="flex flex-col gap-3 mt-8 sm:flex-row">
                @if ($waLink)
                    <a href="{{ $waLink }}" target="_blank" rel="noopener"
                       class="px-6 py-3 font-semibold text-center text-white transition rounded-lg shadow-sm bg-emerald-500 hover:bg-emerald-600">
                        Undang sebagai pemateri via WhatsApp
                    </a>
                @endif
                <a href="#program" class="px-6 py-3 font-semibold text-center transition bg-white border border-gray-300 rounded-lg hover:border-amber-500 hover:text-amber-600 dark:bg-gray-800 dark:border-gray-600">
                    Lihat program pelatihan
                </a>
            </div>

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

    {{-- Program pelatihan --}}
    @if ($services)
        <section id="program" class="px-4 py-16 bg-white dark:bg-gray-800">
            <div class="max-w-6xl mx-auto" data-reveal>
                <x-section-heading title="Program Seminar, Workshop & Pelatihan" class="mb-4" />
                <p class="max-w-3xl mx-auto mb-10 text-center text-gray-600 dark:text-gray-400">
                    Materi disesuaikan dengan profil peserta dan tujuan acara. Berikut program yang paling sering dibawakan.
                </p>
                <div class="grid gap-6 md:grid-cols-2">
                    @foreach ($services as $service)
                        <article class="p-6 border-l-4 shadow-sm rounded-xl bg-gray-50 border-amber-500 dark:bg-gray-900">
                            <h3 class="text-xl font-bold leading-snug">{{ $service['title'] }}</h3>
                            @if (filled($service['audience'] ?? null))
                                <p class="mt-1 text-sm font-semibold text-amber-700 dark:text-amber-400">Untuk: {{ $service['audience'] }}</p>
                            @endif
                            @if (filled($service['description'] ?? null))
                                <p class="mt-3 text-gray-700 dark:text-gray-300">{{ $service['description'] }}</p>
                            @endif
                            @if (! empty($service['topics']))
                                <ul class="flex flex-wrap gap-2 mt-4">
                                    @foreach ((array) $service['topics'] as $topic)
                                        <li class="px-3 py-1 text-xs font-semibold bg-white border border-gray-200 rounded-full dark:bg-gray-800 dark:border-gray-700">{{ $topic }}</li>
                                    @endforeach
                                </ul>
                            @endif
                        </article>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- Format, area layanan, kredensial --}}
    <section class="px-4 py-16">
        <div class="grid max-w-6xl gap-8 mx-auto md:grid-cols-3" data-reveal>
            @if ($formats)
                <div class="p-6 bg-white shadow-sm rounded-xl dark:bg-gray-800">
                    <h2 class="mb-4 text-xl font-bold">Format acara</h2>
                    <ul class="space-y-2 text-gray-700 list-disc list-inside dark:text-gray-300">
                        @foreach ($formats as $format)
                            <li>{{ $format }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if ($areas)
                <div class="p-6 bg-white shadow-sm rounded-xl dark:bg-gray-800">
                    <h2 class="mb-4 text-xl font-bold">Area layanan</h2>
                    <p class="mb-3 text-sm text-gray-600 dark:text-gray-400">
                        Pemateri dan trainer dari {{ $site['seo_city'] ?: 'Lampung' }} — siap hadir di seluruh {{ $site['seo_region'] ?: 'Lampung' }} dan kota lain di Indonesia.
                    </p>
                    <ul class="flex flex-wrap gap-2">
                        @foreach ($areas as $area)
                            <li class="px-3 py-1 text-xs font-semibold rounded-full text-amber-800 bg-amber-100 dark:text-amber-300 dark:bg-amber-500/10">{{ $area }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if ($credentials || $achievements->isNotEmpty())
                <div class="p-6 bg-white shadow-sm rounded-xl dark:bg-gray-800">
                    <h2 class="mb-4 text-xl font-bold">Kredensial &amp; penghargaan</h2>
                    <ul class="space-y-2 text-sm text-gray-700 dark:text-gray-300">
                        @foreach ($credentials as $credential)
                            <li class="flex gap-2"><span class="text-amber-600" aria-hidden="true">✔</span>{{ $credential }}</li>
                        @endforeach
                        @foreach ($achievements as $achievement)
                            <li class="flex gap-2"><span class="text-amber-600" aria-hidden="true">★</span>
                                @if ($achievement->url)
                                    <a href="{{ $achievement->url }}" target="_blank" rel="noopener" class="underline decoration-amber-500/50 underline-offset-4 hover:text-amber-600">{{ $achievement->title }}</a>
                                @else
                                    {{ $achievement->title }}
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    </section>

    {{-- Cara mengundang --}}
    <section class="px-4 py-16 bg-white dark:bg-gray-800">
        <div class="max-w-4xl mx-auto" data-reveal>
            <x-section-heading title="Cara Mengundang Pemateri" class="mb-10" />
            <ol class="grid gap-6 md:grid-cols-3">
                @foreach ([
                    ['Kirim detail acara', 'Hubungi via WhatsApp: nama instansi, tanggal, lokasi (offline/online), jumlah dan profil peserta.'],
                    ['Diskusi kebutuhan', 'Tentukan tema, tujuan, dan format — seminar, workshop, in-house training, atau webinar.'],
                    ['Konfirmasi & pelaksanaan', 'Terima penawaran, kunci jadwal, lalu materi disiapkan sesuai kebutuhan peserta.'],
                ] as [$step, $text])
                    <li class="relative p-6 pt-10 rounded-xl bg-gray-50 dark:bg-gray-900">
                        <span class="absolute flex items-center justify-center w-10 h-10 font-bold text-white rounded-full -top-4 left-6 bg-amber-600">{{ $loop->iteration }}</span>
                        <h3 class="mb-2 font-bold">{{ $step }}</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ $text }}</p>
                    </li>
                @endforeach
            </ol>
        </div>
    </section>

    {{-- FAQ: juga dibaca Google & mesin AI lewat FAQPage schema --}}
    @if ($faqs)
        <section id="faq" class="px-4 py-16">
            <div class="max-w-4xl mx-auto" data-reveal>
                <x-section-heading title="Pertanyaan yang Sering Diajukan" class="mb-10" />
                <div class="space-y-4">
                    @foreach ($faqs as $faq)
                        <details class="p-6 transition bg-white border-l-4 border-transparent shadow-sm group rounded-xl open:border-amber-500 open:shadow-md dark:bg-gray-800" @if ($loop->first) open @endif>
                            <summary class="flex items-center justify-between gap-4 text-lg font-semibold list-none cursor-pointer [&::-webkit-details-marker]:hidden">
                                <h3>{{ $faq['question'] }}</h3>
                                <span class="flex items-center justify-center flex-shrink-0 w-8 h-8 transition rounded-full bg-amber-100 text-amber-600 group-open:rotate-180 dark:bg-amber-500/10">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" /></svg>
                                </span>
                            </summary>
                            <p class="mt-4 text-gray-700 dark:text-gray-300">{{ strip_tags($faq['answer']) }}</p>
                        </details>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- Artikel terkait --}}
    @if ($posts->isNotEmpty())
        <section class="max-w-6xl px-4 pb-8 mx-auto" data-reveal>
            <div class="flex items-center justify-between gap-4 mb-8">
                <x-section-heading title="Artikel & Kegiatan Terbaru" align="left" />
                <a href="{{ route('posts.index') }}" class="font-semibold text-amber-600 hover:text-amber-700 whitespace-nowrap">Lihat semua &rarr;</a>
            </div>
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
                @foreach ($posts as $post)
                    @include('posts._card', ['post' => $post])
                @endforeach
            </div>
        </section>
    @endif

    {{-- CTA --}}
    @if ($waLink)
        <section class="px-4 pt-8 pb-20" data-reveal>
            <div class="relative max-w-5xl px-6 mx-auto overflow-hidden text-center text-white bg-gray-900 shadow-xl py-14 rounded-3xl md:px-12 dark:bg-gray-800 dark:ring-1 dark:ring-white/10">
                <div aria-hidden="true" class="absolute rounded-full pointer-events-none -top-24 -right-16 w-72 h-72 bg-amber-500/30 blur-3xl"></div>
                <div class="relative">
                    <h2 class="mb-4 text-3xl font-bold md:text-4xl">Butuh pemateri untuk acara Anda?</h2>
                    <p class="max-w-2xl mx-auto mb-8 text-lg text-gray-300">Ceritakan kebutuhan seminar, workshop, atau pelatihan Anda — di {{ $site['seo_region'] ?: 'Lampung' }} maupun kota lain di Indonesia.</p>
                    <a href="{{ $waLink }}" target="_blank" rel="noopener"
                       class="inline-flex items-center gap-2 px-8 py-3 font-semibold text-white transition rounded-full shadow-lg bg-emerald-500 hover:bg-emerald-600 hover:-translate-y-0.5">
                        Hubungi via WhatsApp
                    </a>
                </div>
            </div>
        </section>
    @endif
</div>
@endsection
