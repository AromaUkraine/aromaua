@extends('layouts.cms')

{{ \Breadcrumbs::make([ 'entity'=> $entity ]) }}

@section('actions')
    <x-action
        href="{{ route('module.feature_modify.create',[$table, $id]) }}"
        class="success text-capitalize mr-1"
        title="{{__('cms.buttons.create')}}"
        icon="bx bx-plus"></x-action>
    <x-action
        href="{{ route('module.feature_modify.index',[$table, $id]) }}"
        class="light text-capitalize"
        title="{{__('cms.buttons.list')}}"
        icon="bx bx-list-ul"></x-action>
@endsection

@section('content')
    <div class="row ">
        <div class="col-12">
            <x-card expand>
                <x-nav-inner-entity :entity="$entity"
                                    form="{!! json_encode( [ 'route' => ['module.feature_modify.joined', 'table'=>$table, 'id'=>$id] ]) !!}" >

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

                    <x-catalog-cms-product-parent-product-list
                        :model="$entity"
                        name="parent_product_id"
                    >
                    </x-catalog-cms-product-parent-product-list>

                    <x-switcher
                        :model="$entity"
                        name="copy"
                        label="{{ __('cms.copy_features_from_parent') }}"
                        options="{!! json_encode(['class'=>'float-right']) !!}"
                    ></x-switcher>


                    @section('form-buttons')
                        <x-button
                            type="submit"
                            class="primary  mr-1 text-capitalize "
                            title="{{__('cms.buttons.save')}}"
                        ></x-button>
                        <x-action
                            href="{{ route('module.feature_modify.index',[$table, $id]) }}"
                            class="light  text-capitalize"
                            title="{{__('cms.buttons.cancel')}}"
                        ></x-action>
                    @endsection

                </x-nav-inner-entity>
            </x-card>
        </div>
    </div>
@endsection
