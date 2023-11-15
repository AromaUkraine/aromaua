<fieldset>
    <div class="checkbox checkbox-{{ $class }} @if($glow) checkbox-glow @endif">
        <input
            type="checkbox"
            id="{{ $id }}"
            name="{{ $name }}"
            @if($lang) data-lang="{{$lang}}" @endif
            @if($checked) checked @endif >
        <label for="{{ $id }}">{{ $label }}</label>
    </div>
</fieldset>
