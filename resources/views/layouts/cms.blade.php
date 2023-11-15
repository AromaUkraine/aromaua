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

@if(!empty($configData['mainLayoutType']) && isset($configData['mainLayoutType']))
    @include(($configData['mainLayoutType'] === 'horizontal-menu') ? 'layouts.horizontal':'layouts.vertical')
@else
    {{-- if mainLaoutType is empty or not set then its print below line --}}
    <h1>{{'mainLayoutType Option is empty in config custom.php file.'}}</h1>
@endif
</html>
