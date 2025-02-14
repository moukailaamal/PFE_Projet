@extends('layouts.app')  <!-- Utiliser le layout principal -->

@section('navbar')
    @include('layouts.partials.navbar-dashboard')  <!-- Inclure la barre de navigation -->
@endsection

@section('content')  <!-- Définir la section de contenu principal -->
    <div class="flex overflow-hidden bg-white pt-16">

        @include('layouts.partials.sidebar')  <!-- Inclure la sidebar -->

        <div id="main-content" class="h-full w-full bg-gray-50 relative overflow-y-auto lg:ml-64">
            <main>
                @yield('main-content')  <!-- Contenu spécifique à la page -->
            </main>
            
            @if (isset($footer) && $footer)
                @include('layouts.partials.footer-dashboard')  <!-- Inclure le footer si défini -->
            @endif
        </div>

    </div>
@endsection
