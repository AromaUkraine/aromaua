@if($feature_values && $feature_values->count())
    <select name="feature[]" multiple class="select2 form-control repeat feature_value" >
        @foreach($feature_values as $value)
            <option value="{{$feature_id}},{{$value->id}}">{{$value->name}} </option>
        @endforeach
    </select>
@else
    <input type="text" class="form-control" disabled >
@endif
