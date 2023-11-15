@extends('layouts.web')

@section('content')

    <x-page-breadcrumbs :page="$page"></x-page-breadcrumbs>

    <article class="about">
        <h1 class="about__title h1">{{ $page->name }}</h1>
        {!! $page->text !!}
        <!-- BEGIN: gallery-->
        <x-gallery-page :page="$page" :component="$component"></x-gallery-page>
        <!-- END: gallery-->
    </article>
@endsection
