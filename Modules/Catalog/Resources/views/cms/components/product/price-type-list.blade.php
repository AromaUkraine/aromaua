<x-select
    name="price_type[key]"
    label="{{__('cms.product_series')}}"
    options="{!! json_encode(['required'=>true, 'type'=>'select2', 'id'=>'price_type_key']) !!}"
>
    @forelse($types as $type)
        <option value="{{$type->key}}" {{$setSelected($type)}}>{{$type->key}}</option>
    @empty
    @endforelse
</x-select>

