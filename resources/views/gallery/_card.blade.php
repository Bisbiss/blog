<figure class="{{ $class ?? '' }} overflow-hidden bg-white shadow-md group rounded-xl card-lift dark:bg-gray-900">
    <a href="{{ asset('storage/' . $item->image) }}" data-lightbox="gallery" data-caption="{{ $item->title }}" class="relative block overflow-hidden">
        <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->title }}" loading="lazy" class="object-cover w-full transition duration-500 aspect-[4/3] group-hover:scale-105">
        <span aria-hidden="true" class="absolute inset-0 flex items-center justify-center transition opacity-0 bg-black/30 group-hover:opacity-100">
            <span class="flex items-center justify-center w-12 h-12 text-white rounded-full bg-amber-600">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607ZM10.5 7.5v6m3-3h-6" /></svg>
            </span>
        </span>
    </a>
    <figcaption class="p-3 font-semibold text-center text-gray-800 truncate dark:text-gray-200" title="{{ $item->title }}">
        {{ $item->title }}
    </figcaption>
</figure>
