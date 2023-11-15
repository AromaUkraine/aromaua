@extends('layouts.cms')

{{ \Breadcrumbs::make([ 'page'=>$page, 'entity'=>$entity]) }}

@section('actions')

    @if(!request('trash'))

        <x-action
            href="{{ route('module.entity_gallery.create', [$page->id, $table, $id, \Modules\Gallery\Entities\Gallery::TYPE_VIDEO ]) }}"
            class="primary text-capitalize  mr-1"
            title="{{__('cms.buttons.add_video')}}"
            icon="bx bx-plus"></x-action>

        <x-action
            href="{{ route('module.entity_gallery.create', [$page->id, $table, $id, \Modules\Gallery\Entities\Gallery::TYPE_PHOTO]) }}"
            class="success text-capitalize  mr-1"
            title="{{__('cms.buttons.add_photo')}}"
            icon="bx bx-plus"></x-action>

        <x-action
            href="{{ route('module.entity_gallery.index', [$page->id, $table, $id, 'trash'=>true]) }}"
            class="danger text-capitalize "
            title="{{__('cms.buttons.deleted')}}"
            icon="bx bx-trash"></x-action>
    @else
        <x-action
            href="{{ route('module.entity_gallery.index',  [$page->id, $table, $id ]) }}"
            class="light text-capitalize"
            title="{{__('cms.buttons.list')}}"
            icon="bx bx-list-ul"></x-action>
    @endif

@endsection


@section('content')
    <div class="row">
        <div class="col-12">
            <x-card expand>

                <x-nav-entity :page="$page" :entity="$entity" >
                    {{$dataTable->table()}}
                </x-nav-entity>
            </x-card>
        </div>
    </div>
@endsection

@push('scripts')
    {{$dataTable->scripts()}}
@endpush
