@extends('layouts.cms')

{{ \Breadcrumbs::make([ 'page'=>$page ,  'last'=>['name'=>$info->title ?? 'cms.edit'] ]) }}

@section('actions')
    <x-action
        href="{{ route('module.page_info.index', [$page->id, $pageComponent->alias]) }}"
        class="light text-capitalize"
        title="{{__('cms.buttons.list')}}"
        icon="bx bx-list-ul"></x-action>
@endsection

@section('content')
    <div class="row ">
        <div class="col-12">
            <x-card expand>
                <x-nav-page :page="$page" form="{!! json_encode( ['route'=>['module.page_info.update', $info->id ] ] ) !!}"  >
                    @include('information::cms.page_info._form')
                </x-nav-page>
            </x-card>
        </div>
    </div>
@endsection
