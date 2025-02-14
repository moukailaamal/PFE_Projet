{{-- resources/views/layouts/defaults/main.blade.php --}}
<!doctype html>
<html lang="en">
<head>
    <!-- Insérer ici les meta, titres, liens CSS, etc. -->
    @include('partials.header') {{-- Si tu as un header dans partials --}}
</head>

<body class="{{ request()->is('/') ? 'bg-white' : 'bg-gray-50' }}">

    {{-- Navbar --}}
    @include('partials.navbar')

    {{-- Contenu principal --}}
    <main class="my-auto p-5" id="content">
        @yield('content') {{-- Section dynamique à remplir dans les vues --}}
    </main>

    {{-- Footer --}}
    @include('partials.footer') {{-- Si tu as un footer dans partials --}}

</body>
</html>
