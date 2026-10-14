<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * Akun admin dibuat terpisah dengan `php artisan make:filament-user`.
     */
    public function run(): void
    {
        $this->call(SiteContentSeeder::class);
    }
}
