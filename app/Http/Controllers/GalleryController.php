<?php

namespace App\Http\Controllers;

use App\Models\Gallery;

class GalleryController extends Controller
{
    public function index()
    {
        $galleries = Gallery::orderBy('sort_order')->latest('id')->paginate(16);

        return view('gallery.index', compact('galleries'));
    }
}
