<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use App\Models\Post;
use App\Models\Setting;
use Illuminate\Support\Carbon;

class SitemapController extends Controller
{
    public function __invoke()
    {
        $posts = Post::latest('updated_at')->get(['slug', 'updated_at']);
        $settingsUpdated = $this->toDate(Setting::max('updated_at'));

        return response()
            ->view('sitemap', [
                'posts' => $posts,
                'pagesUpdated' => collect([$settingsUpdated, $posts->first()?->updated_at])->filter()->max(),
                'postsUpdated' => $posts->first()?->updated_at,
                'galleryUpdated' => $this->toDate(Gallery::max('updated_at')),
                'servicesUpdated' => $settingsUpdated,
            ])
            ->header('Content-Type', 'application/xml');
    }

    private function toDate(mixed $value): ?Carbon
    {
        return $value ? Carbon::parse($value) : null;
    }
}
