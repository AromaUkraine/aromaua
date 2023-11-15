<x-select

    name="{{$name}}"
    label="{{__('cms.permission_list')}}"
    options="{!! json_encode([
        'required'=>$required,
        'type'=>'select2'
]) !!}"
>
    @foreach($permissions as $item)
        <option value="{{$item['id']}}" {{ $setSelected($item) }} >
            <small>{{$item['slug']}}</small>
        </option>
    @endforeach
</x-select>

