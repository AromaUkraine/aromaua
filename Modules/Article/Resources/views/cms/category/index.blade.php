@extends('layouts.cms')

{{ \Breadcrumbs::make([ 'page'=>$page ]) }}

@section('actions')
    <x-action
        href="{{ route('module.article_category.create', $page->id) }}"
        class="success text-capitalize mr-1"
        title="{{__('cms.buttons.create')}}"
        icon="bx bx-plus"></x-action>

    @if(!request('trash'))
        <x-action
            href="{{ route('module.article_category.index', [$page->id, 'trash'=>true]) }}"
            class="danger text-capitalize "
            title="{{__('cms.buttons.deleted')}}"
            icon="bx bx-trash"></x-action>
    @else
        <x-action
            href="{{ route('module.article_category.index', $page->id) }}"
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
