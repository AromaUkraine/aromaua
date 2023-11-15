@extends('layouts.cms')

{{ \Breadcrumbs::make([ 'last'=>[ 'name'=> __('cms.new_record') ] ]) }}

@section('actions')
    <x-action
            href="{{ route('developer.page.index') }}"
            class="light text-capitalize"
            title="{{__('cms.buttons.list')}}"
            icon="bx bx-list-ul"></x-action>
@endsection

@section('content')
    <div class="row">
        <div class="col-6">
            <x-form expand options="{!! json_encode(['route' => 'developer.page.store', 'class'=>'form-horizontal']) !!} ">
                @include('developer::page._form',['page'=>null])
            </x-form>
        </div>
    </div>
@endsection



