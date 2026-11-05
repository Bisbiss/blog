<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    public const CACHE_KEY = 'site-settings';

    public const SEO_DESCRIPTION = 'Syaifulloh, pemateri & trainer asal Lampung. Narasumber seminar, workshop, dan pelatihan SDM untuk sekolah, kampus, instansi & perusahaan se-Indonesia.';

    public const SEO_KEYWORDS = 'pemateri Lampung, trainer Lampung, narasumber seminar Lampung, motivator Lampung, pelatihan Lampung, workshop Lampung, training SDM Indonesia, pemateri seminar Indonesia, Syaifulloh, Lampung Cerdas';

    protected $fillable = [
        'key',
        'value',
    ];

    protected $casts = [
        'value' => 'json',
    ];

    /**
     * Semua pengaturan situs, digabung dengan nilai default untuk key yang belum disimpan.
     */
    public static function values(): array
    {
        $stored = Cache::rememberForever(self::CACHE_KEY, fn () => static::query()->pluck('value', 'key')->all());

        return array_merge(static::defaults(), $stored);
    }

    public static function store(array $values): void
    {
        foreach ($values as $key => $value) {
            static::updateOrCreate(['key' => $key], ['value' => $value]);
        }

        Cache::forget(self::CACHE_KEY);
    }

    /**
     * Nilai awal. Path gambar sengaja null; gambar diisi lewat SiteContentSeeder atau dashboard.
     */
    public static function defaults(): array
    {
        return [
            // Umum & SEO
            'site_name' => 'Syaifulloh',
            'home_title' => 'Syaifulloh | Pemateri & Trainer Lampung, Workshop & Pelatihan',
            'site_description' => self::SEO_DESCRIPTION,
            'site_keywords' => self::SEO_KEYWORDS,
            'logo' => null,
            'og_image' => null,

            // Identitas untuk Google & mesin AI (structured data / llms.txt)
            'seo_city' => 'Bandar Lampung',
            'seo_region' => 'Lampung',
            'job_titles' => ['Pemateri', 'Trainer', 'Motivator', 'Narasumber Seminar', 'Learning Facilitator'],
            'organization_name' => 'Lampung Cerdas',
            'organization_url' => 'https://lampungcerdas.com',
            'alumni_of' => ['Universitas Lampung', 'IIB Darmajaya'],
            'credentials' => [
                'Certified Instructor Trainer (BNSP)',
                'Certified Instructor Hypnotherapy (CI) - Indonesian Board of Hypnotherapy',
                'Certified NLP Master Practitioner - NLP Indonesia',
                'Promotor STIFIn',
            ],
            'knows_about' => [
                'Public speaking', 'Hypno teaching', 'Hypno learning', 'Motivasi pelajar dan mahasiswa',
                'Leadership', 'Personal branding', 'Pengembangan SDM', 'Team building', 'NLP', 'Hipnoterapi',
            ],

            // Halaman layanan pemateri / trainer
            'services_title' => 'Pemateri & Trainer Lampung untuk Seminar, Workshop dan Pelatihan',
            'services_intro' => 'Syaifulloh adalah pemateri, trainer, dan motivator asal Lampung dengan pengalaman lebih dari 13 tahun di dunia pelatihan dan pengembangan SDM. Ia menjadi narasumber seminar, workshop, in-house training, dan webinar untuk sekolah, kampus, instansi pemerintah, perusahaan, komunitas, dan UMKM — di Lampung maupun di seluruh Indonesia.',
            'services' => self::defaultServices(),
            'service_formats' => ['Seminar & talkshow', 'Workshop interaktif', 'In-house training', 'Webinar / pelatihan online', 'Kuliah umum & stadium general', 'Coaching kelompok'],
            'area_served' => [
                'Bandar Lampung', 'Metro', 'Lampung Selatan', 'Lampung Tengah', 'Lampung Timur', 'Lampung Utara',
                'Lampung Barat', 'Pringsewu', 'Pesawaran', 'Tanggamus', 'Tulang Bawang', 'Tulang Bawang Barat',
                'Way Kanan', 'Mesuji', 'Pesisir Barat', 'Seluruh Indonesia (offline & online)',
            ],
            'faqs' => self::defaultFaqs(),

            // Hero
            'hero_greeting' => 'Hi 👋',
            'hero_title' => 'Saya Syaifulloh',
            'hero_tagline' => 'Pemateri, Trainer & Motivator Lampung',
            'hero_text' => '<p>Seorang pengusaha asal Lampung, Indonesia. Selain menjalankan bisnis, saya juga dikenal sebagai pembicara publik, motivator, trainer, dan learning facilitator.</p><p>Selama lebih dari 13 tahun, saya telah mengabdikan diri di dunia pelatihan dan pengembangan SDM. Saya berpengalaman membawakan berbagai sesi di lingkungan korporasi, universitas, sekolah, perusahaan swasta, hingga pelaku UKM—baik skala kecil maupun besar.</p>',
            'hero_image' => null,
            'hero_particles' => true,
            'social_links' => [
                ['label' => 'Instagram', 'url' => 'https://www.instagram.com/mr.syaifulloh/', 'color' => 'pink'],
                ['label' => 'LinkedIn', 'url' => 'https://www.linkedin.com/in/syaifulloh17/', 'color' => 'sky'],
                ['label' => 'Tiktok', 'url' => 'https://www.tiktok.com/@mr.syaifulloh', 'color' => 'slate'],
            ],
            'hero_stats' => [
                ['value' => '13+', 'label' => 'Tahun di dunia training'],
                ['value' => '2,7 Jt+', 'label' => 'Anak muda terinspirasi'],
                ['value' => '3', 'label' => 'Buku best seller'],
                ['value' => 'MURI', 'label' => 'Pemegang rekor'],
            ],

            // About
            'about_title' => 'About Me',
            'about_text' => '<p>Kecintaan saya terhadap pemberdayaan manusia membawa saya secara serius untuk mengembangkan banyak program edukasi, bisnis &amp; training di Indonesia.</p><p>Dengan semangat membangun generasi cerdas dan tangguh, saya terus berkomitmen untuk menyebarkan inspirasi, pengetahuan, dan strategi pertumbuhan yang berdampak nyata bagi individu maupun organisasi.</p>',
            'about_image' => null,

            // Judul tiap bagian
            'profile_title' => 'Detail Profile Syaifulloh',
            'media_title' => 'Media & Publikasi',
            'media_image' => null,
            'books_title' => 'Buku',
            'books_subtitle' => 'Saya juga seorang penulis.',
            'books_text' => 'Berikut buku-buku best seller yang pernah saya tulis.',
            'articles_title' => 'Artikel',
            'gallery_title' => 'Gallery',
            'achievements_title' => 'Achievements',
            'achievements_subtitle' => 'Berikut beberapa achievement:',
            'achievement_images' => [],

            // Kontak & footer
            'contact_title' => 'Contact Me',
            'contact_text' => 'Jika Anda ingin menghubungi saya untuk kerja sama atau kolaborasi, silakan hubungi melalui WhatsApp berikut:',
            'contact_whatsapp' => '628127154447',
            'contact_button' => 'Chat Me!',
            'footer_text' => 'Lampung Cerdas. All rights reserved.',
            'footer_url' => 'https://lampungcerdas.com',
        ];
    }

    /**
     * Program pelatihan awal, disusun dari daftar "Program & Materi yang Sering Saya Bawakan".
     */
    public static function defaultServices(): array
    {
        return [
            [
                'title' => 'Pelatihan Public Speaking & Presentation Skill',
                'audience' => 'Guru, mahasiswa, karyawan, dan pimpinan organisasi',
                'description' => 'Workshop praktik berbicara di depan umum: mengatasi grogi, menyusun materi yang runtut, teknik membuka dan menutup presentasi, serta komunikasi persuasif.',
                'topics' => ['Public speaking', 'Presentation skill', 'Komunikasi persuasif'],
            ],
            [
                'title' => 'Training Hypno Teaching & Hypno Learning',
                'audience' => 'Guru, dosen, dan lembaga pendidikan',
                'description' => 'Pelatihan metode mengajar berbasis komunikasi bawah sadar dan NLP untuk meningkatkan fokus, semangat, dan hasil belajar siswa.',
                'topics' => ['Hypno teaching', 'Hypno learning', 'Komunikasi edukatif'],
            ],
            [
                'title' => 'Seminar Motivasi & Growth Mindset Pelajar',
                'audience' => 'Siswa SMA/SMK, mahasiswa, dan organisasi kepemudaan',
                'description' => 'Seminar motivasi untuk membangun mental juara, growth mindset, strategi lulus kuliah impian, serta peluang kuliah gratis dan beasiswa.',
                'topics' => ['Mental juara', 'Growth mindset', 'Strategi masuk kuliah', 'Beasiswa'],
            ],
            [
                'title' => 'Leadership & Team Building',
                'audience' => 'Instansi pemerintah, BUMN, perusahaan, dan komunitas',
                'description' => 'Training kepemimpinan dan kolaborasi tim: mindset tumbuh untuk pemimpin, membangun tim hebat, dan kelas resiliensi untuk bangkit di bawah tekanan.',
                'topics' => ['Leadership', 'Team building', 'Resiliensi'],
            ],
            [
                'title' => 'Personal Branding & Komunikasi Berpengaruh',
                'audience' => 'Profesional, pengusaha, dan umum',
                'description' => 'Workshop membangun citra diri yang kuat di dunia nyata dan media sosial, serta teknik komunikasi yang meyakinkan.',
                'topics' => ['Personal branding', 'Komunikasi berpengaruh'],
            ],
            [
                'title' => 'Marketing Humanis & Closing Hypnotic',
                'audience' => 'UMKM, tim sales, dan pelaku usaha',
                'description' => 'Pelatihan penjualan yang menyentuh sisi manusia: memahami kebutuhan pelanggan, bahasa persuasif, dan teknik closing yang etis.',
                'topics' => ['Marketing', 'Sales', 'Closing'],
            ],
        ];
    }

    public static function defaultFaqs(): array
    {
        return [
            [
                'question' => 'Siapa pemateri atau trainer di Lampung yang bisa diundang untuk seminar dan pelatihan?',
                'answer' => 'Syaifulloh adalah pemateri, trainer, dan motivator asal Lampung, Founder & CEO Lampung Cerdas, dengan pengalaman lebih dari 13 tahun membawakan seminar, workshop, dan pelatihan SDM untuk sekolah, kampus, instansi, perusahaan, dan UMKM.',
            ],
            [
                'question' => 'Tema pelatihan apa saja yang bisa dibawakan?',
                'answer' => 'Tema yang sering dibawakan antara lain public speaking, hypno teaching, motivasi dan growth mindset pelajar, strategi masuk kuliah dan beasiswa, leadership, team building, personal branding, resiliensi, serta marketing dan closing untuk UMKM. Materi dapat disesuaikan dengan kebutuhan peserta.',
            ],
            [
                'question' => 'Apakah bisa diundang sebagai pemateri di luar Lampung?',
                'answer' => 'Bisa. Selain di seluruh kabupaten/kota di Provinsi Lampung, Syaifulloh menerima undangan sebagai pemateri di berbagai kota di Indonesia, baik secara tatap muka maupun online melalui Zoom atau platform lain.',
            ],
            [
                'question' => 'Format acara apa yang tersedia?',
                'answer' => 'Tersedia format seminar dan talkshow, workshop interaktif, in-house training, webinar, kuliah umum, dan coaching kelompok. Durasi menyesuaikan kebutuhan, mulai dari sesi seminar beberapa jam hingga pelatihan satu hari atau lebih.',
            ],
            [
                'question' => 'Apa kredensial Syaifulloh sebagai trainer?',
                'answer' => 'Syaifulloh adalah Certified Instructor Trainer dari BNSP, Certified Instructor Hypnotherapy dari Indonesian Board of Hypnotherapy, Certified NLP Master Practitioner, dan pemegang Rekor MURI untuk edukasi masuk perguruan tinggi secara digital kepada pelajar terbanyak. Ia lulusan S1 Ilmu Pemerintahan Universitas Lampung dan S2 Magister Manajemen IIB Darmajaya.',
            ],
            [
                'question' => 'Bagaimana cara mengundang Syaifulloh sebagai pemateri atau trainer?',
                'answer' => 'Hubungi melalui WhatsApp dengan menyebutkan nama instansi, tanggal dan lokasi acara, jumlah serta profil peserta, dan tema yang diinginkan. Tim akan mengirimkan penawaran dan detail program yang sesuai.',
            ],
        ];
    }
}
