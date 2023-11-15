@extends('layouts.cms')

@section('content')
    <div class="row">
        <div class="col-12">
            <x-card expand>
                {{$dataTable->table()}}
            </x-card>
        </div>
    </div>
@endsection

@push('scripts')
    {{$dataTable->scripts()}}
@endpush
