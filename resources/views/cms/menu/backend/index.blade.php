@extends('layouts.cms')

@section('actions')
    <x-action
        href="{{ route('admin.backend_menu.create') }}"
        class="success text-capitalize"
        title="{{ __('cms.buttons.create') }}"
        icon="bx bx-plus"></x-action>
@endsection


@section('content')
    <div class="row">
        <div class="col-12" >
            <x-card expand>
                <x-menu-nested-tree from="backend" ></x-menu-nested-tree>
            </x-card>
        </div>
    </div>
@endsection

