<div
    class="form-group @isset($options['maxlength']) maxlength  @endisset pb-1  mt-2">
    @if($label) <label for="{{ $setId() }}">{{$label}} @isset($options['required']) * @endisset </label> @endif
        <select
            id="{{ ($options['id']) ?? $name }}"
            name="{{ $name }}"
            class="form-control select2 colors @error( $name ) is-invalid @enderror "
            placeholder="{{ __('cms.select.default') }}"
        >
            <option value=""></option>
            @foreach($getColors() as $color)
                <option value="{{$color->id}}" data-color="{{$color->code}}" {{$setSelected($color->id)}} data-name="{{$color->name}}">{{$color->name}}</option>
            @endforeach
        </select>
</div>



@push('scripts')
    <script>
        function formatState (state) {
            // console.log(state);
             if(state.id) {
                 let color = $(state.element).data('color');
                 return $(
                     `<span><span class="color-preview" style="background: ${color}"></span> ${state.text}</span> `
                 );
             }
        };

        let select = $(".colors");
        select.select2({
            theme: 'bootstrap',
            width: '100%',
            placeholder: select.attr('placeholder'),
            escapeMarkup: function(m) {
                return m;
            },
            allowClear: true,
            templateResult: formatState
        });
    </script>
@endpush
