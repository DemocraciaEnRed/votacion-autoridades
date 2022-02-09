<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    {{-- Primary Meta Tags --}}
    <title>Democracias Cotidianas</title>
    <meta name="title" content="Democracias Cotidianas">
    <meta name="description" content="Herramienta digital que permite la votación remota de autoridades en procesos electorales cotidianos, aumentando la participación ciudadana.">

    {{-- Open Graph / Facebook --}}
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="Democracias Cotidianas">
    <meta property="og:description" content="Herramienta digital que permite la votación remota de autoridades en procesos electorales cotidianos, aumentando la participación ciudadana.">
    <meta property="og:image" content="{{ asset('img/social.jpg') }}">

    {{-- Twitter --}}
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url()->current() }}">
    <meta property="twitter:title" content="Democracias Cotidianas">
    <meta property="twitter:description" content="Herramienta digital que permite la votación remota de autoridades en procesos electorales cotidianos, aumentando la participación ciudadana.">
    <meta property="twitter:image" content="{{ asset('img/social.jpg') }}">

    {{-- Favicon --}}
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('img/favicon/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('img/favicon/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('img/favicon/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('img/favicon/site.webmanifest') }}">
    <link rel="mask-icon" color="#181c8b" href="{{ asset('img/favicon/safari-pinned-tab.svg') }}">
    <link rel="shortcut icon" href="{{ asset('img/favicon/favicon.ico') }}">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-config" content="{{ asset('img/favicon/browserconfig.xml') }}">
    <meta name="theme-color" content="#ffffff">

    {{-- Styles --}}
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap">
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
</head>
<body>
    
<div id="app"></div>

{{-- Scripts --}}
<script src="{{ asset('js/main.js') }}"></script>

</body>
</html>
