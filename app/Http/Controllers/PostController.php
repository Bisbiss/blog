<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of posts.
     */
    public function index()
    {
        $posts = Post::with('category')->latest()->paginate(6);
        return view('posts.index', compact('posts'));
    }

    /**
     * Display a post.
     */
    public function show(Post $post)
    {
        return view('posts.show', compact('post'));
    }

    // FILEPATH: d:/IT/Development/blog/app/Http/Controllers/PostController.php

    public function showBySlug($slug)
    {
        $post = Post::where('slug', $slug)->firstOrFail();
        return view('posts.show', compact('post'));
    }
}