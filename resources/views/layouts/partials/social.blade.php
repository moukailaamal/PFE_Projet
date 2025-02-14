<!-- Twitter -->
{!! "<!-- Twitter -->" !!}

<meta name="twitter:card" content="{{ request()->routeIs('home') ? 'summary_large_image' : 'summary' }}">
<meta name="twitter:site" content="@{{ config('app.twitter') }}">
<meta name="twitter:creator" content="@{{ config('app.twitter') }}">
<meta name="twitter:title" content="{{ isset($title) ? $title : 'Default Title' }}">
<meta name="twitter:description" content="{{ $description ?? config('app.description') }}">
<meta name="twitter:image" content="{{ request()->routeIs('home') ? asset(config('app.social_logo_path')) : asset(config('app.social_image_path')) }}">

<!-- Facebook -->
{!! "<!-- Facebook -->" !!}

<meta property="og:url" content="{{ url()->current() }}">
<meta name="twitter:title" content="{{ isset($title) ? $title : 'Default Title' }}">
<meta property="og:description" content="{{ $description ?? config('app.description') }}">
<meta property="og:type" content="{{ request()->routeIs('page') ? 'article' : 'website' }}">
<meta property="og:image" content="{{ asset(config('app.social_image_path')) }}">
<meta property="og:image:type" content="image/png">
