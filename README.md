## Technology Stack

This project is built using the following technologies:

-   **Laravel 12**: The latest version of the popular PHP web application framework.
-   **Filament**: A modern admin panel and form builder for Laravel.
-   **Tailwind CSS**: A utility-first CSS framework for rapidly building custom user interfaces.

## Project Description

This is a personal website that includes a blog section, allowing you to share articles and updates easily.

## Features

-   **Blog**: Create, edit, and delete blog posts.
-   **Categories**: Organize blog posts into categories.
-   **Gallery**: Create, edit, and delete Gallery.
-   **Admin Panel**: A user-friendly admin panel for managing content.
-   **Responsive Design**: The website is fully responsive, ensuring a seamless experience across devices.
-   **SEO Friendly**: Optimized for search engines to improve visibility and reach.

## Mengelola Konten

Semua konten halaman depan dikelola dari dashboard `/admin`:

| Menu                                 | Isi                                                                   |
| ------------------------------------ | --------------------------------------------------------------------- |
| **Pengaturan → Pengaturan Situs**    | Nama situs & SEO, logo, hero, about, judul tiap bagian, foto slider achievement, kontak WhatsApp, footer |
| **Halaman Depan → Detail Profil**    | Accordion detail profil                                               |
| **Halaman Depan → Buku**             | Daftar buku (grid 4 kolom)                                            |
| **Halaman Depan → Gallery**          | Foto gallery (carousel di beranda, halaman `/gallery`)               |
| **Halaman Depan → Achievements**     | Daftar achievement                                                    |
| **Blog → Artikel / Kategori**        | Artikel (carousel di beranda, halaman `/posts`)                       |

Urutan item bisa diatur dengan drag & drop di tabel dashboard.

## Setup / Deploy

```bash
composer install
npm install && npm run build
php artisan migrate
php artisan db:seed --class=SiteContentSeeder   # sekali saja: memindahkan konten awal ke database
php artisan storage:link
php artisan make:filament-user                  # membuat akun admin
```

`SiteContentSeeder` aman dijalankan ulang — data yang sudah ada tidak ditimpa.
Sitemap tersedia di `/sitemap.xml`.
