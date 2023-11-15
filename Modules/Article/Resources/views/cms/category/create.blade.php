@extends('layouts.cms')

{{ \Breadcrumbs::make([ 'page'=>$page, 'last'=>['name'=>__('cms.new_record')] ]) }}

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
                <x-nav-page :page="$page" form="{!! json_encode( ['route'=>['module.article_category.store',$page->id] ] ) !!}"  >
                    @include('article::cms.category._form',['category'=>null,'page'=>$page])
                </x-nav-page>
            </x-card>
        </div>
    </div>
@endsection




