<?php

namespace App\Http\Controllers;

use App\Models\Achievement;
use App\Models\Book;
use App\Models\Post;
use App\Models\Setting;

class SeoController extends Controller
{
    public function robots()
    {
        $lines = [
            'User-agent: *',
            'Allow: /',
            'Disallow: /admin',
            'Disallow: /livewire',
            '',
            'Sitemap: ' . route('sitemap'),
            '',
            '# Ringkasan untuk mesin AI: ' . route('llms'),
        ];

        return response(implode("\n", $lines) . "\n")->header('Content-Type', 'text/plain; charset=UTF-8');
    }

    /**
     * llms.txt (https://llmstxt.org): ringkasan situs dalam Markdown untuk ChatGPT, Claude, Perplexity, dll.
     */
    public function llms()
    {
        $content = view('llms', [
            'site' => Setting::values(),
            'achievements' => Achievement::visible()->get(),
            'books' => Book::visible()->get(),
            'posts' => Post::latest()->take(20)->get(['title', 'slug', 'content', 'created_at']),
        ])->render();

        return response($content)->header('Content-Type', 'text/plain; charset=UTF-8');
    }
}
