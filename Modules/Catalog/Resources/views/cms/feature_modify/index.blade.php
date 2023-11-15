@extends('layouts.cms')

{{ \Breadcrumbs::make([ 'entity'=> $entity ]) }}

@section('actions')
    @if(!$entity->parent && !$entity->children->count())
        <x-action
            href="{{ route('module.feature_modify.join',[$table, $id]) }}"
            class="primary  mr-1"
            title="{{__('cms.join_to_exit_modification')}}"
            icon="bx bx-copy"></x-action>

        <x-action
            href="{{ route('module.feature_modify.create',[$table, $id]) }}"
            class="success text-capitalize "
            title="{{__('cms.buttons.create')}}"
            icon="bx bx-plus"></x-action>
    @else
        <x-action
            href="{{ route('module.feature_modify.copy',[$table, $id]) }}"
            class="primary  mr-1"
            title="{{__('cms.copy_features_to_children')}}"
            icon="bx bx-copy"></x-action>
        <x-action
            href="{{ route('module.feature_modify.edit',[$table, $id]) }}"
            class="success text-capitalize "
            title="{{__('cms.buttons.edit')}}"
            icon="bx bx-edit"></x-action>
    @endif
@endsection

@section('content')
    <div class="row ">
        <div class="col-12">
            <x-card expand>
                <x-nav-inner-entity :entity="$entity">
                    {{$dataTable->table()}}
                </x-nav-inner-entity>
            </x-card>
        </div>
    </div>
@endsection

@push('scripts')
    {{$dataTable->scripts()}}
@endpush
