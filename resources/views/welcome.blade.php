@extends('layouts.app')

@section('title', 'Syaifulloh')

@section('content')
<div class="bg-gray-100 dark:bg-gray-900 text-gray-800 dark:text-gray-200 px-5">

    {{-- Hero Section --}}
    <section class="min-h-screen flex flex-col md:flex-row justify-center items-center text-center md:text-left px-4 gap-8">
        <div class="container mx-auto max-w-7xl">
            <div class="md:flex md:items-center md:gap-8">
                {{-- Left Column --}}
                <div class="md:w-1/2 flex flex-col justify-center items-center md:items-start px-5">
                    <h1 class="text-5xl font-extrabold mb-4">Hi 👋</h1>
                    <h1 class="text-5xl font-extrabold mb-4">Saya Syaifulloh</h1>
                    <p class="text-lg max-w-md mb-6">
                        seorang pengusaha muda asli Lampung dan sebagai Trainer dan Motivator. Namun ia lebih dikenal The Most Wanted Indonesian Hypnotherapy instructor, kini ia lebih kenal sebagai MOTIVATOR DAN PENGUSAHA MUDA.
                    </p>
                    <div class="flex gap-4">
                        <a href="https://www.instagram.com/mr.syaifulloh/" target="_blank" rel="noopener" class="bg-amber-600 hover:bg-amber-700 text-white font-semibold py-3 px-6 rounded-lg transition">
                            Instagram
                        </a>
                        <a href="https://www.linkedin.com/in/syaifulloh17/" target="_blank" rel="noopener" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg transition">
                            LinkedIn
                        </a>
                    </div>
                </div>

                {{-- Right Column --}}
                <div class="md:w-1/2 px-4">
                    <img src="/image/syaifulloh.png" alt="Syaifulloh" class="rounded-lg shadow-lg mx-auto md:mx-0 max-w-full h-auto">
                </div>
            </div>
        </div>
    </section>

    {{-- About Section --}}
    <section id="about" class="max-w-5xl mx-auto py-16 px-4">
        <h2 class="text-3xl font-bold mb-8 text-center">About Me</h2>
        <div class="md:flex md:items-center md:gap-12 max-w-4xl mx-auto">
            {{-- Left: Image --}}
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden md:w-1/2 mb-8 md:mb-0">
                <img src="/image/about.png" alt="Syaifulloh" class="rounded-lg shadow-lg w-full h-auto object-cover">
            </div>

            {{-- Right: Text --}}
            <div class="md:w-1/2 text-gray-700 dark:text-gray-300 leading-relaxed space-y-6 text-center md:text-left">
                <p class="text-lg font-semibold">
                    Hi, nama saya <span class="text-amber-600 dark:text-amber-400">Syaifulloh</span>, saya sangatlah mencintai dunia pemberdayaan diri dan lingkungan.
                </p>
                <p>
                    Kecintaannya terhadap pemberdayaan manusia membawanya mempelajari dan mengembangkan banyak program edukasi dan bisnis serta training di Lampung.
                </p>
                <p>
                    Sebagai bentuk pengabdiannya, Syaiful menjadi seorang <strong>Founder dan CEO Lampung Cerdas</strong> yang dan juga ia sebagai <strong>Founder Positifsukses.com</strong>.
                </p>
                <p>
                    Selain itu ia juga fokus untuk mengembangkan skill-skill para milenial agar siap menghadapi tantangan masa depan.
                </p>
            </div>
        </div>
    </section>

    {{-- Expertise Section --}}
    <section id="expertise" class="bg-white dark:bg-gray-800 py-16 px-4">
        <h2 class="text-3xl font-bold mb-6 text-center">My Expertise</h2>
        <div class="max-w-5xl mx-auto grid grid-cols-1 sm:grid-cols-4 gap-8 text-center">
            <div class="bg-white dark:bg-gray-900 rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow duration-300">
                <h3 class="font-semibold text-xl mb-2">Public Speaking</h3>
                <p>Confidently delivering engaging and impactful presentations.</p>
            </div>
            <div class="bg-white dark:bg-gray-900 rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow duration-300">
                <h3 class="font-semibold text-xl mb-2">Business</h3>
                <p>Experienced in entrepreneurship and business development.</p>
            </div>
            <div class="bg-white dark:bg-gray-900 rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow duration-300">
                <h3 class="font-semibold text-xl mb-2">Hypnotherapy</h3>
                <p>Skilled in therapeutic techniques to improve mental well-being.</p>
            </div>
            <div class="bg-white dark:bg-gray-900 rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow duration-300">
                <h3 class="font-semibold text-xl mb-2">Leadership</h3>
                <p>Leading teams effectively to achieve goals and growth.</p>
            </div>
        </div>
    </section>

    {{-- Artikel (Articles) Section --}}
    <section id="artikel" class="max-w-5xl mx-auto py-16 px-4">
        <h2 class="text-3xl font-bold mb-6 text-center">Artikel</h2>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-8">
            @foreach($posts as $post)
                <article class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
                    @if($post->image)
                        <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}" class="w-full h-48 object-cover">
                    @else
                        <div class="w-full h-48 bg-gray-300 dark:bg-gray-700 flex items-center justify-center text-gray-500">
                            No Image
                        </div>
                    @endif
                    <div class="p-4">
                        <span class="inline-block bg-amber-600 text-white text-xs font-semibold px-2 py-1 rounded mb-2">
                            {{ $post->category->name ?? 'Uncategorized' }}
                        </span>
                        <h3 class="font-semibold text-lg mb-2">
                            <a href="{{ url('/posts/' . $post->id) }}" class="hover:text-amber-600">
                                {{ $post->title }}
                            </a>
                        </h3>
                    </div>
                </article>
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="mt-8">
            {{ $posts->links() }}
        </div>
    </section>

    {{-- Galeri (Gallery) Section --}}
    <section id="galeri" class="bg-white dark:bg-gray-800 py-16 px-4">
        <h2 class="text-3xl font-bold mb-6 text-center">Gallery</h2>
        <div class="max-w-5xl mx-auto grid grid-cols-1 sm:grid-cols-3 gap-6">
            @foreach($galleryItems as $item)
                <div class="bg-white dark:bg-gray-900 rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                    <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item['title'] }}" class="w-full h-50 object-cover rounded-t-lg">
                    <div class="p-4 text-center">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 truncate" title="{{ $item['title'] }}">
                            {{ $item['title'] }}
                        </h3>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    {{-- Achievement Section with 2 columns: left text list, right image slider --}}
    <section id="achievement" class="max-w-5xl mx-auto py-16 px-4">
        <h2 class="text-3xl font-bold mb-8 text-center">Achievements</h2>
        <div class="md:flex md:gap-12 max-w-4xl mx-auto">
            {{-- Left: Achievement List --}}
            <ul class="md:w-1/2 list-disc list-inside space-y-6 text-gray-700 dark:text-gray-300">
                <li class="flex items-start gap-3">
                    <svg class="w-6 h-6 text-amber-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.974a1 1 0 00.95.69h4.18c.969 0 1.371 1.24.588 1.81l-3.388 2.462a1 1 0 00-.364 1.118l1.287 3.974c.3.922-.755 1.688-1.54 1.118l-3.388-2.462a1 1 0 00-1.175 0l-3.388 2.462c-.784.57-1.838-.196-1.54-1.118l1.287-3.974a1 1 0 00-.364-1.118L2.045 9.4c-.783-.57-.38-1.81.588-1.81h4.18a1 1 0 00.95-.69l1.286-3.974z"/>
                    </svg>
                    <a href="https://muri.org/Website/Rekor_detail/edukasi_masuk_perguruan_tinggi_secara_digital_kepada_pelajar_terbanyak" target="_blank" class="underline hover:text-amber-600" rel="noopener">
                        Rekor MURI: Edukasi masuk perguruan tinggi secara digital kepada pelajar terbanyak
                    </a>
                </li>
                <li class="flex items-start gap-3">
                    <svg class="w-6 h-6 text-amber-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.974a1 1 0 00.95.69h4.18c.969 0 1.371 1.24.588 1.81l-3.388 2.462a1 1 0 00-.364 1.118l1.287 3.974c.3.922-.755 1.688-1.54 1.118l-3.388-2.462a1 1 0 00-1.175 0l-3.388 2.462c-.784.57-1.838-.196-1.54-1.118l1.287-3.974a1 1 0 00-.364-1.118L2.045 9.4c-.783-.57-.38-1.81.588-1.81h4.18a1 1 0 00.95-.69l1.286-3.974z"/>
                    </svg>
                    The Great Champions of Asia Top Millennials Choice in Education Program Award 2024
                </li>
                <li class="flex items-start gap-3">
                    <svg class="w-6 h-6 text-amber-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.974a1 1 0 00.95.69h4.18c.969 0 1.371 1.24.588 1.81l-3.388 2.462a1 1 0 00-.364 1.118l1.287 3.974c.3.922-.755 1.688-1.54 1.118l-3.388-2.462a1 1 0 00-1.175 0l-3.388 2.462c-.784.57-1.838-.196-1.54-1.118l1.287-3.974a1 1 0 00-.364-1.118L2.045 9.4c-.783-.57-.38-1.81.588-1.81h4.18a1 1 0 00.95-.69l1.286-3.974z"/>
                    </svg>
                    BEST PERFORMING BUSINESS WINNER 2022 – Indonesia Award Magazine
                </li>
                <li class="flex items-start gap-3">
                    <svg class="w-6 h-6 text-amber-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.974a1 1 0 00.95.69h4.18c.969 0 1.371 1.24.588 1.81l-3.388 2.462a1 1 0 00-.364 1.118l1.287 3.974c.3.922-.755 1.688-1.54 1.118l-3.388-2.462a1 1 0 00-1.175 0l-3.388 2.462c-.784.57-1.838-.196-1.54-1.118l1.287-3.974a1 1 0 00-.364-1.118L2.045 9.4c-.783-.57-.38-1.81.588-1.81h4.18a1 1 0 00.95-.69l1.286-3.974z"/>
                    </svg>
                    Pioner Trainer Muda (19th) Nasional asal Lampung
                </li>
            </ul>

            {{-- Right: Image Slider --}}
            <div class="md:w-1/2 mt-8 md:mt-0">
                <div class="relative w-full overflow-hidden rounded-lg shadow-lg">
                    <div class="slider flex transition-transform duration-500">
                        <img src="/image/syaifulloh.png" alt="Achievement 1" class="w-full h-100 bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden object-cover flex-shrink-0">
                        <img src="/image/about.png" alt="Achievement 2" class="w-full h-100 bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden object-cover flex-shrink-0">
                        <img src="/image/syaifulloh.png" alt="Achievement 3" class="w-full h-100 bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden object-cover flex-shrink-0">
                        <img src="/image/about.png" alt="Achievement 4" class="w-full h-100 bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden object-cover flex-shrink-0">
                    </div>
                    {{-- Slider controls --}}
                    <button id="achievementPrevBtn" class="absolute top-1/2 left-2 transform -translate-y-1/2 bg-amber-600 text-white rounded-full p-2 hover:bg-amber-700 transition">
                        &#10094;
                    </button>
                    <button id="achievementNextBtn" class="absolute top-1/2 right-2 transform -translate-y-1/2 bg-amber-600 text-white rounded-full p-2 hover:bg-amber-700 transition">
                        &#10095;
                    </button>
                </div>
            </div>
        </div>
    </section>

    {{-- Kontak (Contact) Section --}}
    <section id="kontak" class="bg-white dark:bg-gray-800 py-16 px-4">
        <h2 class="text-3xl font-bold mb-6 text-center">Contact Me</h2>
        <form action="/contact" method="POST" class="max-w-xl mx-auto space-y-6">
            @csrf
            <input type="text" name="name" placeholder="Your Name" required class="w-full p-3 rounded border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
            <input type="email" name="email" placeholder="Your Email" required class="w-full p-3 rounded border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
            <textarea name="message" rows="5" placeholder="Your Message" required class="w-full p-3 rounded border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100"></textarea>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg transition w-full">Send Message</button>
        </form>
    </section>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const slider = document.querySelector('#achievement .slider');
        const prevBtn = document.getElementById('achievementPrevBtn');
        const nextBtn = document.getElementById('achievementNextBtn');
        const totalSlides = slider.children.length;
        let index = 0;

        function updateSlider() {
            slider.style.transform = `translateX(-${index * 100}%)`;
        }

        prevBtn.addEventListener('click', () => {
            index = (index === 0) ? totalSlides - 1 : index - 1;
            updateSlider();
        });

        nextBtn.addEventListener('click', () => {
            index = (index === totalSlides - 1) ? 0 : index + 1;
            updateSlider();
        });
    });
</script>
@endsection