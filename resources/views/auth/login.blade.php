@extends('layouts.app')
@section('title', 'Login to Your Account')

@include('layouts.partials.navbar-dashboard')  
@section('content')
<div class="mx-auto md:h-screen flex flex-col justify-center items-center px-6 pt-8 md-0 mt-16">
    <!-- Logo et Titre -->
    <a href="/" class="text-2xl font-semibold flex justify-center items-center mb-8 lg:mb-10">
        <img src="/images/logo.svg" class="h-10 mr-4" alt="Logo Windster">
        <span class="self-center text-2xl font-bold whitespace-nowrap">Tuni-repair</span> 
    </a>

    <!-- Card -->
    <div class="bg-white shadow-lg rounded-lg md:mt-0 w-full sm:max-w-screen-sm xl:p-0">
        <div class="p-6 sm:p-8 lg:p-16 space-y-8">
            <h2 class="text-2xl lg:text-3xl font-bold text-gray-900">
                Sign in to platform
            </h2>

            <!-- Formulaire de connexion -->
            <form class="mt-8 space-y-6" method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Message de session -->
                @if (session('status'))
                    <div class="text-green-600 text-sm font-medium">
                        {{ session('status') }}
                    </div>
                @endif

                <!-- Champ Email -->
                <div>
                    <x-input-label for="email" :value="__('Your email')" />
                    <x-text-input id="email" type="email" name="email" class="block mt-1 w-full" 
                        :value="old('email')" required autofocus autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Champ Mot de passe -->
                <div class="mt-4">
                    <x-input-label for="password" :value="__('Your password')" />
                    <x-text-input id="password" type="password" name="password" class="block mt-1 w-full" 
                        required autocomplete="current-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Checkbox "Se souvenir de moi" -->
                <div class="flex items-start mt-4">
                    <div class="flex items-center h-5">
                        <input id="remember" aria-describedby="remember" name="remember" type="checkbox"
                            class="bg-gray-50 border-gray-300 focus:ring-3 focus:ring-cyan-200 h-4 w-4 rounded" />
                    </div>
                    <div class="text-sm ml-3">
                        <label for="remember" class="font-medium text-gray-900">Remember me</label>
                    </div>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}"
                            class="text-sm text-teal-500 hover:underline ml-auto">Lost Password?</a>
                    @endif
                </div>

                <!-- Bouton de soumission avec couleur personnalisée -->
                <button type="submit"
                    class="text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium rounded-lg text-base px-5 py-3 w-full sm:w-auto text-center">
                    Login to your account
                </button>
                   <!-- Lien pour s'inscrire -->
    <div class="text-sm font-medium text-gray-500">
        Not registered Client? <a href="{{ route('registerClient') }}" class="text-teal-500 hover:underline">Create account</a>
    </div>
    <div class="text-sm font-medium text-gray-500">
        Not registered technician? <a href="{{ route('registerTechnician') }}" class="text-teal-500 hover:underline">Create account</a>
    </div>
              
            </form>

        </div>
    </div>
</div>
@endsection
