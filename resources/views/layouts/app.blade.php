<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- External CDNs -->
    <script src="https://js.pusher.com/8.4.0/pusher.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>


  
    <!-- Local CSS (si vraiment séparé de Tailwind) -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/chat.css') }}">

    <!-- Vite assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <title>@yield('title', 'My Application')</title>
</head>
<body>
    <!-- Partials -->
    @include('layouts.partials.header')
    @include('layouts.partials.stylesheet')
    @include('layouts.partials.navbar-dashboard')  
    @include('layouts.partials.sidebar')   

    <!-- Main content -->
    <div class="p-4 w-full md:ml-64 md:w-auto transition-all duration-300">
        @yield('content')
    </div>
</body>

</html>

