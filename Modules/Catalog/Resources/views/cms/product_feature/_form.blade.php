
<x-catalog-cms-product-feature-items :model="$entity" ></x-catalog-cms-product-feature-items>


@section('form-buttons')
    <x-button
        type="submit"
        class="primary text-capitalize "
        title="{{__('cms.buttons.save')}}"
    ></x-button>
@endsection
