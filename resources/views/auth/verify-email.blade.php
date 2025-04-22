@extends('layouts.app')
@section('title', 'Verify Your Email Address')

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
                Verify Your Email Address
            </h2>

            <!-- Message de vérification -->
            <div class="mb-4 text-sm text-gray-600">
                {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
            </div>

            @if (session('status') == 'verification-link-sent')
                <div class="mb-4 font-medium text-sm text-green-600">
                    {{ __('A new verification link has been sent to the email address you provided during registration.') }}
                </div>
            @endif

            <!-- Formulaire de renvoi de lien de vérification -->
            <div class="mt-4 flex items-center justify-between">
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf

                    <div>
                        <x-primary-button>
                            {{ __('Resend Verification Email') }}
                        </x-primary-button>
                    </div>
                </form>

                <!-- Formulaire de déconnexion -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <button type="submit" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        {{ __('Log Out') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
