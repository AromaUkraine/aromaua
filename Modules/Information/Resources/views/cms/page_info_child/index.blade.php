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
            'name'=>$parent->title,
        ],
]
  ]) }}


@section('actions')

    <x-action
        href="{{ route('module.page_info_child.create', [$page->id, $pageComponent->alias, $parent->id]) }}"
        class="success text-capitalize mr-1"
        title="{{__('cms.buttons.create')}}"
        icon="bx bx-plus"></x-action>

    @if(!request('trash'))
        <x-action
            href="{{ route('module.page_info_child.index', [$page->id, $pageComponent->alias, $parent->id, 'trash'=>true]) }}"
            class="danger text-capitalize "
            title="{{__('cms.buttons.deleted')}}"
            icon="bx bx-trash"></x-action>
    @else
        <x-action
            href="{{ route('module.page_info_child.index', [$page->id, $pageComponent->alias, $parent->id]) }}"
            class="light text-capitalize"
            title="{{__('cms.buttons.list')}}"
            icon="bx bx-list-ul"></x-action>
    @endif

@endsection

@section('content')
    <div class="row ">
        <div class="col-12">
            <x-card expand>
                <x-nav-page :page="$page" >
                    {{$dataTable->table()}}
                </x-nav-page>
            </x-card>
        </div>
    </div>
@endsection

@push('scripts')
    {{$dataTable->scripts()}}
@endpush
