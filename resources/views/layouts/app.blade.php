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

    <div class="ml-64 p-4"> 
        @yield('content')   <!-- Contenu spécifique de chaque page -->
    </div>

    <script src="{{ asset('/public/js/app.js') }}"></script>
    <script src="{{ asset('/public/js/charts.js') }}"></script>
    <script src="{{ asset('/public/js/sidebar.js') }}"></script>


</body>
</html>
