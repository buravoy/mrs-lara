@php '<?xml version="1.0" encoding="utf-8"?>' @endphp

<rss version="2.0">
    <channel>
        @if($data)
            @foreach($data as $item)
                <item>
                    <title>{{ $item->name }}</title>
                    <link>{{ route('product', ['slug' => $item->slug]) }}</link>
                    <description>{{ $item->description_2 ?? $item->description_1 }}</description>
                    <pubDate>{{ $item->created_at }}</pubDate>
                </item>
            @endforeach
        @endif
    </channel>
</rss>
