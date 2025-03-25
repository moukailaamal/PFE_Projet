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

            <!-- Affichage des erreurs -->
            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Formulaire -->
            <form id="technician-form" class="mt-8 space-y-6" method="POST" action="{{ route('profile.update', $user->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Prénom -->
                
                <div>
                    <label for="first_name" class="text-sm font-medium text-gray-900 block mb-2">Your First Name</label>
                    <input type="text" name="first_name" id="first_name" value="{{ old('first_name', $user->first_name) }}"
                        class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5" required>
                    @error('first_name')
                        <div class="text-red-500 mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Nom -->
                <div>
                    <label for="last_name" class="text-sm font-medium text-gray-900 block mb-2">Your Last Name</label>
                    <input type="text" name="last_name" id="last_name" value="{{ old('last_name', $user->last_name) }}"
                        class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5" required>
                    @error('last_name')
                        <div class="text-red-500 mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Adresse -->
                <div>
                    <label for="address" class="text-sm font-medium text-gray-900 block mb-2">Address</label>
                    <input type="text" name="address" id="address" value="{{ old('address', $user->address) }}"
                        class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5" required>
                    @error('address')
                        <div class="text-red-500 mt-2">{{ $message }}</div>
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
                        <div class="text-red-500 mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Numéro de téléphone -->
                <div>
                    <label for="phone_number" class="text-sm font-medium text-gray-900 block mb-2">Phone Number</label>
                    <input type="tel" name="phone_number" id="phone_number" value="{{ old('phone_number', $user->phone_number) }}"
                        class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5" required>
                    @error('phone_number')
                        <div class="text-red-500 mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="text-sm font-medium text-gray-900 block mb-2">Your Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                        class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5" required>
                    @error('email')
                        <div class="text-red-500 mt-2">{{ $message }}</div>
                    @enderror
                </div>

                    <!-- Photo -->
                <div>
                    <label for="photo" class="text-sm font-medium text-gray-900 block mb-2">Photo (JPG, PNG)</label>
                    <input type="file" id="photo" name="photo" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5">
                    @error('photo')
                        <div class="text-red-500 mt-2">{{ $message }}</div>
                    @enderror
                </div>
                <!-- Section Technicien -->
                @if(Auth::user()->role == "technician")
                <!-- Specialty -->
                    <div>
                        <label for="specialty" class="text-sm font-medium text-gray-900 block mb-2">Specialty</label>
                        <input type="text" name="specialty" id="specialty" value="{{ old('specialty', $technician->specialty ?? '') }}"
                            class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5" required>
                        @error('specialty')
                            <div class="text-red-500 mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Rate -->
                    <div>
                        <label for="rate" class="text-sm font-medium text-gray-900 block mb-2">Rate</label>
                        <input type="text" name="rate" id="rate" value="{{ old('rate', $technician->rate ?? '') }}"
                            class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5" required>
                        @error('rate')
                            <div class="text-red-500 mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Location -->
                    <div>
                        <label for="location" class="text-sm font-medium text-gray-900 block mb-2">Location</label>
                        <input type="text" name="location" id="location" value="{{ old('location', $technician->location ?? '') }}"
                            class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5" required>
                        @error('location')
                            <div class="text-red-500 mt-2">{{ $message }}</div>
                        @enderror
                    </div>

               


                    <div id="availability-form" class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Your availability</label>
                        <div class="mt-2 space-y-4">
                            <!-- Conteneur pour les champs de saisie -->
                            <div class="flex flex-col space-y-4 sm:flex-row sm:space-x-4 sm:space-y-0">
                                <!-- Jour -->
                                <select name="day" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg p-2 flex-1">
                                    <option value="Monday">Monday</option>
                                    <option value="Tuesday">Tuesday</option>
                                    <option value="Wednesday">Wednesday</option>
                                    <option value="Thursday">Thursday</option>
                                    <option value="Friday">Friday</option>
                                    <option value="Saturday">Saturday</option>
                                    <option value="Sunday">Sunday</option>
                                </select>
                    
                                <!-- Heure de début -->
                                <input type="time" name="start_time" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg p-2 flex-1">
                    
                                <!-- Heure de fin -->
                                <input type="time" name="end_time" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg p-2 flex-1">
                    
                                <!-- Bouton Ajouter -->
                                <button type="button" onclick="addAvailability()" class="bg-blue-500 text-white p-2 rounded-lg sm:w-auto w-full">
                                    Add
                                </button>
                            </div>
                        </div>
                    
                        <!-- Liste des disponibilités ajoutées -->
                        <div id="availability-list" class="mt-4 space-y-2">
                            <!-- Les anciennes disponibilités seront affichées ici -->
                        </div>
                    
                        <!-- Champ caché pour stocker les disponibilités au format JSON -->
                        <textarea id="availability" name="availability" class="hidden">{{ old('availability', $technician->availability ?? '[]') }}</textarea>
                    </div>
    
        

            
                    <!-- Description -->
                    <div>
                        <label for="description" class="text-sm font-medium text-gray-900 block mb-2">Description</label>
                        <textarea name="description" id="description"
                            class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5" required>{{ old('description', $technician->description ?? '') }}</textarea>
                        @error('description')
                            <div class="text-red-500 mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Category -->
                    <div>
                        <label for="category_id" class="text-sm font-medium text-gray-900 block mb-2">Category</label>
                        <select name="category_id" id="category_id"
                            class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5" required>
                            @foreach ($catgories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', $technician->category_id ?? '') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <div class="text-red-500 mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Identity Document -->
                    <div>
                        <label for="identite_path" class="text-sm font-medium text-gray-900 block mb-2">Identity Document (PDF, JPG, PNG)</label>
                        <input type="file" id="identite_path" name="identite_path"
                            class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5">
                        @error('identite_path')
                            <div class="text-red-500 mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Certificat -->
                    <div>
                        <label for="certificat_path" class="text-sm font-medium text-gray-900 block mb-2">Certificate (PDF, JPG, PNG)</label>
                        <input type="file" id="certificat_path" name="certificat_path"
                            class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5">
                        @error('certificat_path')
                            <div class="text-red-500 mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                @endif

                <!-- Boutons -->
                <div class="flex justify-between">
                    <button type="reset" class="w-1/2 bg-gray-400 text-white p-2 rounded-lg hover:bg-gray-500">Cancel</button>
                    <button type="submit" class="w-1/2 bg-cyan-600 text-white p-2 rounded-lg hover:bg-cyan-700">Update Profile</button>
                </div>
            </form>
        </div>
    </div>
</div>


<script>
    // Récupérer les anciennes valeurs depuis le champ caché
    const availabilityJSON = document.getElementById('availability').value;
    let availabilities = JSON.parse(availabilityJSON);

    // Afficher les anciennes disponibilités au chargement de la page
    document.addEventListener('DOMContentLoaded', function () {
        updateAvailabilityList();
    });

    function addAvailability() {
        const day = document.querySelector('select[name="day"]').value;
        const startTime = document.querySelector('input[name="start_time"]').value;
        const endTime = document.querySelector('input[name="end_time"]').value;

        if (!day || !startTime || !endTime) {
            alert('Please fill in all fields.');
            return;
        }

        // Vérifier si la date existe déjà
        const isDuplicate = availabilities.some(avail => avail.day === day);
        if (isDuplicate) {
            alert('This day already exists in your availability. Please choose another day.');
            return;
        }

        // Ajouter la nouvelle disponibilité
        const availability = { day, start_time: startTime, end_time: endTime };
        availabilities.push(availability);

        updateAvailabilityList();
        updateAvailabilityJSON();
    }

    function updateAvailabilityList() {
        const list = document.getElementById('availability-list');
        list.innerHTML = availabilities.map((avail, index) => `
            <div class="flex items-center justify-between bg-gray-50 p-2 rounded-lg">
                <span>${avail.day}: ${avail.start_time} - ${avail.end_time}</span>
                <button type="button" onclick="removeAvailability(${index})" class="text-red-500 hover:text-red-700">
                    Remove
                </button>
            </div>
        `).join('');
    }

    function removeAvailability(index) {
        availabilities.splice(index, 1);
        updateAvailabilityList();
        updateAvailabilityJSON();
    }

    function updateAvailabilityJSON() {
        document.getElementById('availability').value = JSON.stringify(availabilities);
    }
</script>

@endsection