@extends('layouts.cms')

{{ \Breadcrumbs::make([
    'items' =>[
        ['name'=>'cms.administration'],
        ['name'=>'admin.role.index','slug'=>'admin.role.index','params'=>$role->id ],
        ['name'=>'cms.buttons.permission',],
        ['name'=>$role->name]
    ]
]) }}

@section('actions')
    <x-action
            href="{{ route('admin.role.index') }}"
            class="light text-capitalize"
            title="{{__('cms.buttons.list')}}"
            icon="bx bx-list-ul"></x-action>
@endsection

@section('content')
    <div class="row">
        <div class="col-12" >
            <x-form expand options="{!! json_encode(['route' => ['admin.role_permissions.update', $role->id],  'method'=>'patch']) !!} ">

                <x-permission-table :data="$tableData" :used="$used_permissions"></x-permission-table>

                @section('form-fixed-buttons')
                    <x-button
                            type="submit"
                            class="primary text-capitalize mr-1 my-2"
                            title="{{__('cms.buttons.save')}}"
                    ></x-button>
                    <x-action
                            href="{{ route('admin.role.index') }}"
                            class="light text-capitalize my-2"
                            title="{{__('cms.buttons.cancel')}}"
                    ></x-action>
                @endsection
            </x-form>
        </div>
    </div>
@endsection


