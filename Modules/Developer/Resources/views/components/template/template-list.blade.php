
<x-select
    :model="$model"
    label="{{$label}}"
    name="{{$name}}"
    options="{!! json_encode( $options ) !!}"
>
    @foreach($templates as $temp)
        @if($model)
            <option value="{{$temp->id}}"  {{ old('template_id', $model->pageable->id) == $temp->id ? 'selected' : ''}} > {{ $temp->name }} </option>
        @else
            <option value="{{$temp->id}}" {{ old('template_id') == $temp->id ? 'selected' : ''}} > {{ $temp->name }} </option>
        @endif
    @endforeach
</x-select>

