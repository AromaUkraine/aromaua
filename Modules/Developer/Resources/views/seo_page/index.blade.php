@extends('layouts.cms')

@section('actions')
    <x-action
        href="{{ route('developer.seo_page.create') }}"
        class="success text-capitalize"
        title="{{__('cms.buttons.create')}}"
        icon="bx bx-plus"></x-action>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <x-card expand>
                <x-slot name="title"> Страницы созданые на основе сео-страниц </x-slot>
                {{$dataTable->table()}}
            </x-card>
        </div>
    </div>
@endsection

@push('scripts')
    {{$dataTable->scripts()}}
@endpush
