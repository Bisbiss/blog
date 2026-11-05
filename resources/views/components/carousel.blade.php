@props(['label', 'wrap' => false, 'rows' => 1])

{{-- Carousel geser: swipe di layar sentuh, drag dengan mouse, atau tombol panah. Item diberi class "carousel-item".
     rows="2" menyusun item dalam 2 baris (grid kolom) yang digeser bersama. --}}
<div class="relative" data-carousel @if ($wrap) data-carousel-loop @endif>
    <div {{ $attributes->class([
            'gap-6 pt-1 pb-4 overflow-x-auto snap-x snap-mandatory scroll-smooth no-scrollbar',
            'flex' => $rows < 2,
            'grid grid-flow-col grid-rows-2 carousel-rows-2' => $rows >= 2,
        ]) }}
         data-carousel-track tabindex="0" role="region" aria-roledescription="carousel" aria-label="{{ $label }}">
        {{ $slot }}
    </div>

    <button type="button" data-carousel-prev aria-label="Sebelumnya"
            class="absolute left-0 z-10 items-center justify-center hidden w-10 h-10 text-white transition -translate-x-1/3 -translate-y-1/2 rounded-full shadow-lg top-1/2 bg-amber-600 hover:bg-amber-700 disabled:opacity-0 md:flex">
        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" /></svg>
    </button>
    <button type="button" data-carousel-next aria-label="Berikutnya"
            class="absolute right-0 z-10 items-center justify-center hidden w-10 h-10 text-white transition translate-x-1/3 -translate-y-1/2 rounded-full shadow-lg top-1/2 bg-amber-600 hover:bg-amber-700 disabled:opacity-0 md:flex">
        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" /></svg>
    </button>
</div>
