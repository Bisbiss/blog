<?php

namespace Database\Seeders;

use App\Models\Achievement;
use App\Models\Book;
use App\Models\ProfileSection;
use App\Models\Setting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

/**
 * Memindahkan konten halaman depan yang sebelumnya ditulis langsung di view ke database,
 * supaya bisa dikelola dari dashboard. Aman dijalankan berulang: data yang sudah ada tidak ditimpa.
 */
class SiteContentSeeder extends Seeder
{
    public function run(): void
    {
        $this->seedSettings();
        $this->seedProfileSections();
        $this->seedBooks();
        $this->seedAchievements();
    }

    private function seedSettings(): void
    {
        $existing = Setting::pluck('key')->all();

        $values = array_merge(Setting::defaults(), [
            'logo' => $this->copyImage('logo.png', 'settings'),
            'hero_image' => $this->copyImage('syaifulloh.webp', 'settings'),
            'about_image' => $this->copyImage('about.webp', 'settings'),
            'media_image' => $this->copyImage('media.png', 'settings'),
            'achievement_images' => array_values(array_filter([
                $this->copyImage('awward1.jpg', 'achievements'),
                $this->copyImage('awward2.jpg', 'achievements'),
                $this->copyImage('awward3.jpg', 'achievements'),
            ])),
        ]);

        Setting::store(array_diff_key($values, array_flip($existing)));
    }

    private function seedProfileSections(): void
    {
        if (ProfileSection::exists()) {
            return;
        }

        $sections = [
            'Present Activities' => '<ul><li>Founder dan CEO Lampung Cerdas.</li><li>Founder Youth Inspiration Indonesia.</li><li>Pembina Yayasan Pemuda Harapan Dunia</li><li>Trainer dan Motivator</li><li>Owner Keripik Singkong MADIR</li><li>Master therapist Hypnotherapy Center Lampung</li><li>Serta telah menginspirasi anak muda Indonesia lebih dari 2.700.000.</li></ul>',
            'History Education & Certified' => '<ul><li>S1 Ilmu Pemerintahan - Unila</li><li>S2 Magister Manajemen - IIB Darmajaya</li><li>Promotor Stifin</li><li>Certified Instructor Hypnotherapy (CI) from Indonesian Board of Hypnotherapy (IBH)</li><li>Certified Hypnotherapy (CHt) from Indonesian Board of Hypnotherapy (IBH)</li><li>Certified Hypnosis (CH) from Indonesian Board of Hypnotherapy (IBH)</li><li>Certified NLP Practitioner from Neo NLP Indonesia</li><li>Certified NLP Master Practitioner from NLP Indonesia</li><li>Mapping Talent Practitioner</li><li>Certified Instructor Trainer from BNSP</li><li>Sekolah CEO 1.0 from BisnisHack Indonesia</li><li>Sekolah HRD from BisnisHack Indonesia</li><li>Grounded Business Coaching (GBC) led by Coach Dr. Fahmi</li><li>Smart Financial Map by Ilmu Keuangan</li></ul>',
            'Program & Materi yang Sering Saya Bawakan' => '<p>💡 <strong>Untuk Siswa &amp; Mahasiswa:</strong></p><ul><li>Strategi Lulus Kuliah Impian</li><li>Hypno Learning &amp; Hypno Teaching</li><li>Membangun Mental Juara Sejak Muda</li><li>Growth Mindset &amp; Motivasi Prestasi</li><li>Kuliah Gratis dan Beasiswa Impian</li><li>Leadership &amp; Komunikasi untuk Generasi muda</li></ul><p>🏢 <strong>Untuk Guru, Dosen &amp; Lembaga Pendidikan:</strong></p><ul><li>Training Hypno Teaching</li><li>Komunikasi Edukatif &amp; Persuasif</li><li>Strategi Meningkatkan Semangat Belajar Siswa</li><li>Pelatihan Public Speaking &amp; Presentation Skill</li></ul><p>👔 <strong>Untuk Umum, Komunitas, Instansi &amp; Korporat:</strong></p><ul><li>Personal Branding &amp; Komunikasi Berpengaruh</li><li>Membangun Tim Hebat &amp; Kolaboratif</li><li>Mindset Tumbuh untuk Pemimpin Masa Depan</li><li>Kelas Resiliensi: Bangkit dalam Tekanan</li><li>Marketing Humanis &amp; Closing Hypnotic</li></ul><p>📍 <strong>Fokus Saya Saat Ini:</strong></p><ul><li>Pengembangan SDM &amp; kepemudaan</li><li>Pendidikan dan mindset pertumbuhan</li><li>Public speaking dan komunikasi efektif</li><li>Peningkatan kualitas tenaga pendidik</li><li>Personal development dan spiritual leadership</li></ul>',
        ];

        foreach ($sections as $title => $content) {
            ProfileSection::create(['title' => $title, 'content' => $content]);
        }
    }

    private function seedBooks(): void
    {
        if (Book::exists()) {
            return;
        }

        $books = [
            '1.jpg' => 'Baca Ini: Masuk Kuliah Tanpa Tes',
            '3.jpg' => 'Cara Gila Mengubah Diri',
            '4.jpg' => 'Jangan Menyerah, Harus Berubah!',
        ];

        foreach ($books as $file => $title) {
            if ($cover = $this->copyImage($file, 'books')) {
                Book::create(['title' => $title, 'cover' => $cover]);
            }
        }
    }

    private function seedAchievements(): void
    {
        if (Achievement::exists()) {
            return;
        }

        $achievements = [
            ['title' => 'Rekor MURI: Edukasi masuk perguruan tinggi secara digital kepada pelajar terbanyak', 'url' => 'https://muri.org/Website/Rekor_detail/edukasi_masuk_perguruan_tinggi_secara_digital_kepada_pelajar_terbanyak'],
            ['title' => 'The Great Champions of Asia Top Millennials Choice in Education Program Award 2024'],
            ['title' => 'BEST PERFORMING BUSINESS WINNER 2022 – Indonesia Award Magazine'],
            ['title' => 'Pioner Trainer Muda (19th) Nasional asal Lampung'],
        ];

        foreach ($achievements as $achievement) {
            Achievement::create($achievement);
        }
    }

    /**
     * Salin gambar bawaan dari public/image ke storage public supaya bisa diganti lewat dashboard.
     */
    private function copyImage(string $file, string $directory): ?string
    {
        $source = public_path('image/' . $file);

        if (! is_file($source)) {
            return null;
        }

        $path = $directory . '/' . $file;

        if (! Storage::disk('public')->exists($path)) {
            Storage::disk('public')->put($path, file_get_contents($source));
        }

        return $path;
    }
}
