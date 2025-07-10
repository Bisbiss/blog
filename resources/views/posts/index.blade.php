@extends('layouts.app')

@section('title', 'All Posts')

@section('content')
<div class="bg-gray-100 dark:bg-gray-900 text-gray-800 dark:text-gray-200 px-5">
    <div class="container max-w-7xl mx-auto px-4 py-8">
        <div class="mb-8 text-center">
            <h1 class="text-3xl font-extrabold text-amber-600 dark:text-amber-400">Latest Posts</h1>
            <p class="text-gray-600 dark:text-gray-300 mt-2">Discover the latest articles and insights</p>
        </div>

        <div class="grid gap-6 grid-cols-1 sm:grid-cols-3 max-h-[calc(2*22rem+1.5rem)] overflow-hidden">
            @forelse($posts->take(6) as $post)
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300 max-h-88">
                    @if($post->image)
                        <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}" class="w-full h-44 object-cover">
                    @else
                        <div class="w-full h-44 bg-gray-200 dark:bg-gray-700 flex items-center justify-center text-gray-500">
                            No Image
                        </div>
                    @endif
                    <div class="p-4">
                        <span class="inline-block bg-amber-600 text-white text-xs font-semibold px-2 py-1 rounded-full mb-2">
                            {{ $post->category->name ?? 'Uncategorized' }}
                        </span>
                        <h3 class="text-lg font-semibold mb-1 hover:text-amber-600 transition-colors truncate">
                            <a href="{{ url('/posts/' . $post->slug) }}" title="{{ $post->title }}">{{ $post->title }}</a>
                        </h3>
                        <p class="text-gray-600 dark:text-gray-400 text-sm mb-3 line-clamp-3">
                            {!! Str::limit(strip_tags($post->content), 100) !!}
                        </p>
                        <a href="{{ url('/posts/' . $post->slug) }}" class="inline-block bg-amber-600 hover:bg-amber-700 text-white font-semibold py-1 px-3 rounded transition text-sm">
                            Read More
                        </a>
                    </div>
                    <div class="px-4 py-2 bg-gray-100 dark:bg-gray-900 text-gray-500 text-xs">
                        {{ $post->created_at->format('M d, Y') }}
                    </div>
                </div>
            @empty
                <div class="col-span-3 text-center text-gray-600 dark:text-gray-400">
                    <p>No posts found.</p>
                </div>
            @endforelse
        </div>

        <div class="mt-8 flex justify-center">
            {{ $posts->links() }}
        </div>
    </div>
</div>
@endsection