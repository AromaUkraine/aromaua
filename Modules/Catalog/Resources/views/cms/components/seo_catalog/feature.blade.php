<select class="select2 form-control feature repeat" >
    <option value="" selected></option>
    @foreach($features as $feature)
        <option value="{{ $feature->id }}">{{$feature->name}}</option>
    @endforeach
</select>
