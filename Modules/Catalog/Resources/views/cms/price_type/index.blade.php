@extends('layouts.cms')

@section('actions')

    @if(!request('trash'))
        <x-action
            href="{{ route('admin.price_type.create') }}"
            class="success text-capitalize mr-1"
            title="{{__('cms.buttons.create')}}"
            icon="bx bx-plus"></x-action>
        <x-action
            href="{{ route('admin.price_type.index', ['trash'=>true]) }}"
            class="danger text-capitalize "
            title="{{__('cms.buttons.deleted')}}"
            icon="bx bx-trash"></x-action>
    @else
        <x-action
            href="{{ route('admin.price_type.index') }}"
            class="light text-capitalize"
            title="{{__('cms.buttons.list')}}"
            icon="bx bx-list-ul"></x-action>
    @endif

@endsection

@section('content')
    <div class="row ">
        <div class="col-12">

            <x-card expand>
                {{$dataTable->table()}}
            </x-card>
        </div>
    </div>
@endsection

@push('scripts')
    {{$dataTable->scripts()}}
@endpush

