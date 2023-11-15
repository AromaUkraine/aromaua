{{--<select class="select2 form-control" name="feature_value_id" placeholder="{{__('cms.select_feature_value')}}"  >--}}
{{--    <option selected ></option>--}}
{{--    @foreach($feature_values as $value)--}}
{{--        <option value="{{ $value->id }}"--}}
{{--                @if(request()->has('feature_value_id') && request()->feature_value_id == $value->id) selected @endisset--}}
{{--        >{{$value->name}}</option>--}}
{{--    @endforeach--}}
{{--</select>--}}
<x-select
    label="{{__('cms.select_feature_value')}}"
    name="feature_value_id"
    options="{!! json_encode(['type'=>'select2', 'placeholder'=>__('cms.select.default')]) !!}"
>
    @foreach($feature_values as $value)
        <option value="{{ $value->id }}"
                @if(request()->has('feature_value_id') && request()->feature_value_id == $value->id) selected @endisset
        >{{$value->name}}</option>
    @endforeach
</x-select>
