@extends('layouts.cms')

@section('actions')

    @if(!$group)
    <x-action
        href="{{ route('root.translation.store') }}"
        class="info btn-find mr-1"
        title="{{__('translation.import')}}"
        icon="bx bx-file"
        ></x-action>
    @else
        <x-action
            href="{{ route('root.translation.index') }}"
            class="success "
            title="{{__('translation.create new group')}}"
            icon="bx bx-plus"
        ></x-action>
    @endif

@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <x-form expand >
                @include('cms.translation._form_edit')
            </x-form>
        </div>
    </div>
@endsection



