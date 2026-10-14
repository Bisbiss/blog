<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    public const CACHE_KEY = 'site-settings';

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
            'site_description' => 'Syaifulloh - pengusaha, pembicara publik, motivator, trainer, dan learning facilitator asal Lampung. Founder & CEO Lampung Cerdas.',
            'site_keywords' => 'Syaifulloh, Lampung Cerdas, trainer Lampung, motivator Lampung, pembicara publik',
            'logo' => null,
            'og_image' => null,

            // Hero
            'hero_greeting' => 'Hi 👋',
            'hero_title' => 'Saya Syaifulloh',
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
}
