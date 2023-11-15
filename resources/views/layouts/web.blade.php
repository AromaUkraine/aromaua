<!DOCTYPE html>
<html lang="{{ \App::getLocale() }}">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="theme-color" content="#ffffff">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('images/web/favicon/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/web/favicon/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/web/favicon/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('images/web/favicon/site.webmanifest') }}">
    <link rel="mask-icon" href="{{ asset('images/web/favicon/safari-pinned-tab.svg') }}" color="#5bbad5">
    <link rel="stylesheet" type="text/css" href="{{ mix('css/web.css') }}">

    <x-meta-tags :page=$page></x-meta-tags>

</head>

<body>
    <div class="l-container" id="app">
        <header class="header">
            <x-header-top :page=$page></x-header-top>
            <x-header-main :page=$page></x-header-main>
        </header>
        @yield('slider')
        <main class="page">
            @yield('breadcrumbs')
            @yield('content')
        </main>
        @yield('full-page')
        <footer class="footer">
            <x-footer-top></x-footer-top>
            <x-footer-main></x-footer-main>
        </footer>
    </div>
    <script src="{{ mix('js/web.js') }}" defer async></script>
</body>

</html>
