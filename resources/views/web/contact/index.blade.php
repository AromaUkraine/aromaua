@extends('layouts.web')

@section('content')
    <x-page-breadcrumbs :page="$page"></x-page-breadcrumbs>
    <section class="contacts">
        <h1 class="contacts__title h1">{{ $page->name }}</h1>
        <v-contacts></v-contacts>
    </section>
@endsection
{{-- <script  src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDIEK1iM3ns8mizRGYzIWgLPejghjHqFGk" async></script> --}}
