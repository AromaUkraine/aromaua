
@if($languages)
    @foreach($languages as $lang)

        <div class="form-group lang {{ isset($options['class']) ? $options['class'] : ''}}"
             style="margin-bottom: 15px; padding-bottom: 15px"
             @if($lang->short_code !== $default_language) style="display: none" @endif
             data-lang="{{$lang->short_code}}"
        >
            @if($label) <label for="{{ $name }}">{{$label}} @isset($options['required']) * @endisset </label> @endif
            <select
                id="{{ $setId($lang->short_code) }}"
                name="{{ $setName($lang->short_code) }}"
                class="form-control {{ $options['type'] ?? '' }} {{ $options['class'] ?? '' }} @error( $lang->short_code.".".$name ) is-invalid @enderror "
                @isset($options['placeholder']) placeholder="{{ \StringHelper::upper($options['placeholder']) }}"  @endisset
                @isset($options['required']) @if($options['required']) required @endif @endisset
                @isset($options['readonly']) @if($options['readonly']) readonly @endif @endisset
                @isset($options['disabled']) @if($options['disabled']) disabled @endif @endisset
                @if(isset($options['multiple']) && $options['multiple']) multiple @endif
            >
                @isset($options['placeholder'])<option value=""></option>@endisset
                {{ $slot }}
            </select>
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
            @if(!$errors->has($lang->short_code.".".$name) && isset($options['alert']))
                <div class="col-10 float-left pl-0">
                    <small class="text-muted text-danger">{!! $options['alert'] !!}</small>
                </div>
            @endif
        </div>

    @endforeach
@else

    <div class="form-group {{ isset($options['class']) ? $options['class'] : ''}} " style="margin-bottom: 15px; padding-bottom: 15px">
        @if($label) <label for="{{ $name }}"> {{$label}} @isset($options['required']) * @endisset </label> @endif

        <select
            id="{{ $setId() }}"
            name="{{ $setName() }}"
            class="form-control {{ $options['type'] ?? '' }} {{ $options['class'] ?? '' }} @error( $name ) is-invalid @enderror "
            @isset($options['placeholder']) placeholder="{{ \StringHelper::upper($options['placeholder']) }}"  @endisset
            @isset($options['required']) @if($options['required']) required @endif @endisset
            @isset($options['readonly']) @if($options['readonly']) readonly @endif @endisset
            @isset($options['disabled']) @if($options['disabled']) disabled @endif @endisset
            @isset($options['disable']) data-disabled="-1" @else data-disabled="1" @endisset
            @if(isset($options['multiple']) && $options['multiple']) multiple @endif
        >
            @isset($options['placeholder'])<option value=""></option>@endisset
            {{ $slot }}
        </select>
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
        @if(!$errors->has($name) && isset($options['alert']))
            <div class="col-10 float-left pl-0">
                <small class="text-danger">{!! $options['alert'] !!}</small>
            </div>
        @endif
    </div>
@endif


@push('scripts')
    <script>

        var select2 = $('.select2#{{$setId()}}');
        select2.select2({
                theme: 'bootstrap',
                width: '100%',
                placeholder: select2.attr('placeholder') ?? ' ',

                escapeMarkup: function(m) {
                    return m;
                },
                allowClear: true,
                minimumResultsForSearch: select2.data('disabled')
            });
    </script>
@endpush
