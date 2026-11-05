<?php

namespace Tests\Feature;

use App\Filament\Pages\ManageSettings;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class AdminPanelTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_to_login(): void
    {
        $this->get('/admin')->assertRedirect('/admin/login');
    }

    public function test_admin_pages_are_accessible(): void
    {
        $this->actingAs(User::factory()->create());

        foreach (['/admin', '/admin/settings', '/admin/posts', '/admin/posts/create', '/admin/books', '/admin/books/create', '/admin/achievements', '/admin/profile-sections', '/admin/galleries', '/admin/categories'] as $url) {
            $this->get($url)->assertOk();
        }
    }

    public function test_settings_can_be_saved_from_dashboard(): void
    {
        $this->actingAs(User::factory()->create());

        Livewire::test(ManageSettings::class)
            ->fillForm([
                'site_name' => 'Nama Baru',
                'hero_title' => 'Judul Hero Baru',
                'contact_whatsapp' => '6281234',
            ])
            ->call('save')
            ->assertHasNoFormErrors();

        $this->assertSame('Nama Baru', Setting::values()['site_name']);
        $this->assertSame('Judul Hero Baru', Setting::values()['hero_title']);

        $this->withoutVite()->get('/')->assertSeeText('Judul Hero Baru');
    }
}
