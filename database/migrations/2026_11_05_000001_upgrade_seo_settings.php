<?php

use App\Models\Setting;
use Illuminate\Database\Migrations\Migration;

/**
 * Mengganti meta description & kata kunci lama dengan versi yang menargetkan
 * "pemateri / trainer / workshop / pelatihan Lampung & Indonesia".
 * Hanya menimpa nilai yang masih sama dengan bawaan lama, jadi isian manual dari dashboard tetap aman.
 */
return new class extends Migration
{
    private const OLD = [
        'site_description' => 'Syaifulloh - pengusaha, pembicara publik, motivator, trainer, dan learning facilitator asal Lampung. Founder & CEO Lampung Cerdas.',
        'site_keywords' => 'Syaifulloh, Lampung Cerdas, trainer Lampung, motivator Lampung, pembicara publik',
    ];

    private function new(): array
    {
        return [
            'site_description' => Setting::SEO_DESCRIPTION,
            'site_keywords' => Setting::SEO_KEYWORDS,
        ];
    }

    public function up(): void
    {
        $this->replaceIfUnchanged(self::OLD, $this->new());
    }

    public function down(): void
    {
        $this->replaceIfUnchanged($this->new(), self::OLD);
    }

    private function replaceIfUnchanged(array $from, array $to): void
    {
        $updates = [];

        foreach ($from as $key => $value) {
            if (Setting::where('key', $key)->value('value') === $value) {
                $updates[$key] = $to[$key];
            }
        }

        if ($updates) {
            Setting::store($updates);
        }
    }
};
