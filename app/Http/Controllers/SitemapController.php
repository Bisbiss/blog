<?php

namespace App\Http\Controllers;

use App\Models\Post;

class SitemapController extends Controller
{
    public function __invoke()
    {
        $posts = Post::latest('updated_at')->get(['slug', 'updated_at']);

        return response()
            ->view('sitemap', compact('posts'))
            ->header('Content-Type', 'application/xml');
    }
}
