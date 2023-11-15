<x-input
    label="{{__('cms.category_feature_to_modify')}}"
    name="value"
    value="{{ $entity->category->modify_feature_name }}"
    options="{!! json_encode([ 'readonly'=>true, 'disabled'=>true]) !!}"
>
</x-input>

<x-catalog-cms-product-modify-feature-values-list
    :model="$entity"
    name="modify_value"
>
</x-catalog-cms-product-modify-feature-values-list>

<x-catalog-cms-product-related-by-category-parent-dad-left-right
    :model="$entity"
>
</x-catalog-cms-product-related-by-category-parent-dad-left-right>


@section('form-fixed-buttons')
    <x-button
        type="submit"
        class="primary my-2 mr-1 text-capitalize "
        title="{{__('cms.buttons.save')}}"
    ></x-button>
    <x-action
        href="{{ route('module.feature_modify.index',[$table, $id]) }}"
        class="light  my-2 text-capitalize"
        title="{{__('cms.buttons.cancel')}}"
    ></x-action>
@endsection
