<x-select
    label="{{$label ?? ''}}"
    name="{{$name}}"
    options="{!! json_encode(['class'=>'mb-2','type'=>'select2','placeholder'=>__('cms.select.default'), 'required'=>true]) !!}">
    @foreach($items as $item)
        <option value="{{$item->id}}" {{$setSelected($item)}}> {{$item->name}} </option>
    @endforeach
</x-select>
