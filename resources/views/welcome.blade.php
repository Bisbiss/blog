@extends('layouts.app')

@section('title', 'Home')

@section('content')
<div class="px-5 text-gray-800 bg-gray-100 dark:bg-gray-900 dark:text-gray-200">

    {{-- Hero Section with right column first on mobile --}}
    <section class="flex flex-col items-center justify-start min-h-screen gap-8 px-4 md:flex-row md:text-left">
        <div class="container mx-auto max-w-7xl">
            <div class="md:flex md:items-start md:gap-8">
                {{-- Right Column first on mobile --}}
                <div class="order-1 md:w-1/3 md:order-2">
                    <img src="/image/syaifulloh.png" alt="Syaifulloh" class="h-auto max-w-full mx-auto rounded-lg shadow-lg md:mx-0">
                </div>
                {{-- Left Column --}}
                <div class="flex flex-col justify-start order-2 px-5 md:w-2/3 md:order-1">
                    <h1 class="mb-4 text-4xl font-extrabold">Hi 👋</h1>
                    <h1 class="mb-4 text-4xl font-extrabold">Saya Syaifulloh</h1>
                    <p class="max-w-full mb-6">
                        Seorang pengusaha asal Lampung, Indonesia. Selain menjalankan bisnis, saya juga dikenal sebagai pembicara publik, motivator, trainer, dan learning facilitator.
                        <br><br>
                        Selama lebih dari 13 tahun, saya telah mengabdikan diri di dunia pelatihan dan pengembangan SDM. Saya berpengalaman membawakan berbagai sesi di lingkungan korporasi, universitas, sekolah, perusahaan swasta, hingga pelaku UKM—baik skala kecil maupun besar.
                    </p>
                    <div class="flex flex-col gap-2 sm:flex-row">
                        <a href="https://www.instagram.com/mr.syaifulloh/" target="_blank" rel="noopener" class="w-full px-6 py-3 mb-2 font-semibold text-center text-white transition bg-pink-600 rounded-lg hover:bg-pink-700 sm:w-auto sm:mb-0">
                            Instagram
                        </a>
                        <a href="https://www.linkedin.com/in/syaifulloh17/" target="_blank" rel="noopener" class="w-full px-6 py-3 mb-2 font-semibold text-center text-white transition rounded-lg bg-sky-600 hover:bg-sky-700 sm:w-auto sm:mb-0">
                            LinkedIn
                        </a>
                        <a href="https://www.tiktok.com/@mr.syaifulloh?is_from_webapp=1&sender_device=pc" target="_blank" rel="noopener" class="w-full px-6 py-3 font-semibold text-center text-white transition rounded-lg bg-slate-600 hover:bg-slate-700 sm:w-auto">
                            Tiktok
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- About Section --}}
    <section id="about" class="max-w-5xl px-4 py-16 mx-auto">
        <h2 class="mb-8 text-3xl font-bold text-center">About Me</h2>
        <div class="max-w-4xl mx-auto md:flex md:items-center md:gap-12">
            {{-- Left: Image --}}
            <div class="mb-8 overflow-hidden bg-white rounded-lg shadow dark:bg-gray-800 md:w-1/2 md:mb-0">
                <img src="/image/about.png" alt="Syaifulloh" class="object-cover w-full h-auto rounded-lg shadow-lg">
            </div>

            {{-- Right: Text --}}
            <div class="space-y-6 leading-relaxed text-center text-gray-700 md:w-1/2 dark:text-gray-300 md:text-left">
                <p>
                    Kecintaan saya terhadap pemberdayaan manusia membawa saya secara serius untuk mengembangkan banyak program edukasi, bisnis & training di indonesia.
                </p>
                <p>
                    Dengan semangat membangun generasi cerdas dan tangguh, saya terus berkomitmen untuk menyebarkan inspirasi, pengetahuan, dan strategi pertumbuhan yang berdampak nyata bagi individu maupun organisasi.
                </p>
            </div>
        </div>
    </section>

    {{-- Detail Section --}}
    <section id="detail" class="max-w-full px-4 py-16 mx-auto bg-white dark:bg-gray-800">
        <div class="container max-w-5xl mx-auto">
            <h2 class="mb-6 text-3xl font-bold text-center">Detail Profile Syaifulloh:</h2>
            <div class="space-y-4">

                {{-- Accordion 1 --}}
                <details class="p-6 bg-white rounded-lg shadow-md dark:bg-gray-900">
                    <summary class="text-xl font-semibold cursor-pointer">Present Activities</summary>
                    <ul class="mt-3 space-y-1 text-gray-700 list-disc list-inside dark:text-gray-300">
                        <li>Founder dan CEO Lampung Cerdas.</li>
                        <li>Founder Youth Inspiration Indonesia.</li>
                        <li>Pembina Yayasan Pemuda Harapan Dunia</li>
                        <li>Trainer dan Motivator</li>
                        <li>Owner Keripik Singkong MADIR</li>
                        <li>Master therapist Hypnotherapy Center Lampung</li>
                        <li>Serta telah menginspirasi anak muda Indonesia lebih dari 2.700.000.</li>
                    </ul>
                </details>

                {{-- Accordion 2 --}}
                <details class="p-6 bg-white rounded-lg shadow-md dark:bg-gray-900">
                    <summary class="text-xl font-semibold cursor-pointer">History Education & Certified</summary>
                    <ul class="mt-3 space-y-1 text-gray-700 list-disc list-inside dark:text-gray-300">
                        <li>S1 Ilmu Pemerintahan - Unila</li>
                        <li>S2 Magister Manajemen - IIB Darmajaya</li>
                        <li>Promotor Stifin</li>
                        <li>Certified Instructor Hypnotherapy (CI) from Indonesian Board of Hypnotherapy (IBH)</li>
                        <li>Certified Hypnotherapy (CHt) from Indonesian Board of Hypnotherapy (IBH)</li>
                        <li>Certified Hypnosis (CH) from Indonesian Board of Hypnotherapy (IBH)</li>
                        <li>Certified NLP Practitioner from Neo NLP Indonesia</li>
                        <li>Certified NLP Master Practitioner from NLP Indonesia</li>
                        <li>Mapping Talent Practitioner</li>
                        <li>Certified Instructor Trainer from BNSP</li>
                        <li>Sekolah CEO 1.0 from BisnisHack Indonesia</li>
                        <li>Sekolah HRD from BisnisHack Indonesia</li>
                        <li>Grounded Business Coaching (GBC) led by Coach Dr. Fahmi</li>
                        <li>Smart Financial Map by Ilmu Keuangan</li>
                    </ul>
                </details>

                {{-- Accordion 3 --}}
                <details class="p-6 bg-white rounded-lg shadow-md dark:bg-gray-900">
                    <summary class="text-xl font-semibold cursor-pointer">Program & Materi yang Sering Saya Bawakan:</summary>
                    <div class="mt-3 space-y-4 text-gray-700 dark:text-gray-300">
                        <p>💡 <strong>Untuk Siswa & Mahasiswa:</strong></p>
                        <ul class="space-y-1 list-disc list-inside">
                            <li>Strategi Lulus Kuliah Impian</li>
                            <li>Hypno Learning & Hypno Teaching</li>
                            <li>Membangun Mental Juara Sejak Muda</li>
                            <li>Growth Mindset & Motivasi Prestasi</li>
                            <li>Kuliah Gratis dan Beasiswa Impian</li>
                            <li>Leadership & Komunikasi untuk Generasi muda</li>
                        </ul>

                        <p>🏢 <strong>Untuk Guru, Dosen & Lembaga Pendidikan:</strong></p>
                        <ul class="space-y-1 list-disc list-inside">
                            <li>Training Hypno Teaching</li>
                            <li>Komunikasi Edukatif & Persuasif</li>
                            <li>Strategi Meningkatkan Semangat Belajar Siswa</li>
                            <li>Pelatihan Public Speaking & Presentation Skill</li>
                        </ul>

                        <p>👔 <strong>Untuk Umum, Komunitas, Instansi & Korporat:</strong></p>
                        <ul class="space-y-1 list-disc list-inside">
                            <li>Personal Branding & Komunikasi Berpengaruh</li>
                            <li>Membangun Tim Hebat & Kolaboratif</li>
                            <li>Mindset Tumbuh untuk Pemimpin Masa Depan</li>
                            <li>Kelas Resiliensi: Bangkit dalam Tekanan</li>
                            <li>Marketing Humanis & Closing Hypnotic</li>
                        </ul>

                        <p>📍 <strong>Fokus Saya Saat Ini:</strong></p>
                        <ul class="space-y-1 list-disc list-inside">
                            <li>Pengembangan SDM & kepemudaan</li>
                            <li>Pendidikan dan mindset pertumbuhan</li>
                            <li>Public speaking dan komunikasi efektif</li>
                            <li>Peningkatan kualitas tenaga pendidik</li>
                            <li>Personal development dan spiritual leadership</li>
                        </ul>
                    </div>
                </details>

            </div>
        </div>
    </section>

    {{-- Media & Publikasi Section --}}
    <section id="media-publikasi" class="max-w-5xl px-4 py-16 mx-auto">
        <h2 class="mb-6 text-3xl font-bold text-center">Media & Publikasi</h2>
        <div class="max-w-4xl mx-auto rounded-lg shadow-lg">
            <img src="/image/media.png" alt="Media & Publikasi" class="object-cover w-full h-auto rounded-lg shadow-lg">
        </div>
    </section>

    {{-- Buku Section with 4 Images and Text Above and Below --}}
    <section id="buku" class="max-w-5xl px-4 py-16 mx-auto">
        <h2 class="mb-6 text-3xl font-bold text-center">Buku</h2>
        <p class="text-2xl text-center text-gray-700 dark:text-gray-300">Saya juga seorang penulis.</p>
        <p class="mb-6 text-xl text-center text-gray-700 dark:text-gray-300">Berikut buku-buku best seller yang pernah saya tulis.</p>

        <div class="grid max-w-4xl grid-cols-2 gap-6 mx-auto mb-6 sm:grid-cols-3">
            <img src="/image/1.jpg" alt="Buku 1" class="object-cover w-full rounded-lg shadow-lg aspect-square">
            <img src="/image/3.jpg" alt="Buku 3" class="object-cover w-full rounded-lg shadow-lg aspect-square">
            <img src="/image/4.jpg" alt="Buku 4" class="object-cover w-full rounded-lg shadow-lg aspect-square">
        </div>

    </section>

    {{-- Artikel (Articles) Section --}}
    <section id="artikel" class="max-w-5xl px-4 py-16 mx-auto">
        <h2 class="mb-6 text-3xl font-bold text-center">Artikel</h2>
        <div class="grid grid-cols-1 gap-8 sm:grid-cols-3">
            @foreach($posts as $post)
                <article class="overflow-hidden bg-white rounded-lg shadow dark:bg-gray-800">
                    @if($post->image)
                        <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}" class="object-cover w-full h-48">
                    @else
                        <div class="flex items-center justify-center w-full h-48 text-gray-500 bg-gray-300 dark:bg-gray-700">
                            No Image
                        </div>
                    @endif
                    <div class="p-4">
                        <span class="inline-block px-2 py-1 mb-2 text-xs font-semibold text-white rounded bg-amber-600">
                            {{ $post->category->name ?? 'Uncategorized' }}
                        </span>
                        <h3 class="mb-2 text-lg font-semibold">
                            <a href="{{ url('/posts/' . $post->slug) }}" class="hover:text-amber-600">
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
    <section id="galeri" class="px-4 py-16 bg-white dark:bg-gray-800">
        <h2 class="mb-6 text-3xl font-bold text-center">Gallery</h2>
        <div class="grid max-w-5xl grid-cols-1 gap-6 mx-auto sm:grid-cols-3">
            @foreach($galleryItems as $item)
                <div class="overflow-hidden transition-shadow duration-300 bg-white rounded-lg shadow-md dark:bg-gray-900 hover:shadow-lg">
                    <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item['title'] }}" class="object-cover w-full rounded-t-lg h-50">
                    <div class="p-4 text-center">
                        <h3 class="text-lg font-semibold text-gray-800 truncate dark:text-gray-200" title="{{ $item['title'] }}">
                            {{ $item['title'] }}
                        </h3>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    {{-- Achievement Section with 2 columns: left text list, right image slider --}}
    <section id="achievement" class="max-w-5xl px-4 py-16 mx-auto">
        <h2 class="mb-8 text-3xl font-bold text-center">Achievements</h2>
        <div class="max-w-4xl mx-auto md:flex md:gap-12">
            <div class="py-4 md:w-1/2">
                <h4 class="mb-4 text-2xl font-bold text-center">Berikut beberapa Achievment :</h4>
                {{-- Left: Achievement List --}}
                <ul class="py-4 space-y-6 text-gray-700 list-disc list-inside dark:text-gray-300">
                    <li class="flex items-start gap-3">
                        <svg class="flex-shrink-0 w-6 h-6 text-amber-600" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.974a1 1 0 00.95.69h4.18c.969 0 1.371 1.24.588 1.81l-3.388 2.462a1 1 0 00-.364 1.118l1.287 3.974c.3.922-.755 1.688-1.54 1.118l-3.388-2.462a1 1 0 00-1.175 0l-3.388 2.462c-.784.57-1.838-.196-1.54-1.118l1.287-3.974a1 1 0 00-.364-1.118L2.045 9.4c-.783-.57-.38-1.81.588-1.81h4.18a1 1 0 00.95-.69l1.286-3.974z"/>
                        </svg>
                        <a href="https://muri.org/Website/Rekor_detail/edukasi_masuk_perguruan_tinggi_secara_digital_kepada_pelajar_terbanyak" target="_blank" class="underline hover:text-amber-600" rel="noopener">
                            Rekor MURI: Edukasi masuk perguruan tinggi secara digital kepada pelajar terbanyak
                        </a>
                    </li>
                    <li class="flex items-start gap-3">
                        <svg class="flex-shrink-0 w-6 h-6 text-amber-600" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.974a1 1 0 00.95.69h4.18c.969 0 1.371 1.24.588 1.81l-3.388 2.462a1 1 0 00-.364 1.118l1.287 3.974c.3.922-.755 1.688-1.54 1.118l-3.388-2.462a1 1 0 00-1.175 0l-3.388 2.462c-.784.57-1.838-.196-1.54-1.118l1.287-3.974a1 1 0 00-.364-1.118L2.045 9.4c-.783-.57-.38-1.81.588-1.81h4.18a1 1 0 00.95-.69l1.286-3.974z"/>
                        </svg>
                        The Great Champions of Asia Top Millennials Choice in Education Program Award 2024
                    </li>
                    <li class="flex items-start gap-3">
                        <svg class="flex-shrink-0 w-6 h-6 text-amber-600" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.974a1 1 0 00.95.69h4.18c.969 0 1.371 1.24.588 1.81l-3.388 2.462a1 1 0 00-.364 1.118l1.287 3.974c.3.922-.755 1.688-1.54 1.118l-3.388-2.462a1 1 0 00-1.175 0l-3.388 2.462c-.784.57-1.838-.196-1.54-1.118l1.287-3.974a1 1 0 00-.364-1.118L2.045 9.4c-.783-.57-.38-1.81.588-1.81h4.18a1 1 0 00.95-.69l1.286-3.974z"/>
                        </svg>
                        BEST PERFORMING BUSINESS WINNER 2022 – Indonesia Award Magazine
                    </li>
                    <li class="flex items-start gap-3">
                        <svg class="flex-shrink-0 w-6 h-6 text-amber-600" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.974a1 1 0 00.95.69h4.18c.969 0 1.371 1.24.588 1.81l-3.388 2.462a1 1 0 00-.364 1.118l1.287 3.974c.3.922-.755 1.688-1.54 1.118l-3.388-2.462a1 1 0 00-1.175 0l-3.388 2.462c-.784.57-1.838-.196-1.54-1.118l1.287-3.974a1 1 0 00-.364-1.118L2.045 9.4c-.783-.57-.38-1.81.588-1.81h4.18a1 1 0 00.95-.69l1.286-3.974z"/>
                        </svg>
                        Pioner Trainer Muda (19th) Nasional asal Lampung
                    </li>
                </ul>
            </div>

            {{-- Right: Image Slider --}}
            <div class="mt-8 md:w-1/2 md:mt-0">
                <div class="relative w-full overflow-hidden rounded-lg shadow-lg">
                    <div class="flex transition-transform duration-500 slider">
                        <img src="/image/awward1.jpg" alt="Achievement 1" class="flex-shrink-0 object-cover w-full overflow-hidden bg-white rounded-lg shadow h-80 dark:bg-gray-800">
                        <img src="/image/awward2.jpg" alt="Achievement 3" class="flex-shrink-0 object-cover w-full overflow-hidden bg-white rounded-lg shadow h-80 dark:bg-gray-800">
                        <img src="/image/awward3.jpg" alt="Achievement 4" class="flex-shrink-0 object-cover w-full overflow-hidden bg-white rounded-lg shadow h-80 dark:bg-gray-800">
                    </div>
                    {{-- Slider controls --}}
                    <button id="achievementPrevBtn" class="absolute p-2 text-white transition transform -translate-y-1/2 rounded-full top-1/2 left-2 bg-amber-600 hover:bg-amber-700">
                        &#10094;
                    </button>
                    <button id="achievementNextBtn" class="absolute p-2 text-white transition transform -translate-y-1/2 rounded-full top-1/2 right-2 bg-amber-600 hover:bg-amber-700">
                        &#10095;
                    </button>
                </div>
            </div>
        </div>
    </section>

    {{-- Contact Section --}}
    <section id="contact" class="px-4 py-16 bg-white dark:bg-gray-800">
        <h2 class="mb-6 text-3xl font-bold text-center">Contact Me</h2>
        <div class="max-w-3xl mx-auto space-y-6 text-center text-gray-700 dark:text-gray-300">
            <p class="text-lg">
                Jika Anda ingin menghubungi saya untuk kerja sama atau kolaborasi, silakan hubungi melalui WhatsApp berikut:
            </p>
            <a href="https://wa.me/628127154447" target="_blank" rel="noopener" class="inline-block px-6 py-3 font-semibold text-white transition rounded-lg bg-emerald-500 hover:bg-emerald-700">
                Chat Me!
            </a>
        </div>
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