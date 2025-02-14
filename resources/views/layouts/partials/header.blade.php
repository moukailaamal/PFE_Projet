<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="@yield('description', 'Description par défaut')">
<meta name="author" content="{{ config('app.author', 'Auteur par défaut') }}">
<meta name="generator" content="Laravel">

<title>@yield('title', 'Titre par défaut')</title>

<link rel="canonical" href="https://themesberg.com/product/tailwind-css/dashboard-windster">

{{-- Robots Meta Tag --}}
@isset($robots)
    <meta name="robots" content="{{ $robots }}">
@endisset

{{-- Intégration des fichiers CSS --}}
<link rel="stylesheet" href="{{ asset('css/style.css') }}">

{{-- Favoris, réseaux sociaux, et analytics --}}
@include('layouts.partials.favicons')
@include('layouts.partials.social')
@include('layouts.partials.analytics')
