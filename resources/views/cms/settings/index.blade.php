@extends('layouts.cms')

@section('actions')
    @role($roles)
        <x-action
            href="{{ route('root.settings.create') }}"
            class="success text-capitalize"
            title="{{__('cms.buttons.create')}}"
            icon="bx bx-plus"></x-action>
    @endrole
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <x-card  expand>
                {{$dataTable->table()}}
            </x-card>
        </div>
    </div>
@endsection

@push('scripts')
    {{$dataTable->scripts()}}
@endpush

