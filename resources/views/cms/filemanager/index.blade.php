@extends('layouts.cms')

@section('content')
    <div class="row">
        <div class="col-12">
            <x-card expand>

                <x-file-manager
                        params="{!!  json_encode(['multiple'=>1])!!}"
                        options="{!! json_encode(['style'=>'width:100%;min-height:67vh;border:none;']) !!}"
                ></x-file-manager>

            </x-card>
        </div>
    </div>
@endsection
