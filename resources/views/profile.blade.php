@extends('layouts.app')

@section('title', 'My Account')

@section('content')
<div class="min-h-screen flex flex-col justify-center items-center px-6 pt-8">
    <!-- Card -->
    <div class="bg-white shadow-lg rounded-lg md:mt-0 w-full sm:max-w-screen-sm xl:p-0">
        <div class="p-6 sm:p-8 lg:p-16 space-y-8">
            <!-- Logo et Titre -->
            <a href="/" class="text-2xl font-semibold flex justify-center items-center mb-8 lg:mb-10">
                <img src="/images/logo.svg" class="h-10 mr-4" alt="TuniRepair Logo">
                <span class="self-center text-2xl font-bold whitespace-nowrap">Tuni Repair</span> 
            </a>
            <h2 class="text-2xl lg:text-3xl font-bold text-black">
                My Personal Information
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
        
            <form class="mt-8 space-y-6" method="POST" action="{{ route('profile.update', $user->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Prénom -->
                <div>
                    <label for="first_name" class="text-sm font-medium text-gray-900 block mb-2">Your First Name</label>
                    <input type="text" name="first_name" id="first_name" value="{{ old('first_name', $user->first_name) }}" 
                        class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5" required>
                        @error('first_name')
                        <div class="text-red-500">{{ $message }}</div>
                    @enderror
                    </div>

                <!-- Nom -->
                <div>
                    <label for="last_name" class="text-sm font-medium text-gray-900 block mb-2">Your Last Name</label>
                    <input type="text" name="last_name" id="last_name" value="{{ old('last_name', $user->last_name) }}" 
                        class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5" required>
                        @error('last_name')
                        <div class="text-red-500">{{ $message }}</div>
                    @enderror
                    </div>

                <!-- Adresse -->
                <div>
                    <label for="address" class="text-sm font-medium text-gray-900 block mb-2">Address</label>
                    <input type="text" name="address" id="address" value="{{ old('address', $user->address) }}" 
                        class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5" required>
                
                        @error('address')
                        <div class="text-red-500">{{ $message }}</div>
                    @enderror
                    </div>

                <!-- Sexe -->
                <div>
                    <label for="gender" class="text-sm font-medium text-gray-900 block mb-2">Gender</label>
                    <select name="gender" id="gender" 
                        class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5">
                        <option value="male" {{ old('gender', $user->gender) == 'male' ? 'selected' : '' }}>Male</option>
                        <option value="female" {{ old('gender', $user->gender) == 'female' ? 'selected' : '' }}>Female</option>
                        <option value="other" {{ old('gender', $user->gender) == 'other' ? 'selected' : '' }}>Other</option>
                    </select>
                    @error('gender')
                    <div class="text-red-500">{{ $message }}</div>
                @enderror
                </div>

                <!-- Numéro de téléphone -->
                <div>
                    <label for="phone_number" class="text-sm font-medium text-gray-900 block mb-2">Phone Number</label>
                    <input type="tel" name="phone_number" id="phone_number" value="{{ old('phone_number', $user->phone_number) }}" 
                        class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5" required>
                        @error('phone_number')
                        <div class="text-red-500">{{ $message }}</div>
                    @enderror
                    </div>

                <!-- Email -->
                <div>
                    <label for="email" class="text-sm font-medium text-gray-900 block mb-2">Your Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" 
                        class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5" required>
                        @error('email')
                        <div class="text-red-500">{{ $message }}</div>
                    @enderror
                    </div>

                @if ($user->role == 'technician')

                    <!-- Specialty -->
                    <div>
                        <label for="specialty" class="text-sm font-medium text-gray-900 block mb-2">Specialty</label>
                        <input type="text" name="specialty" id="specialty" value="{{ old('specialty', $technician->specialty ?? '') }}" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5" required>
                        @error('specialty')
                        <div class="text-red-500">{{ $message }}</div>
                    @enderror
                    </div>
                <!-- rate -->
                <div>
                    <label for="rate" class="text-sm font-medium text-gray-900 block mb-2">rate</label>
                    <input type="text" name="rate" id="rate" value="{{ old('rate', $technician->rate ?? '') }}" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5" required>
                    @error('rate')
                    <div class="text-red-500">{{ $message }}</div>
                @enderror
                </div>

                    <!-- Availability -->
                    <div>
                        <label for="availability" class="text-sm font-medium text-gray-900 block mb-2">Availability</label>
                        <input type="text" name="availability" id="availability" value="{{ old('availability', $technician->availability ?? '') }}" 
                            class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5" required>
                            @error('availability')
                            <div class="text-red-500">{{ $message }}</div>
                        @enderror
                        </div>
                    
                    <!-- Description -->
                    <div>
                        <label for="description" class="text-sm font-medium text-gray-900 block mb-2">Description</label>
                        <input type="text" name="description" id="description" value="{{ old('description', $technician->description ?? '') }}" 
                            class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5" required>
                            @error('description')
                            <div class="text-red-500">{{ $message }}</div>
                        @enderror
                        </div>

                    <!-- Identity Document -->
                    <div>
                        <label for="identite_path" class="text-sm font-medium text-gray-900 block mb-2">Identity Document (PDF, JPG, PNG)</label>
                        <input type="file" id="identite_path" name="identite_path" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5">
                        @error('identite_path')
                        <div class="text-red-500">{{ $message }}</div>
                    @enderror
                    </div>

                    <!-- Certificat -->
                    <div>
                        <label for="certificat_path" class="text-sm font-medium text-gray-900 block mb-2">Certificate (PDF, JPG, PNG)</label>
                        <input type="file" id="certificat_path" name="certificat_path" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5">
                        @error('certificat_path')
                        <div class="text-red-500">{{ $message }}</div>
                    @enderror
                    </div>

                @endif

                    <!-- Photo -->
                    <div>
                        <label for="photo" class="text-sm font-medium text-gray-900 block mb-2">Photo (PDF, JPG, PNG)</label>
                        <input type="file"value="{{ old('photo', $technician->photo ?? '') }}"  id="photo" name="photo" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5">
                        @error('photo')
                        <div class="text-red-500">{{ $message }}</div>
                    @enderror
                    </div>
                <div class="flex justify-between">
                    <button type="reset" class="w-1/2 bg-gray-400 text-white p-2 rounded-lg">Cancel</button>
                    <button type="submit" class="w-1/2 bg-cyan-600 text-white p-2 rounded-lg">Update Profile</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
