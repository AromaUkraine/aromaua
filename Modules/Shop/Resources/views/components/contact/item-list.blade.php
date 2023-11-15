
<x-select
    label="{{$label}}"
    name="{{$name}}"
    options="{!! $options!!}">
    @foreach($items as $item)
        <option value="{{$item}}" {{ $setSelected($item) }}> {{$item}} </option>
    @endforeach
</x-select>

