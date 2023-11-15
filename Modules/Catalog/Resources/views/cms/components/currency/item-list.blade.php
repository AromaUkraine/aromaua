<x-select
    label="{{__('price_type.currency')}}"
    name="{{ $name }}"
    options="{!! json_encode(['class'=>'mb-2', 'type'=>'select2', 'placeholder'=>__('cms.select.default'), 'required'=>true]) !!}">
    @foreach($currencies as $currency)
        <option value="{{$currency->id}}" {{$setSelected($currency->id)}}> {{$currency->name}} </option>
    @endforeach
</x-select>
