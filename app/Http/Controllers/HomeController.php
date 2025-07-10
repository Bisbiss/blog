<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Gallery;

class HomeController extends Controller
{
    /**
     * Display a listing of latest posts.
     */
    public function index()
    {
        $posts = Post::with('category')->latest()->paginate(6);
        $galleryItems = Gallery::all();
        return view('welcome', compact('posts', 'galleryItems'));
    }
}