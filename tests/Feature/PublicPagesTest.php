<?php

namespace Tests\Feature;

use App\Models\Achievement;
use App\Models\Book;
use App\Models\Category;
use App\Models\Gallery;
use App\Models\Post;
use App\Models\ProfileSection;
use App\Models\Setting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicPagesTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutVite();
    }

    private function makePost(array $attributes = []): Post
    {
        $category = Category::firstOrCreate(['name' => 'Event']);

        return Post::create(array_merge([
            'category_id' => $category->id,
            'title' => 'Judul Artikel',
            'content' => '<p>Isi artikel <strong>penting</strong>.</p>',
        ], $attributes));
    }

    public function test_home_shows_content_managed_from_dashboard(): void
    {
        Setting::store(['hero_title' => 'Halo Dunia', 'books_title' => 'Karya Tulis']);
        ProfileSection::create(['title' => 'Aktivitas Sekarang', 'content' => '<ul><li>CEO</li></ul>']);
        Book::create(['title' => 'Buku Hebat', 'cover' => 'books/a.jpg']);
        Book::create(['title' => 'Buku Tersembunyi', 'cover' => 'books/b.jpg', 'is_active' => false]);
        Achievement::create(['title' => 'Rekor MURI']);
        Gallery::create(['title' => 'Foto Seminar', 'image' => 'gallery/a.jpg']);
        $this->makePost(['title' => 'Artikel Pertama']);

        $this->get('/')
            ->assertOk()
            ->assertSeeText('Halo Dunia')
            ->assertSee('Karya Tulis')
            ->assertSee('Aktivitas Sekarang')
            ->assertSee('Buku Hebat')
            ->assertDontSee('Buku Tersembunyi')
            ->assertSee('Rekor MURI')
            ->assertSee('Foto Seminar')
            ->assertSee('Artikel Pertama')
            ->assertSee('data-carousel', false)
            ->assertSee('carousel-rows-2', false)
            ->assertSee('data-lightbox="gallery"', false)
            ->assertSee('id="lightbox"', false);
    }

    public function test_home_renders_with_empty_database(): void
    {
        $this->get('/')->assertOk()->assertSeeText(Setting::defaults()['hero_title']);
    }

    public function test_hero_particles_can_be_disabled_from_settings(): void
    {
        $this->get('/')->assertOk()->assertSee('id="hero-particles"', false);

        Setting::store(['hero_particles' => false]);

        $this->get('/')->assertOk()->assertDontSee('id="hero-particles"', false);
    }

    public function test_home_shows_hero_stats_from_settings(): void
    {
        Setting::store(['hero_stats' => [['value' => '99+', 'label' => 'Seminar nasional']]]);

        $this->get('/')->assertOk()->assertSee('99+')->assertSee('Seminar nasional');
    }

    public function test_post_page_shows_share_buttons_and_related_posts(): void
    {
        $post = $this->makePost(['title' => 'Artikel Utama']);
        $this->makePost(['title' => 'Artikel Terkait']);

        $this->get(route('posts.show', $post))
            ->assertOk()
            ->assertSee('menit baca')
            ->assertSee('data-copy-link', false)
            ->assertSee('Artikel Lainnya')
            ->assertSee('Artikel Terkait');
    }

    public function test_post_is_shown_by_slug_with_seo_meta(): void
    {
        $post = $this->makePost(['image' => 'posts/cover.jpg']);

        $this->assertSame('judul-artikel', $post->slug);

        $this->get('/posts/judul-artikel')
            ->assertOk()
            ->assertSee('Judul Artikel')
            ->assertSee('<meta name="description" content="Isi artikel penting.">', false)
            ->assertSee('<meta property="og:type" content="article">', false)
            ->assertSee('storage/posts/cover.jpg', false);
    }

    public function test_unknown_slug_returns_404(): void
    {
        $this->get('/posts/tidak-ada')->assertNotFound();
    }

    public function test_duplicate_titles_get_unique_slugs(): void
    {
        $first = $this->makePost();
        $second = $this->makePost();

        $this->assertSame('judul-artikel', $first->slug);
        $this->assertSame('judul-artikel-2', $second->slug);
    }

    public function test_post_without_image_can_be_saved(): void
    {
        $post = $this->makePost(['image' => null]);

        $this->get(route('posts.show', $post))->assertOk();
    }

    public function test_posts_and_gallery_index_pages(): void
    {
        $this->makePost();
        Gallery::create(['title' => 'Foto Kegiatan', 'image' => 'gallery/a.jpg']);

        $this->get('/posts')->assertOk()->assertSee('Judul Artikel');
        $this->get('/gallery')->assertOk()->assertSee('Foto Kegiatan');
    }

    public function test_sitemap_lists_posts(): void
    {
        $this->makePost();

        $this->get('/sitemap.xml')
            ->assertOk()
            ->assertHeader('Content-Type', 'application/xml')
            ->assertSee(route('posts.show', 'judul-artikel'), false);
    }

    public function test_layout_has_single_set_of_meta_tags(): void
    {
        $html = $this->get('/')->getContent();

        $this->assertSame(1, substr_count($html, 'name="robots"'));
        $this->assertSame(1, substr_count($html, 'name="author"'));
    }
}
