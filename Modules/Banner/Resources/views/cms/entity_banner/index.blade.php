@extends('layouts.cms')

{{ \Breadcrumbs::make([ 'entity'=>$entity ]) }}

@section('actions')
<x-action
    href="{{ route('module.entity_banner.create', [$table, $id]) }}"
    class="success text-capitalize mr-1"
    title="{{__('cms.buttons.create')}}"
    icon="bx bx-plus"></x-action>

@if(!request('trash'))
<x-action
    href="{{ route('module.entity_banner.index', [$table, $id, 'trash'=>true]) }}"
    class="danger text-capitalize "
    title="{{__('cms.buttons.deleted')}}"
    icon="bx bx-trash"></x-action>
@else
<x-action
    href="{{ route('module.entity_banner.index', [$table, $id]) }}"
    class="light text-capitalize"
    title="{{__('cms.buttons.list')}}"
    icon="bx bx-list-ul"></x-action>
@endif

@endsection

@section('content')
    <div class="row ">
        <div class="col-12">
            <x-card expand>
                <x-nav-inner-entity :entity="$entity" >
                    {{$dataTable->table()}}
                </x-nav-inner-entity>
            </x-card>
        </div>
    </div>
@endsection

@push('scripts')
    {{$dataTable->scripts()}}
@endpush
