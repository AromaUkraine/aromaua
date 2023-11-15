<div
    class="form-group @isset($options['maxlength']) maxlength  @endisset pb-1">
    @if($label) <label for="{{ $setId() }}">{{$label}} @isset($options['required']) * @endisset </label> @endif
    <input type="{{ ($options['type']) ?? 'text'  }}"
           class="form-control touchspin {{ $options['class'] ?? '' }} @error( $name ) is-invalid @enderror "
           id="{{ $setId() }}"
           name="{{ $setName() }}"
           value="{{ $setValue() }}"

           {{ $setParams(['min', 'max', 'step', 'decimals']) }}"

           @isset($options['placeholder']) placeholder="{{ \StringHelper::upper($options['placeholder']) }}" @endisset
           @isset($options['required']) @if($options['required']) required @endif @endisset
           @isset($options['readonly']) @if($options['readonly']) readonly @endif @endisset
           @isset($options['disabled']) @if($options['disabled']) disabled @endif @endisset
    >
    <div class="col-10 float-left pl-0">
        @error( $name )
        <span class="invalid-feedback d-block" role="alert"><strong>{{ $message }}</strong> </span>
        @enderror
    </div>
    @if(!$errors->has($name) && isset($options['hint']))
        <div class="col-10 float-left pl-0">
            <small class="text-muted">{!! $options['hint'] !!}</small>
        </div>
    @endif
    @isset($options['maxlength'])
        <small class="counter-value float-right " style="font-size:0.8em;">
            <span class="char-count counter" data-val-length="parent"></span>
        </small>
    @endisset
</div>

@push('scripts')
    <script>
        let input = $("input.touchspin");
        input.TouchSpin({
            min: input.attr('data-bts-min'),
            max: input.attr('data-bts-max'),
            step: input.attr('data-bts-step'),
            decimals: input.attr('data-bts-decimals'),
            forcestepdivisibility: 'none'
        });
    </script>
@endpush
