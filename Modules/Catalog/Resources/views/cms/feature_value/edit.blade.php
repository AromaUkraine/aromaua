@extends('layouts.cms')

{{ \Breadcrumbs::make([
    'items' =>[
        ['name'=>'cms.catalog'],
        ['name'=>'catalog.feature_kind.index','slug'=>'catalog.feature_kind.index' ],
        ['name'=> $kind->name,'slug'=> 'catalog.feature_kind.edit','params'=>$kind->id ],
        ['name'=>$value->name]
    ]
]) }}

@section('actions')
    <x-action
        href="{{ route('module.feature_value.create', $kind->id ) }}"
        class="success text-capitalize  mr-1"
        title="{{__('cms.buttons.create')}}"
        icon="bx bx-plus"></x-action>
    <x-action
        href="{{ route('module.feature_value.index', $kind->id) }}"
        class="light text-capitalize"
        title="{{__('cms.buttons.list')}}"
        icon="bx bx-list-ul"></x-action>
@endsection

@section('content')
    <div class="row">
        <div class="col-6">
            <x-form expand
                    options="{!! json_encode(['route' => ['module.feature_value.update', $kind->id, $value->id], 'method'=>'patch' ]) !!} ">
                @include('catalog::cms.feature_value._form',['value'=>$value])
            </x-form>
        </div>
    </div>
@endsection

