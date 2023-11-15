<section class="prev-news">
    <span class="prev-news__title h2">{{__('web.latest_news')}}</span>
    <div class="prev-news__articles">
        @forelse ($items as $item)
            <article class="prev-news__item">
                <a class="prev-news__link-img" href="{{ 'page', $item->slug }}" title="{{$getTitle}}">
                    <picture>
                        <source srcset="{{ $getPreviewWebpImage($item) }}" type="image/webp">
                        <img src="{{ $getPreviewImage($item) }}" alt="{{ $item->name }}">
                    </picture>
                </a>
                <div class="prev-news__info">
                    <h3 class="prev-news__item-title">
                        <a href="{{ route('page', $item->slug) }}" title="{{$getTitle}}">{{ $item->name }}</a>
                    </h3>
                    <p class="prev-news__text">{{ $cropWords($item->description) }}</p>
                    <div class="prev-news__footer">
                        <time class="prev-news__date">{{ $getDate($item, 'published_at') }}</time>
                       <a class="prev-news__readmore readmore" href="{{ route( 'page', $item->slug) }}" title="{{$getTitle}}">{{__('web.read_more')}}</a>
                    </div>
                </div>
            </article>
        @empty
        @endforelse
    </div>
    <a href="{{ $getRootPageRoute() }}" class="prev-news__link btn">{{__('web.see_all')}}</a>
</section>
