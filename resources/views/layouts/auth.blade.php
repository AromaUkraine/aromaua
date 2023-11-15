<!DOCTYPE html>
{{-- pageConfigs variable pass to Helper's updatePageConfig function to update page configuration  --}}
@isset($pageConfigs)
    {!! TemplateHelper::updatePageConfig($pageConfigs) !!}
@endisset
@php
    $configData = TemplateHelper::all();
@endphp
<html class="loading" lang="{{ \App::getLocale() }}"
      data-textdirection="{{$configData['direction'] == 'rtl' ? 'rtl' : 'ltr' }}">
<!-- BEGIN: Head-->
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="api-base-url" content="{{ url('api') }}"/>

    @if(!empty($configData['templateTitle']) && isset($configData['templateTitle']))
        <x-cms-page-title></x-cms-page-title>
    @else
        <title>Cms</title>
    @endif
    {{-- Include core + vendor Styles --}}
    @include('cms.panels.styles')
</head>
<!-- END: Head-->
<body class="vertical-layout bg-full-screen-image 1-column navbar-sticky {{$configData['bodyCustomClass']}} footer-static blank-page
  @if($configData['theme'] === 'dark'){{'dark-layout'}} @elseif($configData['theme'] === 'semi-dark'){{'semi-dark-layout'}} @else {{'light-layout'}} @endif" data-open="click" data-menu="vertical-menu-modern" data-col="1-column">
<!-- BEGIN: Content-->
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body">
            @yield('content')
        </div>
    </div>
</div>
<!-- END: Content-->
{{-- scripts --}}
@include('cms.panels.scripts')

</body>
</html>
