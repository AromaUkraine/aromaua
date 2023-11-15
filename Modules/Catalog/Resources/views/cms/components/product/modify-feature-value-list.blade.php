<x-select
    label="{{__('cms.set_modification_value_to_default')}}"
    name="{{$name}}"
    options="{!! json_encode(['class'=>'mb-2', 'type'=>'select2', 'placeholder'=>__('cms.select.default'), 'required'=>true]) !!}">
    @foreach($feature_values as $value)
        <option value="{{$value->id}}"{{$setSelected($value->id)}} > {{$value->name}} </option>
    @endforeach
</x-select>

