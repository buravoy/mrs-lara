<?php echo '<?xml version="1.0" encoding="UTF-8"?>' ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    @if(isset($links) && !empty($links))
        @foreach($links as $link)
            <url>
                <loc>{{ route('index') }}/{{ $type }}/{{ $link }}</loc>
                <changefreq>weekly</changefreq>
                <priority>1.0</priority>
            </url>
        @endforeach
    @endif
</urlset>
