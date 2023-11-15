{{--<select class="select2 form-control" name="feature_id" placeholder="{{__('cms.select_feature_from_list')}}"  >--}}

{{--    @foreach($features as $feature)--}}
{{--        <option value="{{ $feature->id }}"--}}
{{--        @if(request()->has('feature_id') && request()->feature_id == $feature->id) selected @endisset--}}
{{--        >{{$feature->name}}</option>--}}
{{--    @endforeach--}}
{{--</select>--}}
<x-select
    label="{{__('cms.select_feature_from_list')}}"
    name="feature_id"
    options="{!! json_encode(['type'=>'select2', 'placeholder'=>__('cms.select.default')]) !!}"
>
    @foreach($features as $feature)
        <option value="{{ $feature->id }}"
                @if(request()->has('feature_id') && request()->feature_id == $feature->id) selected @endisset
        >{{$feature->name}}</option>
    @endforeach
</x-select>
