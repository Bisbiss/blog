<?php

namespace Tests\Feature;

use App\Models\Achievement;
use App\Models\Category;
use App\Models\Post;
use App\Models\Setting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SeoTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutVite();
    }

    /**
     * Ambil semua blok JSON-LD dari HTML dan kembalikan node-node @graph-nya.
     */
    private function jsonLdNodes(string $html): array
    {
        preg_match_all('#<script type="application/ld\+json">(.*?)</script>#s', $html, $matches);

        return collect($matches[1])
            ->map(fn ($json) => json_decode($json, true, flags: JSON_THROW_ON_ERROR))
            ->flatMap(fn ($data) => $data['@graph'])
            ->all();
    }

    private function nodeTypes(string $html): array
    {
        return array_column($this->jsonLdNodes($html), '@type');
    }

    public function test_home_has_keyword_title_tagline_and_person_schema(): void
    {
        Achievement::create(['title' => 'Rekor MURI']);

        $html = $this->get('/')->assertOk()
            ->assertSee('<title>' . e(Setting::defaults()['home_title']) . '</title>', false)
            ->assertSee('Pemateri, Trainer &amp; Motivator Lampung', false)
            ->assertSee(route('services'))
            ->getContent();

        $this->assertContains('Person', $this->nodeTypes($html));
        $this->assertContains('WebSite', $this->nodeTypes($html));
        $this->assertContains('ProfilePage', $this->nodeTypes($html));

        $person = collect($this->jsonLdNodes($html))->firstWhere('@type', 'Person');
        $this->assertContains('Rekor MURI', $person['award']);
        $this->assertSame('Bandar Lampung', $person['address']['addressLocality']);
        $this->assertContains('https://www.instagram.com/mr.syaifulloh/', $person['sameAs']);
    }

    public function test_services_page_has_service_faq_and_breadcrumb_schema(): void
    {
        $html = $this->get('/pemateri-trainer-lampung')->assertOk()
            ->assertSee('<h1', false)
            ->assertSee(e(Setting::defaults()['services_title']), false)
            ->assertSee('Pelatihan Public Speaking')
            ->assertSee('Pringsewu')
            ->assertSee('Apakah bisa diundang sebagai pemateri di luar Lampung?')
            ->assertSee('wa.me/628127154447?text=', false)
            ->getContent();

        $types = $this->nodeTypes($html);
        $this->assertContains('ProfessionalService', $types);
        $this->assertContains('FAQPage', $types);
        $this->assertContains('BreadcrumbList', $types);

        $service = collect($this->jsonLdNodes($html))->firstWhere('@type', 'ProfessionalService');
        $this->assertNotEmpty($service['hasOfferCatalog']['itemListElement']);
        $this->assertContains(['@type' => 'Country', 'name' => 'Indonesia'], $service['areaServed']);
    }

    public function test_post_page_has_blog_posting_schema_and_author(): void
    {
        $category = Category::create(['name' => 'Event']);
        $post = Post::create(['category_id' => $category->id, 'title' => 'Workshop Guru & Dosen', 'content' => '<p>Isi</p>']);

        $html = $this->get(route('posts.show', $post))->assertOk()
            ->assertSee('rel="author"', false)
            ->getContent();

        $article = collect($this->jsonLdNodes($html))->firstWhere('@type', 'BlogPosting');
        $this->assertSame('Workshop Guru & Dosen', $article['headline']);

        // Judul dengan "&" tidak boleh dobel escape
        $this->assertStringContainsString('<title>Workshop Guru &amp; Dosen - Syaifulloh</title>', $html);
    }

    public function test_paginated_pages_have_their_own_canonical(): void
    {
        $this->get('/posts?page=2')->assertSee('<link rel="canonical" href="' . url('/posts') . '?page=2">', false);
        $this->get('/posts?utm_source=x')->assertSee('<link rel="canonical" href="' . url('/posts') . '">', false);
    }

    public function test_robots_txt_points_to_sitemap_and_blocks_admin(): void
    {
        $this->get('/robots.txt')
            ->assertOk()
            ->assertHeader('Content-Type', 'text/plain; charset=UTF-8')
            ->assertSee('Sitemap: ' . route('sitemap'))
            ->assertSee('Disallow: /admin');
    }

    public function test_llms_txt_summarises_services_for_ai(): void
    {
        $this->get('/llms.txt')
            ->assertOk()
            ->assertHeader('Content-Type', 'text/plain; charset=UTF-8')
            ->assertSee('# Syaifulloh')
            ->assertSee('Pelatihan Public Speaking & Presentation Skill', false)
            ->assertSee(route('services'))
            ->assertDontSee('&amp;', false);
    }

    public function test_sitemap_includes_services_page(): void
    {
        $this->get('/sitemap.xml')->assertOk()->assertSee(route('services'), false);
    }
}
