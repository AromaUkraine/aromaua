@extends('layouts.web')

@section('slider')
    <x-slider-slick key="slider-main" :page="$page"></x-slider-slick>
@endsection
@section('content')
    <x-banner-catalog key="catalog-banner-main" :page="$page"></x-banner-catalog>
    <x-info-advantages key="advantages" :page="$page"></x-info-advantages>
    <x-about-company key="about-company-main" :page="$page"></x-about-company>
    <x-article-latest limit=3></x-article-latest>
@endsection


