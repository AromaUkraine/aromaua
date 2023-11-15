
<div class="{{ $options['fieldset-class'] ?? '' }}">
    @if($label) <label for="{{ $setId() }}">{{$label}} @isset($options['required']) * @endisset </label> @endif
    <fieldset class="{{ $options['form-group-class'] ?? 'form-group position-relative has-icon-left' }}">
        <input type="text"
            class="form-control pickadate "
            id="{{ $setId() }}"
            name="{{ $name }}"
            data-value="{{ $setDate() ?? null }}"
            @isset($options['placeholder']) placeholder="{{ \StringHelper::upper($options['placeholder']) }}" @endisset
        >
        <div class="form-control-position">
            <i class="bx bx-calendar-check"></i>
        </div>
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
    </fieldset>
</div>


<link rel="stylesheet" type="text/css" href="{{asset('css/pickers/pickadate/pickadate.css')}}">
@push('scripts')
    <script src="{{ asset('js/scripts/pickers/pickadate/picker.js') }}"></script>
    <script src="{{ asset('js/scripts/pickers/pickadate/picker.date.js') }}"></script>
    <script src="{{ asset('js/scripts/pickers/pickadate/picker.time.js') }}"></script>
    <script src="{{ asset('js/scripts/pickers/pickadate/translations/'.app()->getLocale().'_RU.js') }}"></script>
    <script>
        var $input = $('.pickadate').pickadate({
             format: 'dd.mm.yyyy',
        });
        // Use the picker object directly.
        var picker = $input.pickadate('picker');
        picker.set('select',  '{{$setDate()}}' );
    </script>
@endpush
