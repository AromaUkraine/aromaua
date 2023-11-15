@if($languages)
    @foreach($languages as $lang)
        <div class="form-group lang @isset($options['maxlength']) maxlength @endisset"
             @if($lang->short_code !== $default_language) style="display: none" @endif
             data-lang="{{$lang->short_code}}"
        >
            @if($label) <label for="{{ $name }}">{{$label}} @isset($options['required']) * @endisset </label> @endif
            <textarea
                class="form-control {{$editor}} {{ $options['class'] ?? '' }} @error( $lang->short_code.".".$name ) is-invalid @enderror "
                id="{{ ($options['id']) ?? $lang->short_code."_".$name }}"
                name="{{ $lang->short_code."[".$name."]" }}"
                @isset($options['placeholder']) placeholder="{{ \StringHelper::upper($options['placeholder']) }}"
                @endisset
                @isset($options['maxlength']) maxlength="{{$options['maxlength']}}" @endisset
                @isset($options['required']) @if($options['required']) required @endif @endisset
                @isset($options['readonly']) @if($options['readonly']) readonly @endif @endisset
                @isset($options['disabled']) @if($options['disabled']) disabled @endif @endisset
        >{{trim($setValue($lang->short_code))}}</textarea>
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
        @include("components.cms.fields.scripts.{$editor}-".$filemanager,['selector'=> ($options['id']) ?? $lang->short_code."_".$name ])
    @endforeach
@else

    <div class="form-group @isset($options['maxlength']) maxlength @endisset"
    >
        @if($label) <label for="{{ $name }}">{{$label}} @isset($options['required']) * @endisset </label> @endif
        <textarea
            class="form-control {{ $options['class'] ?? '' }} {{$editor}} @error( $name ) is-invalid @enderror "
            id="{{ ($options['id']) ?? $name }}"
            name="{{ $name }}"
            @isset($options['placeholder']) placeholder="{{ \StringHelper::upper($options['placeholder']) }}" @endisset
            @isset($options['maxlength']) maxlength="{{$options['maxlength']}}" @endisset
            @isset($options['required']) @if($options['required']) required @endif @endisset
            @isset($options['readonly']) @if($options['readonly']) readonly @endif @endisset
            @isset($options['disabled']) @if($options['disabled']) disabled @endif @endisset
        >{{trim($setValue($lang->short_code))}}</textarea>
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

    @include("components.cms.fields.scripts.{$editor}-".$filemanager,['selector'=> ($options['id']) ?? $name ])
@endif




