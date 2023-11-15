<article class="blog__item blog-article">
    <div class="blog-article__head">
        <h2 class="blog-article__title">
            <a href="{{ route('page', $item->slug) }}" title="{{ $getTitle }}"> {{ $item->name }} </a>
        </h2>
        <time class="blog-article__date">{{ $getDate($item, 'published_at') }}</time>
    </div>
    <a class="blog-article__link-img" href="{{ route('page', $item->slug) }}" title="{{ $getTitle }}">
        <picture>
            <source srcset="{{ $getPreviewWebpImage($item) }}" type="image/webp">
            <img src="{{ $getPreviewImage($item) }}" alt="{{ $item->name }}">
        </picture>
    </a>
    <p class="blog-article__text"> {{ $item->description }}</p>
    <a class="blog-article__readmore btn" href="{{ route('page', $item->slug) }}" title="{{ $getTitle }}">{{__('web.read_article')}}</a>
</article>
