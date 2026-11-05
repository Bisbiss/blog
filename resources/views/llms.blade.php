@php
    $plain = fn ($html) => trim(preg_replace('/\s+/', ' ', html_entity_decode(strip_tags(str_replace(['</p>', '</li>'], ["</p>\n", "</li>\n"], (string) $html)), ENT_QUOTES)));
    $stats = array_values(array_filter((array) $site['hero_stats'], fn ($stat) => filled($stat['value'] ?? null)));
    $services = array_values(array_filter((array) $site['services'], fn ($s) => filled($s['title'] ?? null)));
    $faqs = array_values(array_filter((array) $site['faqs'], fn ($f) => filled($f['question'] ?? null)));
@endphp
# {!! $site['site_name'] !!} — {!! $site['hero_tagline'] ?: 'Pemateri & Trainer' !!}

> {!! $plain($site['services_intro'] ?: $site['site_description']) !!}

## Fakta utama

- Nama: {!! $site['site_name'] !!}
@if (! empty($site['job_titles']))
- Profesi: {!! implode(', ', (array) $site['job_titles']) !!}
@endif
@if ($site['seo_city'] || $site['seo_region'])
- Domisili: {!! collect([$site['seo_city'], $site['seo_region'], 'Indonesia'])->filter()->implode(', ') !!}
@endif
@if ($site['organization_name'])
- Organisasi: Founder & CEO {!! $site['organization_name'] !!}{!! $site['organization_url'] ? ' (' . $site['organization_url'] . ')' : '' !!}
@endif
@foreach ($stats as $stat)
- {!! $stat['label'] ?? '' !!}: {!! $stat['value'] !!}
@endforeach
@if (! empty($site['credentials']))
- Sertifikasi: {!! implode('; ', (array) $site['credentials']) !!}
@endif
@if (! empty($site['alumni_of']))
- Pendidikan: {!! implode(', ', (array) $site['alumni_of']) !!}
@endif
@if ($site['contact_whatsapp'])
- Kontak undangan pemateri (WhatsApp): +{!! $site['contact_whatsapp'] !!} — https://wa.me/{!! $site['contact_whatsapp'] !!}
@endif

## Program seminar, workshop & pelatihan

@foreach ($services as $service)
- **{!! $service['title'] !!}**{!! filled($service['audience'] ?? null) ? ' (untuk: ' . $service['audience'] . ')' : '' !!}: {!! $service['description'] ?? '' !!}
@endforeach

@if (! empty($site['service_formats']))
Format: {!! implode(', ', (array) $site['service_formats']) !!}.

@endif
@if (! empty($site['area_served']))
Area layanan: {!! implode(', ', (array) $site['area_served']) !!}.

@endif
@if ($achievements->isNotEmpty())
## Penghargaan

@foreach ($achievements as $achievement)
- {!! $achievement->title !!}{!! $achievement->url ? ' — ' . $achievement->url : '' !!}
@endforeach

@endif
@if ($books->isNotEmpty())
## Buku

@foreach ($books as $book)
- {!! $book->title !!}{!! $book->url ? ' — ' . $book->url : '' !!}
@endforeach

@endif
@if ($faqs)
## Pertanyaan umum

@foreach ($faqs as $faq)
### {!! $faq['question'] !!}

{!! $plain($faq['answer'] ?? '') !!}

@endforeach
@endif
## Halaman penting

- [Beranda & profil]({!! route('home') !!}): profil, pengalaman, buku, dan penghargaan
- [Layanan pemateri & trainer]({!! route('services') !!}): program pelatihan, area layanan, FAQ, cara mengundang
- [Artikel]({!! route('posts.index') !!})
- [Galeri kegiatan]({!! route('gallery.index') !!})
@foreach ((array) $site['social_links'] as $social)
- [{!! $social['label'] !!}]({!! $social['url'] !!})
@endforeach

@if ($posts->isNotEmpty())
## Artikel terbaru

@foreach ($posts as $post)
- [{!! $post->title !!}]({!! route('posts.show', $post) !!}): {!! $post->excerpt(140) !!}
@endforeach
@endif
