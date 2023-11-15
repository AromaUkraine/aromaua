
{{ Form::open(array('route' => $setRoute(), 'method' => $setMethod() )) }}
<x-google-map
    address="{{ $address }}"
    lat="{{ $lat }}"
    lng="{{ $lng }}"
    height="500"
></x-google-map>

<div class="d-flex justify-content-md-end justify-content-center ">

    <button type="submit" class="btn btn-primary text-capitalize my-2 mr-1 glow">
        <span class="align-middle ml-25">{{__('cms.buttons.save')}}</span>
    </button>
    @if($model->map)
    <a
        href="{{route('module.entity_map.destroy', [
            $model->getTable(),
            $model->id,
            $model->map->id
        ])}}"
        class="btn btn-danger text-capitalize my-2  glow"
        id="delete"
        >
        {{__('cms.buttons.delete')}}
    </a>
@endif
</div>
{{ Form::close() }}




