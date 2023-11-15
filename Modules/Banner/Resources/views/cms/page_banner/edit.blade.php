@extends('layouts.cms')

{{ \Breadcrumbs::make([ 'page'=>$page ,  'last'=>['name'=>$banner->name ?? 'cms.edit'] ]) }}

@section('actions')
    <x-action
        href="{{ route('module.page_banner.index', [$page->id, $banner->component->alias]) }}"
        class="light text-capitalize"
        title="{{__('cms.buttons.list')}}"
        icon="bx bx-list-ul"></x-action>
@endsection

@section('content')
    <div class="row ">
        <div class="col-12">
            <x-card expand>
                <x-nav-page :page="$page" form="{!! json_encode( ['route'=>['module.page_banner.update', $banner->id ] ] ) !!}"  >
                    @include('banner::cms.page_banner._form',['alias'=>$banner->component->alias])
                </x-nav-page>
            </x-card>
        </div>
    </div>
@endsection
