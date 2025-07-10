<?php

use Illuminate\Support\Facades\Route;
use App\Models\Post;
use App\Models\Gallery;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;

// Route untuk Home
Route::get('/', [HomeController::class, 'index']);

// Route untuk Daftar Post
Route::get('/posts', [PostController::class, 'index']);

// Route untuk Detail Post
Route::get('/posts/{post}', [PostController::class, 'show']);