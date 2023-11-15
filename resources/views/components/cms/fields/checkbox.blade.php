@if($languages)
    @foreach($languages as $lang)
        нужно доделать !!!
    @endforeach
@else
    <fieldset>
        <div class="checkbox checkbox-{{ $options['class'] ?? 'primary' }} @isset($options['glow']) checkbox-glow @endisset">
            <input
                type="checkbox"
                id="{{ $getId() }}"
                name="{{ $getName() }}"
                @isset($options['checked']) checked @endisset >
            <label for="{{ $getId() }}">{{ $label ?? '' }}</label>
        </div>
    </fieldset>
@endif

