@extends('layouts.app')
@section('title', 'Login to Your Account')

@section('content')
 <div class="mx-auto md:h-screen flex flex-col justify-center items-center px-6 pt-8 md:mt-0">
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
          <!-- Formulaire de connexion -->
<form class="mt-8 space-y-6" method="POST" action="{{ route('login') }}">
    @csrf
    <!-- Champ Email -->
    <div>
        <label for="email" class="text-sm font-medium text-gray-900 block mb-2">Your email</label>
        <input type="email" name="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5" placeholder="name@company.com" required>
    </div>

    <!-- Champ Mot de passe -->
    <div>
        <label for="password" class="text-sm font-medium text-gray-900 block mb-2">Your password</label>
        <input type="password" name="password" id="password" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5" required>
    </div>

    <!-- Checkbox "Se souvenir de moi" -->
    <div class="flex items-start">
        <div class="flex items-center h-5">
            <input id="remember" aria-describedby="remember" name="remember" type="checkbox" class="bg-gray-50 border-gray-300 focus:ring-3 focus:ring-cyan-200 h-4 w-4 rounded">
        </div>
        <div class="text-sm ml-3">
            <label for="remember" class="font-medium text-gray-900">Remember me</label>
        </div>
        <a href="#" class="text-sm text-teal-500 hover:underline ml-auto">Lost Password?</a>
    </div>

    <!-- Bouton de soumission -->
    <button type="submit" class="text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium rounded-lg text-base px-5 py-3 w-full sm:w-auto text-center">
        Login to your account
    </button>

    <!-- Lien pour s'inscrire -->
    <div class="text-sm font-medium text-gray-500">
        Not registered Client? <a href="{{ route('register.client.form') }}" class="text-teal-500 hover:underline">Create account</a>
    </div>
    <div class="text-sm font-medium text-gray-500">
        Not registered technician? <a href="{{ route('register.Technicien.form') }}" class="text-teal-500 hover:underline">Create account</a>
    </div>
</form>


        </div>
    </div>
</div>
@endsection
