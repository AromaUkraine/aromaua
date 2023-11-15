<style>
    .preview{
        width: 100%;
    }
</style>
<x-catalog-cms-product-category-item-list
    :model="$entity"
    name="product_category_id"
>
</x-catalog-cms-product-category-item-list>

<x-catalog-cms-seo-catalog-repeater :model="$entity" >
</x-catalog-cms-seo-catalog-repeater>

<input type="hidden" name="id" value="{{$entity->id}}">

@section('form-fixed-buttons')
    <x-button
        type="submit"
        class="primary  my-2 text-capitalize "
        title="{{__('cms.buttons.save')}}"
    ></x-button>
@endsection


