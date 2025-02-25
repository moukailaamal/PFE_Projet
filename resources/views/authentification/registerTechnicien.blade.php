@extends('layouts.app')
@section('title', 'create your account')

@section('content')

<div class="min-h-screen flex flex-col justify-center items-center px-6 pt-8">
    @if(session('success'))
    <div class="bg-green-500 text-white p-4 rounded-lg">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="bg-red-500 text-white p-4 rounded-lg">
        {{ session('error') }}
    </div>
@endif


    <!-- Card -->
    <div class="bg-white shadow-lg rounded-lg w-full sm:max-w-screen-sm xl:p-0 border border-gray-300">
        <div class="p-6 sm:p-8 lg:p-16 space-y-8">
             <!-- Logo et Titre -->
            <a href="/" class="flex justify-center items-center mb-8 lg:mb-10">
                <img src="{{ asset('images/logo.svg') }}" class="h-10 mr-4" alt="TuniRepair Logo">
                <span class="self-center text-2xl font-bold whitespace-nowrap text-black">Tuni repair</span>
            </a>
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
            
            <form class="mt-8 space-y-6" method="POST" action="{{ route('register.Technicien') }}" enctype="multipart/form-data">
                @csrf
            
                <!-- Prénom -->
                <div>
                    <label for="first_name" class="text-sm font-medium text-gray-900 block mb-2">Your first name</label>
                    <input type="text" name="first_name" id="first_name" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5" placeholder="First Name" required value="{{ old('first_name') }}" autocomplete="given-name">
                    @error('first_name')
                        <div class="text-red-500">{{ $message }}</div>
                    @enderror
                </div>
            
                <!-- Nom -->
                <div>
                    <label for="last_name" class="text-sm font-medium text-gray-900 block mb-2">Your last name</label>
                    <input type="text" name="last_name" id="last_name" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5" placeholder="Last Name" required value="{{ old('last_name') }}" autocomplete="family-name">
                    @error('last_name')
                        <div class="text-red-500">{{ $message }}</div>
                    @enderror
                </div>
            
                <!-- Adresse -->
                <div>
                    <label for="address" class="text-sm font-medium text-gray-900 block mb-2">Address</label>
                    <input type="text" name="address" id="address" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5" placeholder="123 Street, City" required value="{{ old('address') }}" autocomplete="street-address">
                    @error('address')
                        <div class="text-red-500">{{ $message }}</div>
                    @enderror
                </div>
            
                <!-- Sexe -->
                <div>
                    <label for="gender" class="text-sm font-medium text-gray-900 block mb-2">Gender</label>
                    <select name="gender" id="gender" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5" required>
                        <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                        <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                        <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>Other</option>
                    </select>
                    @error('gender')
                        <div class="text-red-500">{{ $message }}</div>
                    @enderror
                </div>
            
                <!-- Numéro de téléphone -->
                <div>
                    <label for="phone_number" class="text-sm font-medium text-gray-900 block mb-2">Phone Number</label>
                    <input type="tel" name="phone_number" id="phone_number" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5" placeholder="+21623456789" required value="{{ old('phone_number') }}" autocomplete="tel">
                    @error('phone_number')
                        <div class="text-red-500">{{ $message }}</div>
                    @enderror
                </div>
            
                <!-- Email -->
                <div>
                    <label for="email" class="text-sm font-medium text-gray-900 block mb-2">Your email</label>
                    <input type="email" name="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5" placeholder="name@company.com" required value="{{ old('email') }}" autocomplete="email">
                    @error('email')
                        <div class="text-red-500">{{ $message }}</div>
                    @enderror
                </div>
            
                <!-- Mot de passe -->
                <div>
                    <label for="password" class="text-sm font-medium text-gray-900 block mb-2">Your password</label>
                    <input type="password" name="password" id="password" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5" required autocomplete="new-password">
                    @error('password')
                        <div class="text-red-500">{{ $message }}</div>
                    @enderror
                </div>
            
                <!-- Confirmer le mot de passe -->
                <div>
                    <label for="password_confirmation" class="text-sm font-medium text-gray-900 block mb-2">Confirm your password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5" required autocomplete="new-password">
                    @error('password_confirmation')
                        <div class="text-red-500">{{ $message }}</div>
                    @enderror
                </div>
            <!-- 📌 Certificate Upload -->
                <div class="mb-4">
                    <label for="certificat" class="block font-medium">Certificate (PDF, JPG, PNG)</label>
                    <input type="file" id="certificat" name="certificat_path" class="w-full border rounded p-2" 
                        accept=".pdf, .jpg, .jpeg, .png">
                        @error('certificat_path')
                        <div class="text-red-500">{{ $message }}</div>
                    @enderror
                </div>

                <!-- 📌 Identity Document Upload -->
                <div class="mb-4">
                    <label for="identite" class="block font-medium">Identity Document (PDF, JPG, PNG)</label>
                    <input type="file" id="identite" name="identite_path" class="w-full border rounded p-2" 
                        accept=".pdf, .jpg, .jpeg, .png">
                        @error('certificat_path')
                        <div class="text-red-500">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Accepter les termes -->
                <div class="flex items-start">
                    <div class="flex items-center h-5">
                        <input id="terms" name="terms" type="checkbox" class="bg-gray-50 border-gray-300 focus:ring-3 focus:ring-cyan-200 h-4 w-4 rounded" required>
                    </div>
                    <div class="text-sm ml-3">
                        <label for="terms" class="font-medium text-gray-900">I accept the <a href="#" class="text-teal-500 hover:underline">Terms and Conditions</a></label>
                    </div>
                </div>
            
                <!-- Bouton de soumission -->
                <button type="submit" class="text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium rounded-lg text-base px-5 py-3 w-full sm:w-auto text-center">
                    Create account
                </button>
            
                <div class="text-sm font-medium text-gray-500">
                    Already have an account? <a href="{{ route('login') }}" class="text-teal-500 hover:underline">Login here</a>
                </div>
            </form>
        </div>
    </div>
    
</div>

@endsection
