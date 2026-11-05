<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Pengaturan situs (dikelola di dashboard) tersedia sebagai $site di semua halaman publik.
        View::composer(['layouts.app', 'welcome', 'services.index', 'posts.index', 'posts.show', 'gallery.index'], function ($view) {
            $view->with('site', Setting::values());
        });
    }
}
