@extends('layouts.app')

@section('title', 'All Posts')

@section('content')
<div class="px-5 text-gray-800 bg-gray-100 dark:bg-gray-900 dark:text-gray-200">
    <div class="container px-4 py-8 mx-auto max-w-7xl">
        <div class="mb-8 text-center">
            <h1 class="text-3xl font-extrabold text-amber-600 dark:text-amber-400">Latest Posts</h1>
            <p class="mt-2 text-gray-600 dark:text-gray-300">Discover the latest articles and insights</p>
        </div>

        <div class="grid gap-6 grid-cols-1 sm:grid-cols-3 max-h-[calc(2*22rem+1.5rem)] overflow-hidden">
            @forelse($posts->take(6) as $post)
                <div class="overflow-hidden transition-shadow duration-300 bg-white rounded-lg shadow-md dark:bg-gray-800 hover:shadow-lg max-h-88">
                    @if($post->image)
                        <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}" class="object-cover w-full h-44">
                    @else
                        <div class="flex items-center justify-center w-full text-gray-500 bg-gray-200 h-44 dark:bg-gray-700">
                            No Image
                        </div>
                    @endif
                    <div class="p-4">
                        <span class="inline-block px-2 py-1 mb-2 text-xs font-semibold text-white rounded-full bg-amber-600">
                            {{ $post->category->name ?? 'Uncategorized' }}
                        </span>
                        <h3 class="mb-1 text-lg font-semibold truncate transition-colors hover:text-amber-600">
                            <a href="{{ url('/posts/' . $post->slug) }}" title="{{ $post->title }}">{{ $post->title }}</a>
                        </h3>
                        <p class="mb-3 text-sm text-gray-600 dark:text-gray-400 line-clamp-3">
                            {!! Str::limit(strip_tags($post->content), 100) !!}
                        </p>
                        <a href="{{ url('/posts/' . $post->slug) }}" class="inline-block px-3 py-1 text-sm font-semibold text-white transition rounded bg-amber-600 hover:bg-amber-700">
                            Read More
                        </a>
                    </div>
                    <div class="px-4 py-2 text-xs text-gray-500 bg-gray-100 dark:bg-gray-900">
                        {{ $post->created_at->format('M d, Y') }}
                    </div>
                </div>
            @empty
                <div class="col-span-3 text-center text-gray-600 dark:text-gray-400">
                    <p>No posts found.</p>
                </div>
            @endforelse
        </div>

        <div class="flex justify-center mt-8">
            {{ $posts->links() }}
        </div>
    </div>
</div>
@endsection