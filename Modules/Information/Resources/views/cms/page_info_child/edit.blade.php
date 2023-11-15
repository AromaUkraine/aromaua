@extends('layouts.cms')

{{ \Breadcrumbs::make([
    'items'=>[
        [
            'slug'=>'section.page.index',
            'name'=>$page->name
        ],
        [
            'slug'=>'module.page_info.index',
            'name'=>$pageComponent->name,
            'params'=>[$page->id, $pageComponent->alias]
        ],
        [
            'slug'=>'module.page_info.edit',
            'name'=>$parent->title,
            'params'=>[$page->id, $pageComponent->alias, $parent->id]
        ],
],
'last'=>['name'=>$child->title] ]) }}

@section('actions')
    <x-action
        href="{{ route('module.page_info_child.index', [$page->id, $pageComponent->alias, $parent->id]) }}"
        class="light text-capitalize"
        title="{{__('cms.buttons.list')}}"
        icon="bx bx-list-ul"></x-action>
@endsection

@section('content')
    <div class="row ">
        <div class="col-12">
            <x-card expand>
                <x-nav-page :page="$page" form="{!! json_encode( ['route'=>['module.page_info_child.update',[$page->id, $pageComponent->alias, $parent->id, $child->id] ] ] ) !!}"  >
                    @include('information::cms.page_info_child._form')
                </x-nav-page>
            </x-card>
        </div>
    </div>
@endsection




