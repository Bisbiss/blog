{!! '<' . '?xml version="1.0" encoding="UTF-8"?>' !!}
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url>
        <loc>{{ route('home') }}</loc>
        @if ($pagesUpdated)<lastmod>{{ $pagesUpdated->toAtomString() }}</lastmod>@endif
        <changefreq>weekly</changefreq>
        <priority>1.0</priority>
    </url>
    <url>
        <loc>{{ route('services') }}</loc>
        @if ($servicesUpdated)<lastmod>{{ $servicesUpdated->toAtomString() }}</lastmod>@endif
        <changefreq>monthly</changefreq>
        <priority>0.9</priority>
    </url>
    <url>
        <loc>{{ route('posts.index') }}</loc>
        @if ($postsUpdated)<lastmod>{{ $postsUpdated->toAtomString() }}</lastmod>@endif
        <changefreq>daily</changefreq>
        <priority>0.7</priority>
    </url>
    <url>
        <loc>{{ route('gallery.index') }}</loc>
        @if ($galleryUpdated)<lastmod>{{ $galleryUpdated->toAtomString() }}</lastmod>@endif
        <changefreq>weekly</changefreq>
        <priority>0.5</priority>
    </url>
    @foreach ($posts as $post)
        <url>
            <loc>{{ route('posts.show', $post) }}</loc>
            <lastmod>{{ $post->updated_at?->toAtomString() }}</lastmod>
            <priority>0.6</priority>
        </url>
    @endforeach
</urlset>
