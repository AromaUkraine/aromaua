@extends('layouts.cms')

{{ \Breadcrumbs::make([ 'last'=>[ 'name'=> $category->page->name ] ]) }}

@section('actions')
    <x-action
        href="{{ route('catalog.product_category.create') }}"
        class="success text-capitalize mr-1"
        title="{{__('cms.buttons.create')}}"
        icon="bx bx-plus"></x-action>
    <x-action
        href="{{ route('catalog.product_category.index') }}"
        class="light text-capitalize"
        title="{{__('cms.buttons.list')}}"
        icon="bx bx-list-ul"></x-action>
@endsection

@section('content')
    <div class="row ">
        <div class="col-12">
            <x-card expand>
                <x-nav-entity :entity="$category" form="{!! json_encode(['route' => ['catalog.product_category.update', $category->id] ]) !!} ">
                    @include('catalog::cms.product_category._form')
                </x-nav-entity>
            </x-card>
        </div>
    </div>
@endsection
