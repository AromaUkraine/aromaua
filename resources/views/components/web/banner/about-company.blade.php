<section class="prev-about">
    <span class="prev-about__title h2">{!! $item->name ?? __('web.about_company') !!} </span>
    <div class="prev-about__content">
        <figure class="prev-about__wrap-img">
            <picture>
                <source srcset="{{ $getWebp($item->image ?? '') }}" type="image/webp">
                <img src="{{ $setImageOrDefault($item, 'image') }}" alt="{{__('web.about_company')}}">
            </picture>
        </figure>
        <div class="prev-about__info">
            <p class="prev-about__text">{!! $item->description ?? '' !!} </p>
            <a class="prev-about__link btn" href="{{ $item->link ?? '#' }}" title="{{ $getTitle }}">{{ $item->button_name ?? '' }}</a>
        </div>
    </div>
</section>
