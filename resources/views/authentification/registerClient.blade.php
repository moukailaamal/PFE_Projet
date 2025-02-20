@extends('layouts.app')
@section('content')
<div class="mx-auto md:h-screen flex flex-col justify-center items-center px-6 pt-8 md:mt-0">
    <!-- Logo et Titre -->
    <a href="/" class="text-2xl font-semibold flex justify-center items-center mb-8 lg:mb-10">
        <img src="/images/logo.svg" class="h-10 mr-4" alt="TuniRepair  Logo">
        <span class="self-center text-2xl font-bold whitespace-nowrap">Tuni repair </span> 
    </a>

    <!-- Card -->
    <div class="bg-white shadow-lg rounded-lg md:mt-0 w-full sm:max-w-screen-sm xl:p-0">
        <div class="p-6 sm:p-8 lg:p-16 space-y-8">
            <h2 class="text-2xl lg:text-3xl font-bold text-black">
                Create a Free Account
            </h2>

            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        
        <form class="mt-8 space-y-6" method="POST" action="{{ route('register.client') }}">
            @csrf
        
            <!-- Prénom -->
            <div>
                <label for="first_name" class="text-sm font-medium text-gray-900 block mb-2">Your first name</label>
                <input type="text" name="first_name" id="first_name" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5" placeholder="First Name" required value="{{ old('first_name') }}">
                @error('first_name')
                    <div class="text-red-500">{{ $message }}</div>
                @enderror
            </div>
        
            <!-- Nom -->
            <div>
                <label for="last_name" class="text-sm font-medium text-gray-900 block mb-2">Your last name</label>
                <input type="text" name="last_name" id="last_name" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5" placeholder="Last Name" required value="{{ old('last_name') }}">
                @error('last_name')
                    <div class="text-red-500">{{ $message }}</div>
                @enderror
            </div>
        
            <!-- Adresse -->
            <div>
                <label for="address" class="text-sm font-medium text-gray-900 block mb-2">Address</label>
                <input type="text" name="address" id="address" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5" placeholder="123 Street, City" required>
            </div>
        
            <!-- Sexe -->
            <div>
                <label for="gender" class="text-sm font-medium text-gray-900 block mb-2">Gender</label>
                <select name="gender" id="gender" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5">
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                    <option value="other">Other</option>
                </select>
            </div>
        
            <!-- Numéro de téléphone -->
            <div>
                <label for="phone_number" class="text-sm font-medium text-gray-900 block mb-2">Phone Number</label>
                <input type="tel" name="phone_number" id="phone_number" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5" placeholder="+21623456789" required>
            </div>
        
            <!-- Email -->
            <div>
                <label for="email" class="text-sm font-medium text-gray-900 block mb-2">Your email</label>
                <input type="email" name="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5" placeholder="name@company.com" required value="{{ old('email') }}">
                @error('email')
                    <div class="text-red-500">{{ $message }}</div>
                @enderror
            </div>
        
            <!-- Mot de passe -->
            <div>
                <label for="password" class="text-sm font-medium text-gray-900 block mb-2">Your password</label>
                <input type="password" name="password" id="password" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5" required>
                @error('password')
                    <div class="text-red-500">{{ $message }}</div>
                @enderror
            </div>
        
            <!-- Confirmer le mot de passe -->
            <div>
                <label for="password_confirmation" class="text-sm font-medium text-gray-900 block mb-2">Confirm your password</label>
                <input type="password" name="password_confirmation" id="password_confirmation" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5" required>
                @error('password_confirmation')
                    <div class="text-red-500">{{ $message }}</div>
                @enderror
            </div>
            <div class="flex items-start">
                <div class="flex items-center h-5">
                    <input id="remember" aria-describedby="remember" name="remember" type="checkbox" class="bg-gray-50 border-gray-300 focus:ring-3 focus:ring-cyan-200 h-4 w-4 rounded" required>
                </div>
                <div class="text-sm ml-3">
                    <label for="remember" class="font-medium text-gray-900">I accept the <a href="#" class="text-teal-500 hover:underline">Terms and Conditions</a></label>
                </div>
            </div>
            
            <button type="submit" class="text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium rounded-lg text-base px-5 py-3 w-full sm:w-auto text-center">Create account</button>
            <div class="text-sm font-medium text-gray-500">
                Already have an account? <a href="{{< ref "/authentication/sign-in.html" >}}" class="text-teal-500 hover:underline">Login here</a>
            </div>

            <!-- Bouton de soumission -->
            <button type="submit" class="text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium rounded-lg text-base px-5 py-3 w-full sm:w-auto text-center">
                Create account
            </button>
        </form>
        
        
        </div>
    </div>
</div>

@endsection
