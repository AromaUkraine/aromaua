@extends('layouts.cms')

{{ \Breadcrumbs::make([ 'page'=>$page, 'entity'=>$entity ,  'last'=>['name'=>$gallery->name ?? 'cms.edit'] ]) }}

@section('actions')
<x-action
    href="{{ route('module.entity_gallery.index', [$page->id,$table, $id]) }}"
    class="light text-capitalize"
    title="{{__('cms.buttons.list')}}"
    icon="bx bx-list-ul"></x-action>
@endsection

@section('content')
<div class="row ">
    <div class="col-12">
        <x-card expand>
            <x-nav-inner-entity :page="$page" :entity="$entity"
                          form="{!! json_encode( [ 'route' => ['module.entity_gallery.update', $page->id, $table, $id, $gallery->id] ]) !!}" >
                @include('gallery::entity._form_'.$gallery->type,['gallery'=>$gallery ])
            </x-nav-inner-entity>
        </x-card>
    </div>
</div>
@endsection
