@extends('layouts.cms')
{{ Breadcrumbs::make([ 'last'=>['name'=>$seo->page->name] ]) }}
@section('actions')
    <x-action
        href="{{ route('catalog.seo_catalog.create') }}"
        class="success text-capitalize mr-1"
        title="{{__('cms.buttons.create')}}"
        icon="bx bx-plus"></x-action>
    <x-action
        href="{{ route('catalog.seo_catalog.index') }}"
        class="light text-capitalize"
        title="{{__('cms.buttons.list')}}"
        icon="bx bx-list-ul"></x-action>
@endsection

@section('content')
    <div class="row ">
        <div class="col-12">
            <x-card expand>
                <x-nav-entity :entity="$seo" form="{!! json_encode(['route' => ['catalog.seo_catalog.update', $seo->id] ]) !!} ">
                    @include('catalog::cms.seo_catalog._form')
                </x-nav-entity>
            </x-card>
        </div>
    </div>
@endsection
