

<x-catalog-cms-seo-catalog-brand :model="$entity" >
</x-catalog-cms-seo-catalog-brand>

<input type="hidden" name="id" value="{{$entity->id}}">

@section('form-fixed-buttons')
    <x-button
        type="submit"
        class="primary  my-2 text-capitalize "
        title="{{__('cms.buttons.save')}}"
    ></x-button>
@endsection


