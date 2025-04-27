@extends('layouts.app')
@section('title', 'Confirm Your Password')

@include('layouts.partials.navbar-dashboard')  
@section('content')
<div class="mx-auto md:h-screen flex flex-col justify-center items-center px-6 pt-8 md-0 mt-16">
    <!-- Logo et Titre -->
    <a href="{{ route('home') }}" class="text-2xl font-semibold flex justify-center items-center mb-8 lg:mb-10">
        <img src="/images/logo.svg" class="h-10 mr-4" alt="Logo Windster">
        <span class="self-center text-2xl font-bold whitespace-nowrap">Tuni-repair</span> 
    </a>

    <!-- Card -->
    <div class="bg-white shadow-lg rounded-lg md:mt-0 w-full sm:max-w-screen-sm xl:p-0">
        <div class="p-6 sm:p-8 lg:p-16 space-y-8">
            <h2 class="text-2xl lg:text-3xl font-bold text-gray-900">
                Please confirm your password
            </h2>

            <div class="mb-4 text-sm text-gray-600">
                {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
            </div>

            <!-- Formulaire de confirmation du mot de passe -->
            <form method="POST" action="{{ route('password.confirm') }}">
                @csrf

                <!-- Champ Mot de passe -->
                <div>
                    <label for="password" class="text-sm font-medium text-gray-900 block mb-2">Your password</label>
                    <input type="password" name="password" id="password"
                        class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5"
                        required autocomplete="current-password">
                    @if ($errors->has('password'))
                        <p class="text-red-500 text-sm mt-2">{{ $errors->first('password') }}</p>
                    @endif
                </div>

                <!-- Bouton de soumission -->
                <div class="flex justify-end mt-4">
                    <button type="submit"
                        class="text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium rounded-lg text-base px-5 py-3 w-full sm:w-auto text-center">
                        Confirm
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
