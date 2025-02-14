<!doctype html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}" class="{{ isset($htmlClass) ? $htmlClass : '' }}">
  <head>
    <link rel="canonical" href="{{ url()->current() }}">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="{{ config('app.author') }}">
    <meta name="generator" content="Laravel v{{ app()->version() }}">
    <title>{{ $pageTitle ?? config('app.name') }} · {{ config('app.name') }} v{{ config('app.version') }}</title>

    <!-- Include CSS files -->
    @include('layouts.partials.stylesheet')
    @include('layouts.partials.favicons')

    <script src="{{ asset('js/system.bundle.js') }}"></script>

    @if (isset($robots))
        <meta name="robots" content="{{ $robots }}">
    @endif

    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>

    @foreach ($extraCss ?? [] as $css)
        <link href="{{ $css }}" rel="stylesheet">
    @endforeach
  </head>

  <body class="{{ isset($bodyClass) ? $bodyClass : '' }}">
    @yield('content')  <!-- Content from the page -->
  </body>
</html>
