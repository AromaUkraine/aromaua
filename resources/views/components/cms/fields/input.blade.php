@if($languages)
    @foreach($languages as $lang)
        <div class="form-group lang {{ $getMaxLength() }} {{ $options['form-group-class'] ?? 'pb-1' }}"
            @if($lang->short_code !== $default_language) style="display: none" @endif
            data-lang="{{$lang->short_code}}">
                @if($label) <label for="{{ $setId($lang->short_code) }}">{{$label}} @isset($options['required']) * @endisset </label> @endif
                <input type="{{ ($options['type']) ?? 'text'  }}"
                       class="form-control {{ $options['class'] ?? '' }} @error( $lang->short_code.".".$name ) is-invalid @enderror "
                       id="{{ $setId($lang->short_code) }}"
                       name="{{ $setName($lang->short_code) }}"
                       value="{{ $setValue($lang->short_code) }}"
                       @isset($options['placeholder']) placeholder="{{ \StringHelper::upper($options['placeholder']) }}" @endisset
                       @isset($options['maxlength']) maxlength="{{$options['maxlength']}}" @endisset
                       @isset($options['autocomplete']) autocomplete="{{$options['autocomplete']}}" @endisset
                       @isset($options['required']) @if($options['required']) required @endif @endisset
                       @isset($options['readonly']) @if($options['readonly']) readonly @endif @endisset
                       @isset($options['disabled']) @if($options['disabled']) disabled @endif @endisset
                >
                <div class="col-10 float-left pl-0">
                    @error( $lang->short_code.".".$name )
                    <span class="invalid-feedback d-block" role="alert"><strong>{{ $message }}</strong> </span>
                    @enderror
                </div>
                @if(!$errors->has($lang->short_code.".".$name) && isset($options['hint']))
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
    @endforeach
@else
    <div
        class="form-group {{ $getMaxLength() }} {{ $options['form-group-class'] ?? 'pb-1' }}">
            @if($label) <label for="{{ $setId() }}">{{$label}} @isset($options['required']) * @endisset </label> @endif
            <input type="{{ ($options['type']) ?? 'text'  }}"
                   class="form-control {{ $options['class'] ?? '' }} @error( $name ) is-invalid @enderror "
                   id="{{ $setId() }}"
                   name="{{ $setName() }}"
                   value="{{ $setValue() }}"
                   @isset($options['placeholder']) placeholder="{{ \StringHelper::upper($options['placeholder']) }}" @endisset
                   @isset($options['maxlength']) maxlength="{{$options['maxlength']}}" @endisset
                   @isset($options['autocomplete']) autocomplete="{{$options['autocomplete']}}" @endisset
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
@endif
