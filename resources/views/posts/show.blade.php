@extends('layouts.app')

@section('title', $post->title)

@section('content')
<div class="bg-gray-100 dark:bg-gray-900 text-gray-800 dark:text-gray-200 px-5">
    <div class="container max-w-5xl mx-auto px-4 py-8">
        <div class="card bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
            @if($post->image)
                <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}" class="w-full h-100 object-cover">
            @endif
            <div class="card-body p-6">
                <h1 class="card-title text-3xl font-bold mb-4">{{ $post->title }}</h1>
                <div class="flex justify-between mb-6 text-sm text-gray-500 dark:text-gray-400">
                    <span class="bg-amber-500 text-white font-semibold p-2 rounded">Category: {{ $post->category->name ?? 'Uncategorized' }}</span>
                    <span>Posted on {{ $post->created_at->format('M d, Y') }}</span>
                </div>
                <div class="card-text prose dark:prose-invert max-w-none">
                    {!! $post->content !!}
                </div>
            </div>
            <div class="card-footer p-6 bg-gray-50 dark:bg-gray-900 text-right">
                <a href="{{ url('/posts') }}" class="inline-block bg-amber-600 hover:bg-amber-700 text-white font-semibold py-2 px-4 rounded transition">
                    &larr; Back to Posts
                </a>
            </div>
        </div>
    </div>
</div>
@endsection