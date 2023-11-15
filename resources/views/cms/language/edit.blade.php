@extends('layouts.cms')

{{ \Breadcrumbs::make([ 'last'=>[ 'name'=> $language->name ] ]) }}
@section('actions')
    <x-action
        href="{{ route('admin.language.create') }}"
        class="success text-capitalize mr-1"
        title="{{__('cms.buttons.create')}}"
        icon="bx bx-plus"></x-action>
    <x-action
        href="{{ route('admin.language.index') }}"
        class="light text-capitalize"
        title="{{__('cms.buttons.list')}}"
        icon="bx bx-list-ul"></x-action>
@endsection

@section('content')
    <div class="row">
        <div class="col-6">
            <x-form expand options="{!! json_encode(['route'=>['admin.language.update', $language->id],  'method'=>'patch']) !!}" >
                @include('cms.language._form')
            </x-form>
        </div>
    </div>
@endsection



