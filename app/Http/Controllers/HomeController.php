<?php

namespace App\Http\Controllers;

use App\Models\Achievement;
use App\Models\Book;
use App\Models\Gallery;
use App\Models\Post;
use App\Models\ProfileSection;

class HomeController extends Controller
{
    public function index()
    {
        return view('welcome', [
            'profileSections' => ProfileSection::visible()->get(),
            'books' => Book::visible()->get(),
            'posts' => Post::with('category')->latest()->take(16)->get(),
            'galleryItems' => Gallery::orderBy('sort_order')->latest('id')->take(16)->get(),
            'achievements' => Achievement::visible()->get(),
        ]);
    }
}
