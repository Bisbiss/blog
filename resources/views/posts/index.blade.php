@extends('layouts.app')

@section('title', 'Artikel')
@section('meta_description', 'Kumpulan artikel, tips, dan kegiatan terbaru dari ' . $site['site_name'] . '.')

@section('content')
<div class="px-4 py-10 mx-auto max-w-6xl">
    <div class="mb-10 text-center">
        <h1 class="text-3xl font-extrabold tracking-tight md:text-4xl">{{ $site['articles_title'] }}</h1>
        <span class="block w-16 h-1 mx-auto mt-3 rounded-full bg-amber-500" aria-hidden="true"></span>
    </div>

    @if ($posts->isNotEmpty())
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
            @foreach ($posts as $post)
                @include('posts._card', ['post' => $post])
            @endforeach
        </div>
    @else
        <p class="text-center text-gray-600 dark:text-gray-400">Belum ada artikel.</p>
    @endif

    <div class="mt-8">
        {{ $posts->links() }}
    </div>
</div>
@endsection
