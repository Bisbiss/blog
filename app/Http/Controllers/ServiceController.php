<?php

namespace App\Http\Controllers;

use App\Models\Achievement;
use App\Models\Post;

class ServiceController extends Controller
{
    /**
     * Halaman pilar SEO: pemateri / trainer / workshop / pelatihan di Lampung & Indonesia.
     */
    public function index()
    {
        return view('services.index', [
            'achievements' => Achievement::visible()->get(),
            'posts' => Post::with('category')->latest()->take(4)->get(),
        ]);
    }
}
