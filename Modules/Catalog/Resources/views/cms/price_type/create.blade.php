@extends('layouts.cms')

{{ \Breadcrumbs::make([ 'last'=>[ 'name'=> __('cms.new_record') ] ]) }}

@section('actions')
    <x-action
        href="{{ route('admin.price_type.index') }}"
        class="light text-capitalize"
        title="{{__('cms.buttons.list')}}"
        icon="bx bx-list-ul"></x-action>
@endsection

@section('content')
    <div class="row ">
        <div class="col-6">
            <x-form expand options="{!! json_encode(['route' => 'admin.price_type.store']) !!} ">
                @include('catalog::cms.price_type._form',['type'=>null])
            </x-form>
        </div>
    </div>
@endsection





