<x-select
    label="{{__('kind.type')}}"
    name="{{$name}}"
    options="{!! json_encode(['class'=>'mb-2','type'=>'select2','placeholder'=>__('cms.select.default'), 'required'=>true]) !!}">
    @foreach($kinds as $kind)
        <option value="{{$kind->id}}" {{$setSelected($kind)}}> {{$kind->name}} </option>
    @endforeach
</x-select>
