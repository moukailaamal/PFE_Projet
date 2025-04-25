@extends('layouts.app')

@section('title', 'Create your account')

@include('layouts.partials.navbar-dashboard')  
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
    <div class="bg-white shadow-lg rounded-lg md-0 mt-16 w-full sm:max-w-screen-sm xl:p-0">
        <div class="p-6 sm:p-8 lg:p-16 space-y-8">
            <a href="{{ route('home') }}" class="text-2xl font-semibold flex justify-center items-center mb-8 lg:mb-10">
                <img src="/images/logo.svg" class="h-10 mr-4" alt="TuniRepair Logo">
                <span class="self-center text-2xl font-bold whitespace-nowrap">Tuni repair</span> 
            </a>

            <h2 class="text-2xl lg:text-3xl font-bold text-black">Create a Free Account for Technician</h2>

            @if ($errors->any())
                <div class="bg-red-100 text-red-700 p-4 rounded">
                    <ul class="list-disc pl-4">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form class="mt-8 space-y-6" method="POST" action="{{ route('register.store') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="role" value="technician">

                <!-- First Name -->
                <div>
                    <x-input-label for="first_name" :value="__('First Name')" />
                    <x-text-input id="first_name" class="block mt-1 w-full" type="text" name="first_name" :value="old('first_name')" required autofocus />
                    <x-input-error :messages="$errors->get('first_name')" class="mt-2" />
                </div>

                <!-- Last Name -->
                <div>
                    <x-input-label for="last_name" :value="__('Last Name')" />
                    <x-text-input id="last_name" class="block mt-1 w-full" type="text" name="last_name" :value="old('last_name')" required />
                    <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
                </div>

                <!-- Address -->
                <div>
                    <x-input-label for="address" :value="__('Address')" />
                    <x-text-input id="address" class="block mt-1 w-full" type="text" name="address" :value="old('address')" required />
                    <x-input-error :messages="$errors->get('address')" class="mt-2" />
                </div>

                <!-- Gender -->
                <div>
                    <x-input-label for="gender" :value="__('Gender')" />
                    <select name="gender" id="gender" class="block mt-1 w-full rounded-lg border-gray-300" required>
                        <option value="">Select Gender</option>
                        <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                        <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                        <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>Other</option>
                    </select>
                    <x-input-error :messages="$errors->get('gender')" class="mt-2" />
                </div>

                <!-- Phone Number -->
                <div>
                    <x-input-label for="phone_number" :value="__('Phone Number')" />
                    <x-text-input id="phone_number" class="block mt-1 w-full" type="tel" name="phone_number" :value="old('phone_number')" required />
                    <x-input-error :messages="$errors->get('phone_number')" class="mt-2" />
                </div>

                <!-- Identity Document Upload -->
                <div>
                    <x-input-label for="identite_path" :value="__('Identity Document (PDF, JPG, PNG)')" />
                    <input type="file" id="identite_path" name="identite_path" class="block mt-1 w-full border-gray-300 rounded-lg p-2" accept=".pdf,.jpg,.jpeg,.png" required>
                    <x-input-error :messages="$errors->get('identite_path')" class="mt-2" />
                        @error('identite_path')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Certificate Document Upload -->
                <div>
                    <x-input-label for="certificat_path" :value="__('Certificate Document (PDF, JPG, PNG)')" />
                    <input type="file" id="certificat_path" name="certificat_path" class="block mt-1 w-full border-gray-300 rounded-lg p-2" accept=".pdf,.jpg,.jpeg,.png" required>
                    <x-input-error :messages="$errors->get('certificat_path')" class="mt-2" />
                        @error('certificat_path')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Email Address -->
                <div>
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div>
                    <x-input-label for="password" :value="__('Password')" />
                    <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Confirm Password -->
                <div>
                    <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                    <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                <!-- Terms -->
                <div class="flex items-start">
                    <div class="flex items-center h-5">
                        <input id="terms" name="terms" type="checkbox" required class="h-4 w-4 text-cyan-600 border-gray-300 rounded">
                    </div>
                    <div class="ml-2 text-sm">
                        <label for="terms" class="font-medium text-gray-900">I accept the <a href="#" class="text-teal-500 hover:underline">Terms and Conditions</a></label>
                    </div>
                </div>

                <!-- Submit -->
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