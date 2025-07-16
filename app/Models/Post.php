<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory; // Tambahin ini
use Illuminate\Support\Str; // Import Str buat slugify

class Post extends Model
{
    use HasFactory; // Tambahin ini kalo belum ada

    protected $fillable = [
        'category_id',
        'image',
        'title',
        'slug',
        'content',
    ];

    // Method buat generate slug otomatis
    protected static function boot()
    {
        parent::boot();

        // Pas Post baru dibuat (creating)
        static::creating(function (Post $post) {
            // Kalo slug-nya masih kosong, generate dari title
            if (empty($post->slug)) {
                $post->slug = Str::slug($post->title);
            }
        });

        // Pas Post di-update (updating)
        static::updating(function (Post $post) {
            // Kalo title berubah DAN slug-nya kosong, generate ulang dari title baru
            if ($post->isDirty('title') && empty($post->slug)) {
                $post->slug = Str::slug($post->title);
            }
            // Kalo title gak berubah tapi slug-nya diedit manual, itu biarin aja
            // Kalo title berubah dan slug-nya diisi manual juga biarin aja
        });
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}