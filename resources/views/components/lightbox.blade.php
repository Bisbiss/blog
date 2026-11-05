{{-- Pratinjau foto layar penuh untuk link ber-atribut data-lightbox. Bisa digeser (swipe) dan pakai tombol panah keyboard. --}}
<dialog id="lightbox" aria-label="Pratinjau foto"
        class="fixed inset-0 w-full h-full max-w-full max-h-full p-0 m-0 text-white border-0 bg-black/90 open:flex open:flex-col open:items-center open:justify-center">
    <button type="button" data-lightbox-close aria-label="Tutup"
            class="absolute flex items-center justify-center w-10 h-10 transition rounded-full top-4 right-4 bg-white/10 hover:bg-amber-600">
        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" /></svg>
    </button>

    <button type="button" data-lightbox-prev aria-label="Foto sebelumnya"
            class="absolute items-center justify-center hidden w-12 h-12 -translate-y-1/2 rounded-full left-4 top-1/2 bg-white/10 hover:bg-amber-600 md:flex">
        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" /></svg>
    </button>
    <button type="button" data-lightbox-next aria-label="Foto berikutnya"
            class="absolute items-center justify-center hidden w-12 h-12 -translate-y-1/2 rounded-full right-4 top-1/2 bg-white/10 hover:bg-amber-600 md:flex">
        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" /></svg>
    </button>

    <img data-lightbox-image alt="" class="object-contain max-w-[92vw] max-h-[80vh] rounded-lg select-none">
    <p class="px-4 mt-4 text-center">
        <span data-lightbox-caption class="font-semibold"></span>
        <span data-lightbox-counter class="block mt-1 text-sm text-gray-400"></span>
    </p>
</dialog>
