<!DOCTYPE html>
<html lang="fr">
<head>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('http://127.0.0.1:8000/css/style.css') }}">
</head>
<body>
    @include('layouts.partials.header')
    @include('layouts.partials.stylesheet')
    @include('layouts.partials.navbar-dashboard')  
    @include('layouts.partials.sidebar')   


    <div class="content">
        @yield('content')   <!-- Contenu spécifique de chaque page -->
    </div>

    <script src="{{ asset('http://127.0.0.1:8000/js/app.js') }}"></script>
    <script src="{{ asset('http://127.0.0.1:8000/js/charts.js') }}"></script>
    <script src="{{ asset('http://127.0.0.1:8000/js/sidebar.js') }}"></script>

</body>
</html>
