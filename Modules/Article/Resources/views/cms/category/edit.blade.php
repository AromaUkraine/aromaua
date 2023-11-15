@extends('layouts.cms')

{{ \Breadcrumbs::make([ 'page'=>$page, 'last'=>['name'=>$category->page->name] ]) }}

@section('actions')
    <x-action
        href="{{ route('module.article_category.index', $page->id) }}"
        class="light text-capitalize"
        title="{{__('cms.buttons.list')}}"
        icon="bx bx-list-ul"></x-action>
@endsection

@section('content')
    <div class="row ">
        <div class="col-12">
            <x-card expand>
                <x-nav-entity
                    :page="$page"
                    :entity="$category"
                    form="{!! json_encode( ['route'=>['module.article_category.update',$page->id, $category->id] ] ) !!}"
                >
                    @include('article::cms.category._form',['category'=>$category,'page'=>$page])
                </x-nav-entity>
            </x-card>
        </div>
    </div>
@endsection




