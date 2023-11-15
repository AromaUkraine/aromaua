@extends('layouts.cms')

{{ \Breadcrumbs::make([ 'page'=>$page, 'last'=>['name'=>$article->page->name] ]) }}

@section('actions')
    <x-action
        href="{{ route('module.article.create', $page->id ) }}"
        class="success text-capitalize  mr-1"
        title="{{__('cms.buttons.create')}}"
        icon="bx bx-plus"></x-action>
    <x-action
        href="{{ route('module.article.index', $page->id) }}"
        class="light text-capitalize"
        title="{{__('cms.buttons.list')}}"
        icon="bx bx-list-ul"></x-action>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <x-card expand>
                <x-nav-entity
                    :page="$page"
                    :entity="$article"
                    form="{!! json_encode( ['route'=>['module.article.update',$page->id, $article->id] ] ) !!}"
                >
                    @include('article::cms.article._form',['article'=>$article,'page'=>$page])
                </x-nav-entity>
            </x-card>
        </div>
    </div>
@endsection

