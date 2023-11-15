@if($feature_values)
    <x-select
        label="{{__('cms.set_modification_value_to_default')}}"
        name="modify_feature_value_id"
        options="{!! json_encode(['class'=>'mb-2', 'type'=>'select2', 'placeholder'=>__('cms.select.default'), 'required'=>true]) !!}">
        @foreach($feature_values as $value)
            <option value="{{$value->id}}" {{$setSelected($value->id)}}> {{$value->name}} </option>
        @endforeach
    </x-select>
@endif
