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
        ]
    ]
]) }}

@section('actions')

    @if(!request('trash'))
        <x-action
            href="{{ route('module.feature_value.create', $kind->id) }}"
            class="success text-capitalize mr-1"
            title="{{__('cms.buttons.create')}}"
            icon="bx bx-plus"></x-action>
        <x-action
            href="{{ route('module.feature_value.index', [$kind->id, 'trash'=>true]) }}"
            class="danger text-capitalize "
            title="{{__('cms.buttons.deleted')}}"
            icon="bx bx-trash"></x-action>
    @else
        <x-action
            href="{{ route('module.feature_value.index', $kind->id) }}"
            class="light text-capitalize"
            title="{{__('cms.buttons.list')}}"
            icon="bx bx-list-ul"></x-action>
    @endif

@endsection

@section('content')
    <div class="row ">
        <div class="col-12">
            <x-card expand>
                {{$dataTable->table()}}
            </x-card>
        </div>
    </div>
@endsection

@push('scripts')
    {{$dataTable->scripts()}}
@endpush
