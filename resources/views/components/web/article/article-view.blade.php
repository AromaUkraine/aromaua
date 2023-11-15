<article class="article">
    <h1>{{ $page->name }}</h1>
    @forelse($article->gallery as $item)
        @if(!$loop->first)
        <figure class="float-right">
            <picture>
                <source srcset="{{ $getWebpImage($item) }}" type="image/webp">
                <img src="{{ $item->image }}" alt="{{ $article->name }}">
            </picture>
        </figure>
        @endif
    @empty
    @endforelse
    {!! $page->text !!}
    <time>{{ $getDate($article, 'published_at') }}</time>
</article>
