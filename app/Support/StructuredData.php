<?php

namespace App\Support;

use App\Models\Achievement;
use App\Models\Post;

/**
 * Membangun schema.org JSON-LD supaya Google dan mesin AI (ChatGPT, Gemini, Perplexity, dll)
 * memahami siapa Syaifulloh, layanan apa yang ditawarkan, dan di mana.
 */
class StructuredData
{
    public static function personId(): string
    {
        return url('/') . '#person';
    }

    public static function websiteId(): string
    {
        return url('/') . '#website';
    }

    public static function serviceId(): string
    {
        return route('services') . '#service';
    }

    /**
     * Node dasar yang ditampilkan di semua halaman: WebSite + Person.
     */
    public static function base(array $site): array
    {
        return [
            [
                '@type' => 'WebSite',
                '@id' => self::websiteId(),
                'url' => url('/'),
                'name' => $site['site_name'],
                'description' => $site['site_description'],
                'inLanguage' => 'id-ID',
                'publisher' => ['@id' => self::personId()],
            ],
            self::person($site),
        ];
    }

    public static function person(array $site): array
    {
        $image = $site['hero_image'] ? asset('storage/' . $site['hero_image']) : null;
        $sameAs = collect((array) $site['social_links'])->pluck('url')->filter()->values();

        if (filled($site['organization_url'])) {
            $organization = array_filter([
                '@type' => 'Organization',
                'name' => $site['organization_name'],
                'url' => $site['organization_url'],
            ]);
        }

        return array_filter([
            '@type' => 'Person',
            '@id' => self::personId(),
            'name' => $site['site_name'],
            'url' => url('/'),
            'image' => $image,
            'description' => $site['site_description'],
            'jobTitle' => array_values((array) $site['job_titles']) ?: null,
            'worksFor' => $organization ?? null,
            'address' => self::address($site),
            'homeLocation' => self::place($site),
            'alumniOf' => collect((array) $site['alumni_of'])
                ->filter()
                ->map(fn ($name) => ['@type' => 'CollegeOrUniversity', 'name' => $name])
                ->values()
                ->all() ?: null,
            'hasCredential' => collect((array) $site['credentials'])
                ->filter()
                ->map(fn ($name) => ['@type' => 'EducationalOccupationalCredential', 'name' => $name])
                ->values()
                ->all() ?: null,
            'knowsAbout' => array_values(array_filter((array) $site['knows_about'])) ?: null,
            'award' => self::awards() ?: null,
            'sameAs' => $sameAs->all() ?: null,
        ]);
    }

    /**
     * Layanan pemateri/trainer: ProfessionalService dengan katalog program dan area layanan.
     */
    public static function service(array $site): array
    {
        $services = collect((array) $site['services'])->filter(fn ($s) => filled($s['title'] ?? null));

        return array_filter([
            '@type' => 'ProfessionalService',
            '@id' => self::serviceId(),
            'name' => $site['site_name'] . ' — ' . $site['services_title'],
            'url' => route('services'),
            'description' => strip_tags((string) $site['services_intro']),
            'image' => $site['hero_image'] ? asset('storage/' . $site['hero_image']) : null,
            'telephone' => $site['contact_whatsapp'] ? '+' . $site['contact_whatsapp'] : null,
            'address' => self::address($site),
            'areaServed' => self::areaServed($site) ?: null,
            'founder' => ['@id' => self::personId()],
            'employee' => ['@id' => self::personId()],
            'knowsLanguage' => 'id',
            'hasOfferCatalog' => $services->isEmpty() ? null : [
                '@type' => 'OfferCatalog',
                'name' => 'Program seminar, workshop & pelatihan',
                'itemListElement' => $services->map(fn ($s) => [
                    '@type' => 'Offer',
                    'itemOffered' => array_filter([
                        '@type' => 'Service',
                        'name' => $s['title'],
                        'description' => $s['description'] ?? null,
                        'audience' => filled($s['audience'] ?? null)
                            ? ['@type' => 'Audience', 'audienceType' => $s['audience']]
                            : null,
                        'provider' => ['@id' => self::personId()],
                        'areaServed' => ['@type' => 'Country', 'name' => 'Indonesia'],
                    ]),
                ])->values()->all(),
            ],
        ]);
    }

    public static function faq(array $faqs): ?array
    {
        $faqs = collect($faqs)->filter(fn ($f) => filled($f['question'] ?? null) && filled($f['answer'] ?? null));

        if ($faqs->isEmpty()) {
            return null;
        }

        return [
            '@type' => 'FAQPage',
            'mainEntity' => $faqs->map(fn ($f) => [
                '@type' => 'Question',
                'name' => $f['question'],
                'acceptedAnswer' => ['@type' => 'Answer', 'text' => strip_tags($f['answer'])],
            ])->values()->all(),
        ];
    }

    /**
     * @param  array<string, string>  $items  label => url
     */
    public static function breadcrumbs(array $items): array
    {
        return [
            '@type' => 'BreadcrumbList',
            'itemListElement' => collect($items)->keys()->map(fn ($label, $i) => [
                '@type' => 'ListItem',
                'position' => $i + 1,
                'name' => $label,
                'item' => $items[$label],
            ])->all(),
        ];
    }

    public static function article(Post $post, array $site): array
    {
        return array_filter([
            '@type' => 'BlogPosting',
            '@id' => route('posts.show', $post) . '#article',
            'headline' => $post->title,
            'description' => $post->excerpt(),
            'image' => $post->image ? asset('storage/' . $post->image) : null,
            'datePublished' => $post->created_at?->toIso8601String(),
            'dateModified' => $post->updated_at?->toIso8601String(),
            'inLanguage' => 'id-ID',
            'articleSection' => $post->category?->name,
            'wordCount' => str_word_count(strip_tags((string) $post->content)),
            'mainEntityOfPage' => route('posts.show', $post),
            'author' => ['@id' => self::personId()],
            'publisher' => ['@id' => self::personId()],
            'isPartOf' => ['@id' => self::websiteId()],
        ]);
    }

    /**
     * Render satu blok <script type="application/ld+json"> dari daftar node.
     */
    public static function render(array $nodes): string
    {
        $graph = array_values(array_filter($nodes));

        if (! $graph) {
            return '';
        }

        $json = json_encode(
            ['@context' => 'https://schema.org', '@graph' => $graph],
            JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP
        );

        return '<script type="application/ld+json">' . $json . '</script>';
    }

    public static function areaServed(array $site): array
    {
        return collect((array) $site['area_served'])
            ->filter()
            ->map(fn ($name) => str_contains(strtolower($name), 'indonesia')
                ? ['@type' => 'Country', 'name' => 'Indonesia']
                : ['@type' => 'AdministrativeArea', 'name' => $name . ', ' . ($site['seo_region'] ?: 'Lampung')])
            ->unique('name')
            ->values()
            ->all();
    }

    private static function address(array $site): ?array
    {
        if (blank($site['seo_city']) && blank($site['seo_region'])) {
            return null;
        }

        return array_filter([
            '@type' => 'PostalAddress',
            'addressLocality' => $site['seo_city'],
            'addressRegion' => $site['seo_region'],
            'addressCountry' => 'ID',
        ]);
    }

    private static function place(array $site): ?array
    {
        $address = self::address($site);

        return $address ? ['@type' => 'Place', 'address' => $address] : null;
    }

    private static function awards(): array
    {
        return Achievement::visible()->pluck('title')->filter()->values()->all();
    }
}
