
{{-- если категория имеет наследников - добавление хар-тик невозможно !!! --}}
@if(!$entity->children->count())
<x-catalog-cms-product-category-dad-left-right
    :model="$entity"
    options="{!! json_encode(['fixed'=>['feature_id'=>$entity->modify_feature], 'maxHeight'=>100]) !!}"
>
</x-catalog-cms-product-category-dad-left-right>

    @if($entity->entity_features && $entity->entity_features->count())

        @if( !$entity->products->count() || !$entity->modify_feature )
            <x-select
                :model="$entity"
                name="modify_feature"
                label="{{__('cms.select_category_feature_to_modify')}}"
                options="{!! json_encode([
                    'type'=>'select2',
                    'class'=>'mt-2',
                    'placeholder'=>__('cms.select.default'),
                    'alert' => __('cms.hint_select_category_feature_to_modify')
                    ]) !!}"
            >
                @foreach($entity->entity_features as $entity_feature)
                    <option
                        value="{{$entity_feature->feature_id}}"
                        @if($entity_feature->modify_feature) selected @endif
                    >
                        {{$entity_feature->feature->name}}
                    </option>
                @endforeach
            </x-select>
        @else
            <div class="mt-2">
                @foreach($entity->entity_features as $entity_feature)
                    @if($entity->modify_feature === $entity_feature->feature_id)
                        <x-input
                            label="{{__('cms.category_feature_to_modify')}}"
                            name="modify_feature"
                            value="{{ $entity_feature->feature->name }}"
                            options="{!! json_encode([ 'readonly'=>true, 'disabled'=>true]) !!}"
                        >
                        </x-input>
                    @endif
                @endforeach
            </div>
        @endif

    @endif

@else
    <h4>{{__('cms.Adding_characteristics_of_this_category_is_not_possible')}}</h4>
@endif

@section('form-buttons')
    <x-button
        type="submit"
        class="primary text-capitalize "
        title="{{__('cms.buttons.save')}}"
    ></x-button>
@endsection

