<?php

use Illuminate\Support\Facades\Route;
use App\Models\Post;
use App\Models\Gallery;

// Route untuk Home
Route::get('/', function () {
    return view('welcome');
});

// Route untuk Daftar Post
Route::get('/posts', function () {
    $posts = Post::with('category')->latest()->paginate(10);
    return view('posts.index', compact('posts'));
});

// Route untuk Detail Post
Route::get('/posts/{post}', function (Post $post) {
    return view('posts.show', compact('post'));
});

// Route untuk Daftar Galeri
Route::get('/gallery', function () {
    $galleries = Gallery::latest()->paginate(12);
    return view('gallery.index', compact('galleries'));
});
