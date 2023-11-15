@extends('layouts.cms')

@section('actions')
    <x-action
            href="{{ route('developer.template.index') }}"
            class="light text-capitalize"
            title="{{__('cms.buttons.list')}}"
            icon="bx bx-list-ul"></x-action>
@endsection

@section('content')
    <div class="row">
        <div class="col-12 ">
            <x-form expand options="{!! json_encode(['route' => 'developer.template.store']) !!} ">
                @include('developer::template._form',['template'=>null])
            </x-form>
        </div>
    </div>
@endsection



