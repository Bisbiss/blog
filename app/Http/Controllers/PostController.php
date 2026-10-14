<?php

namespace App\Http\Controllers;

use App\Models\Post;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with('category')->latest()->paginate(12);

        return view('posts.index', compact('posts'));
    }

    public function show(Post $post)
    {
        $post->load('category');

        // Artikel lain, utamakan yang satu kategori
        $related = Post::with('category')
            ->whereKeyNot($post->id)
            ->orderByRaw('category_id = ? desc', [$post->category_id])
            ->latest()
            ->take(4)
            ->get();

        return view('posts.show', compact('post', 'related'));
    }
}
