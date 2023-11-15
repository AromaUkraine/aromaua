<a class="{{ $options['class'] ?? '' }}" href="{{$href}}">
    <picture>
        <source srcset="{{$webp}}" type="image/webp">
        <img
            class="{{  $options['image_class'] ?? '' }}"
            src="{{$image}}"
            width="{{ $options['width'] ?? 'auto' }}"
            height="{{ $options['height'] ?? 'auto' }}"
            alt="{{ config('app.name') }}">
    </picture>
</a>
