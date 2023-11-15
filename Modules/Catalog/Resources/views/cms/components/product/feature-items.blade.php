<div class="row mt-4">
    @foreach($category_features as $feature)

        <div class="col-md-4 mb-2">
            <label class="text-right">{{ $feature->name }}</label>
        </div>

        <div class="col-md-8 form-group mb-2">

            @if( $feature->feature_kind->isNumber() )
                <input type="text" class="touchspin form-control" name="value[{{$feature->id}}]" value=" {{ $getNumberValue($feature->id) }}"
                       data-bts-min="0"
                       data-bts-max="10000000"
                       data-bts-step="1"
                       data-bts-decimals="2">
            @else

                <select name="feature_values[{{$feature->id}}][]" placeholder="{{__('cms.select.default')}}" class="select2 form-control "
                        multiple id="feature_values_{{$feature->id}}">
                    @foreach($feature->feature_kind->feature_values as $value)
                        <option value="{{$value->id}}" {{ $isSelected($feature->id, $value->id) }} >{{$value->name}}</option>
                    @endforeach
                </select>

            @endif

        </div>
    @endforeach
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


