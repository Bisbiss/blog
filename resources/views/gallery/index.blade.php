@extends('layouts.app')

@section('title', 'Gallery')
@section('meta_description', 'Galeri foto kegiatan ' . $site['site_name'] . '.')

@section('content')
<div class="px-4 py-10 mx-auto max-w-6xl">
    <div class="mb-10 text-center">
        <h1 class="text-3xl font-extrabold tracking-tight md:text-4xl">{{ $site['gallery_title'] }}</h1>
        <span class="block w-16 h-1 mx-auto mt-3 rounded-full bg-amber-500" aria-hidden="true"></span>
    </div>

    @if ($galleries->isNotEmpty())
        <div class="grid grid-cols-2 gap-4 md:gap-6 lg:grid-cols-4">
            @foreach ($galleries as $item)
                @include('gallery._card', ['item' => $item])
            @endforeach
        </div>
    @else
        <p class="text-center text-gray-600 dark:text-gray-400">Belum ada foto.</p>
    @endif

    <div class="mt-8">
        {{ $galleries->links() }}
    </div>
</div>

<x-lightbox />
@endsection
