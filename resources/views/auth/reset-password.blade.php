@extends('layouts.app')
@section('title', 'Reset Your Password')

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
                Reset Your Password
            </h2>

            <!-- Formulaire de réinitialisation du mot de passe -->
            <form method="POST" action="{{ route('password.store') }}">
                @csrf

                <!-- Token de réinitialisation du mot de passe -->
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <!-- Champ Email -->
                <div>
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Champ Mot de passe -->
                <div class="mt-4">
                    <x-input-label for="password" :value="__('Password')" />
                    <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Champ Confirmation du mot de passe -->
                <div class="mt-4">
                    <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                    <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                <!-- Bouton de soumission -->
                <div class="flex items-center justify-end mt-4">
                    <x-primary-button>
                        {{ __('Reset Password') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
