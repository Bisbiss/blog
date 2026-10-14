<article class="{{ $class ?? '' }} flex flex-col overflow-hidden bg-white shadow-md group rounded-xl card-lift dark:bg-gray-800">
    <a href="{{ route('posts.show', $post) }}" class="block overflow-hidden">
        @if ($post->image)
            <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}" loading="lazy" class="object-cover w-full transition duration-500 h-44 group-hover:scale-105">
        @else
            <div class="flex items-center justify-center w-full text-gray-500 bg-gray-200 h-44 dark:bg-gray-700">
                No Image
            </div>
        @endif
    </a>
    <div class="flex flex-col flex-1 p-4">
        <span class="self-start inline-block px-2.5 py-0.5 mb-2 text-xs font-semibold rounded-full text-amber-700 bg-amber-100 dark:text-amber-300 dark:bg-amber-500/10">
            {{ $post->category->name ?? 'Uncategorized' }}
        </span>
        <h3 class="mb-2 text-lg font-semibold leading-snug line-clamp-2">
            <a href="{{ route('posts.show', $post) }}" title="{{ $post->title }}" class="transition-colors hover:text-amber-600">{{ $post->title }}</a>
        </h3>
        <p class="mb-3 text-sm text-gray-600 dark:text-gray-400 line-clamp-3">
            {{ $post->excerpt(120) }}
        </p>
        <div class="flex items-center justify-between pt-2 mt-auto text-xs text-gray-500">
            <span>{{ $post->created_at->translatedFormat('d M Y') }} · {{ $post->readingTime() }} menit baca</span>
            <a href="{{ route('posts.show', $post) }}" class="font-semibold text-amber-600 hover:text-amber-700">Baca &rarr;</a>
        </div>
    </div>
</article>
