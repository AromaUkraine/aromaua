@extends('layouts.cms')

{{ \Breadcrumbs::make([
    'items' =>[
        [
            'name'=>'cms.catalog'
        ],
        [
            'slug'=>'catalog.feature_kind.index',
            'name'=>'catalog.feature_kind.index'
        ],
        [
            'name'=> $kind->name,
            'slug'=> 'catalog.feature_kind.edit',
            'params'=>$kind->id
        ],
        [
            'name'=>__('cms.new_record')
        ]
    ]
]) }}

@section('actions')
    <x-action
        href="{{ route('module.feature_value.index', $kind->id) }}"
        class="light text-capitalize"
        title="{{__('cms.buttons.list')}}"
        icon="bx bx-list-ul"></x-action>
@endsection

@section('content')
    <div class="row ">
        <div class="col-6">
            <x-form expand options="{!! json_encode(['route' => ['module.feature_value.store', $kind->id] ]) !!} ">
                @include('catalog::cms.feature_value._form',['value'=>null])
            </x-form>
        </div>
    </div>
@endsection





