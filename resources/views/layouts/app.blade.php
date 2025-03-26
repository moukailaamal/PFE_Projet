<!DOCTYPE html>
<html lang="fr">
<head>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('/public/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('/ressources/css/style.css') }}">


</head>
<body> 

    @include('layouts.partials.header')
    @include('layouts.partials.stylesheet')
    @include('layouts.partials.navbar-dashboard')  
    @include('layouts.partials.sidebar')   

    <div class="p-4 w-full md:ml-64 md:w-auto transition-all duration-300">
        @yield('content')
    </div>

    <script src="{{ asset('/resources/js/app.js') }}"></script>
    <script src="{{ asset('/public/js/charts.js') }}"></script>
    <script src="{{ asset('/public/js/sidebar.js') }}"></script>


</body>
</html>
