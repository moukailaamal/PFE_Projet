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
<body class="flex flex-col min-h-screen">

    <!-- Message de session -->
    @if (session('status'))
    <div class="text-green-600 text-sm font-medium">
        {{ session('status') }}
    </div>
    @endif

    <!-- Main content area -->
    <div class="flex flex-1">
        @auth
            @if(View::hasSection('sidebar'))
                @yield('sidebar')
            @endif
        @endauth

        <!-- Main content wrapper -->
        <div class="flex-1 flex flex-col">
            <!-- Main content -->
            <main class="flex-1 p-4 transition-all duration-300 @auth @if(View::hasSection('sidebar')) ml-0 lg:ml-64 @endif @endauth">
                @yield('content')
            </main>
            
            <!-- Footer -->
            @include('layouts.partials.footer')
        </div>
    </div>
</body>

</html>

