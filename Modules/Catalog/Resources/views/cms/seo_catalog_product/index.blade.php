@extends('layouts.cms')

{{ \Breadcrumbs::make([ 'entity'=> $entity ]) }}

@section('actions')
    @if(!request()->has('add'))
        <x-action
            href="{{ route('module.seo_catalog_product.index', [$table, $id, 'add']) }}"
            class="success text-capitalize "
            title="{{__('cms.buttons.add')}}"
            icon="bx bx-plus"></x-action>
    @else
        <x-action
            href="{{ route('module.seo_catalog_product.index',  [$table, $id]) }}"
            class="light text-capitalize"
            title="{{__('cms.buttons.list')}}"
            icon="bx bx-list-ul"></x-action>
    @endif
@endsection

@section('content')
    <div class="row ">
        <div class="col-12">
            <x-card expand>
                <x-nav-entity :entity="$entity"  >
                    {{$dataTable->table()}}
                </x-nav-entity>
            </x-card>
        </div>
    </div>
@endsection
@push('scripts')
    {{$dataTable->scripts()}}
@endpush
