<!DOCTYPE html>
<html lang="fr">
<head>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    @include('layouts.partials.header')
    @include('layouts.partials.stylesheet')
    @include('layouts.partials.navbar-dashboard')  
    @include('layouts.partials.sidebar')   


    <div class="content">
        @yield('content')   <!-- Contenu spécifique de chaque page -->
    </div>

    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/charts.js') }}"></script>
    <script src="{{ asset('js/sidebar.js') }}"></script>

</body>
</html>
