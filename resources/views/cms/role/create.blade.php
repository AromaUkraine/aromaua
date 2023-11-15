@extends('layouts.cms')

{{ \Breadcrumbs::make([ 'last'=>[ 'name'=> __('cms.new_record') ] ]) }}

@section('actions')
    <x-action
            href="{{ route('admin.role.index') }}"
            class="light text-capitalize"
            title="{{__('cms.buttons.list')}}"
            icon="bx bx-list-ul"></x-action>
@endsection

@section('content')
    <div class="row">
        <div class="col-6">
            <x-form expand options="{!! json_encode(['route' => 'admin.role.store']) !!} ">
                @include('cms.role._form',['role'=>null])
            </x-form>
        </div>
    </div>
@endsection





