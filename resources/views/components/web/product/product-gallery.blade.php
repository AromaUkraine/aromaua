@forelse($product->gallery as $item)
    @if($loop->first)
        <figure class="product__wrap-img">
            <picture>
                <source srcset="{{ $getWebp($item) }}" type="image/webp">
                <img src="{{ $item->image ?? '' }}" alt="{{ $product->name ?? '' }}">
            </picture>
        </figure>
    @endif
@empty
    <figure class="product__wrap-img">
        <picture>
            @if($getDefaultProductImage($product))
            <img src="{{ $getDefaultProductImage($product) }}" alt="{{ $product->name ?? '' }}">
            @endif
        </picture>
    </figure>
@endforelse
