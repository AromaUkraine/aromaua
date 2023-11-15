@extends('layouts.cms')

{{ \Breadcrumbs::make([ 'page'=>$page ,  'last'=>['name'=>$gallery->name ?? 'cms.edit'] ]) }}

@section('actions')
    <x-action
        href="{{ route('module.page_gallery.index', [$page->id, $gallery->component->alias]) }}"
        class="light text-capitalize"
        title="{{__('cms.buttons.list')}}"
        icon="bx bx-list-ul"></x-action>
@endsection

@section('content')
    <div class="row ">
        <div class="col-12">
            <x-card expand>
                <x-nav-page :page="$page" form="{!! json_encode( ['route'=>['module.page_gallery.update', $gallery->id ] ] ) !!}"  >
                    @include('gallery::page_gallery._form_'.$gallery->type)
                </x-nav-page>
            </x-card>
        </div>
    </div>
@endsection
