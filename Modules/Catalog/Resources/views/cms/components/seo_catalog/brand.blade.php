<div class="row">
    <div class="col-md-6 col-12 mb-50">
        <label class="text-nowrap label ">{{__('cms.select_brand')}} *</label>
    </div>
    <div class="col-md-6 col-12 mb-50">
        <label class="text-nowrap label  ">{{__('cms.select_country')}} *</label>
    </div>
</div>

<div class="row justify-content-between" >
    <div class="row col-md-6 col-12 d-flex align-items-center">
        <div class="col-12 form-group ">
            <select name="feature[]" placeholder="{{__('cms.select.default')}}" class="select2 form-control  @error( 'feature.0' ) is-invalid @enderror" >
                <option value=""></option>
                @foreach($brands->feature_kind->feature_values as $value)
                    <option value="{{$getFeatureId($brands)}},{{$value->id}}" {{ $setSelectedBrand($value->id) }} >{{$value->name}} </option>
                @endforeach
            </select>
            @error( 'feature.0' )
            <span class="invalid-feedback d-block" role="alert"><strong>{{ $message }}</strong> </span>
            @enderror
        </div>
    </div>


    <div class="col-md-6 col-12 form-group">
        <select name="country_id"  placeholder="{{__('cms.select.default')}}" class="select2 form-control @error( 'country_id' ) is-invalid @enderror " >
            <option value=""></option>
            @foreach($countries->feature_kind->feature_values as $value)
                <option value="{{$value->id}}" {{$setSelectedCountry($value->id)}}>{{$value->name}}</option>
            @endforeach
        </select>
        @error( 'country_id' )
            <span class="invalid-feedback d-block" role="alert"><strong>{{ $message }}</strong> </span>
        @enderror
    </div>
    <div class="col-md-2 col-12 form-group">

    </div>
</div>



