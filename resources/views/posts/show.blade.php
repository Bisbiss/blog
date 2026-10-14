@extends('layouts.app')

@section('title', $post->title)
@section('meta_description', $post->excerpt())
@section('og_type', 'article')
@if ($post->image)
    @section('meta_image', asset('storage/' . $post->image))
@endif

@push('head')
    <meta property="article:published_time" content="{{ $post->created_at->toIso8601String() }}">
    <meta property="article:modified_time" content="{{ $post->updated_at->toIso8601String() }}">
@endpush

@php
    $postUrl = route('posts.show', $post);
    $shareLinks = [
        'WhatsApp' => 'https://wa.me/?text=' . rawurlencode($post->title . ' ' . $postUrl),
        'Facebook' => 'https://www.facebook.com/sharer/sharer.php?u=' . rawurlencode($postUrl),
        'X' => 'https://twitter.com/intent/tweet?url=' . rawurlencode($postUrl) . '&text=' . rawurlencode($post->title),
    ];
@endphp

@section('content')
<div class="max-w-4xl px-4 py-8 mx-auto">
    <nav class="mb-4 text-sm text-gray-500 dark:text-gray-400" aria-label="Breadcrumb">
        <a href="{{ route('home') }}" class="hover:text-amber-600">Beranda</a>
        <span class="mx-1">/</span>
        <a href="{{ route('posts.index') }}" class="hover:text-amber-600">Artikel</a>
    </nav>

    <article class="overflow-hidden bg-white shadow-md rounded-xl dark:bg-gray-800">
        @if ($post->image)
            <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}" class="object-cover w-full max-h-[28rem]">
        @endif
        <div class="p-6 md:p-10">
            <span class="inline-block px-2.5 py-0.5 mb-4 text-xs font-semibold rounded-full text-amber-700 bg-amber-100 dark:text-amber-300 dark:bg-amber-500/10">
                {{ $post->category->name ?? 'Uncategorized' }}
            </span>
            <h1 class="mb-4 text-3xl font-bold leading-tight md:text-4xl">{{ $post->title }}</h1>
            <div class="flex flex-wrap items-center gap-x-4 gap-y-1 pb-6 mb-6 text-sm text-gray-500 border-b border-gray-200 dark:text-gray-400 dark:border-gray-700">
                <time datetime="{{ $post->created_at->toDateString() }}">{{ $post->created_at->translatedFormat('d M Y') }}</time>
                <span class="inline-flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg>
                    {{ $post->readingTime() }} menit baca
                </span>
            </div>
            <div class="prose max-w-none md:text-lg">
                {!! $post->content !!}
            </div>
        </div>

        <div class="flex flex-col gap-4 p-6 border-t border-gray-200 md:px-10 sm:flex-row sm:items-center sm:justify-between bg-gray-50 dark:bg-gray-900 dark:border-gray-700">
            <div class="flex flex-wrap items-center gap-2 text-sm">
                <span class="mr-1 font-semibold">Bagikan:</span>
                @foreach ($shareLinks as $label => $url)
                    <a href="{{ $url }}" target="_blank" rel="noopener"
                       class="px-3 py-1 font-semibold transition border border-gray-300 rounded-full hover:border-amber-500 hover:text-amber-600 dark:border-gray-600">
                        {{ $label }}
                    </a>
                @endforeach
                <button type="button" data-copy-link="{{ $postUrl }}"
                        class="inline-flex items-center gap-1 px-3 py-1 font-semibold transition border border-gray-300 rounded-full hover:border-amber-500 hover:text-amber-600 dark:border-gray-600">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M13.19 8.688a4.5 4.5 0 0 1 1.242 7.244l-4.5 4.5a4.5 4.5 0 0 1-6.364-6.364l1.757-1.757m13.35-.622 1.757-1.757a4.5 4.5 0 0 0-6.364-6.364l-4.5 4.5a4.5 4.5 0 0 0 1.242 7.244" /></svg>
                    <span data-copy-label>Salin link</span>
                </button>
            </div>
            <a href="{{ route('posts.index') }}" class="inline-block px-4 py-2 font-semibold text-center text-white transition rounded-lg bg-amber-600 hover:bg-amber-700">
                &larr; Kembali ke Artikel
            </a>
        </div>
    </article>
</div>

@if ($related->isNotEmpty())
    <section class="max-w-6xl px-4 pt-8 pb-16 mx-auto" data-reveal>
        <x-section-heading title="Artikel Lainnya" align="left" class="mb-8" />
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
            @foreach ($related as $item)
                @include('posts._card', ['post' => $item])
            @endforeach
        </div>
    </section>
@endif
@endsection
