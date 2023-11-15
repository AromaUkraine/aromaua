<x-select
    label="{{__('cms.select_parent_product')}}"
    name="{{$name}}"
    options="{!! json_encode(['class'=>'mb-2', 'type'=>'select2', 'placeholder'=>__('cms.select.default'), 'required'=>true]) !!}"
>
    @foreach($parent_products as $parent)
        <option value="{{$parent->id}}" {{$setSelected($parent->id)}} > {{$parent->page->name}} </option>
    @endforeach
</x-select>
