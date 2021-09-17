{{ '<?xml version="1.0" encoding="utf-8"?>' }}

<feed xmlns="http://w3.org/2005/Atom">
    <title>MHanson01 - Laravel Rss Demo</title>
    <subtitle>Sample Rss Demo Project<subtitle>
            <link href="http://mhanson01.com"/>
            <updated>{{ \Carbon\Carbon::now()->toATOMString() }}</updated>
            <author>
                <name>Mark Hanson</name>
            </author>
            <id>tag:example.com,{{date('Y')}}:/feed</id>

            @foreach($posts as $post)
                <entry>
                    <title>{{ $post->title }}</title>
                    <link href="http://www.example.com/blog/{{ $post->slug }}"/>
                    <id>{{ create_tag_uri($post) }}</id>
                    <summary>{{ $post->excerpt }}</summary>
                </entry>
    @endforeach

</feed>