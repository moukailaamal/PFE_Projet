@extends('layouts.app')

@section('title', 'Home')

@section('content')
<div class="container mx-auto px-4 py-8 mt-16">
    <!-- Titre et section de recherche -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-4">Find a Technician</h1>
        <form class="flex flex-col md:flex-row items-center space-y-4 md:space-y-0 md:space-x-4" method="GET" action="{{ route('home') }}">
            <!-- Champ de recherche par spécialité -->
            <input type="text" name="search" placeholder="Search by specialty..." 
                   class="w-full md:w-auto px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-600"
                   value="{{ request('search') }}">
        
            <!-- Sélection de la catégorie -->
            <select name="category_id" class="w-full md:w-auto px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-600">
                <option value="">All Categories</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        
            <!-- Sélection de la disponibilité -->
            <select name="availability" class="w-full md:w-auto px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-600">
                <option value="">All</option>
                <option value="available" {{ request('availability') == 'available' ? 'selected' : '' }}>Available now</option>
                <option value="unavailable" {{ request('availability') == 'unavailable' ? 'selected' : '' }}>Unavailable</option>
            </select>
        
            <!-- Champ de localisation -->
            <input type="text" name="location" placeholder="Location..." 
                   class="w-full md:w-auto px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-600"
                   value="{{ request('location') }}">
        
            <!-- Bouton de recherche -->
            <button type="submit" class="text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium rounded-lg text-base px-5 py-3 w-full sm:w-auto text-center">
                Search
            </button>
        </form>
    </div>

    <!-- Sections par spécialité -->
    @forelse($groupedTechnicians as $specialty => $technicians)
        <div class="mb-12">
            <!-- Titre de la spécialité -->
            <h2 class="text-2xl font-bold text-gray-900 mb-6 border-b-2 border-cyan-600 pb-2">
                {{ $specialty }}
            </h2>

            <!-- Liste des techniciens pour cette spécialité -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($technicians as $technician)
                    <div class="bg-white shadow-xl rounded-lg overflow-hidden transform transition-transform duration-300 hover:scale-105 h-full flex flex-col">
                        <!-- Photo du technicien -->
                        <div class="w-full h-64 flex items-center justify-center bg-gray-100">
                            <img class="w-full h-full object-cover" 
                                 src="{{ asset('storage/' . $technician->user->photo) }}"
                                 alt="{{ $technician->user->first_name }} {{ $technician->user->last_name }}">
                        </div>

                        <!-- Détails du technicien -->
                        <div class="p-6 flex flex-col flex-grow">
                            <h2 class="text-xl font-semibold text-gray-900">
                                {{ $technician->user->first_name }} {{ $technician->user->last_name }}
                            </h2>
                            <p class="text-sm text-gray-500 mt-1">{{ $technician->specialty }}</p>

                            <!-- Description -->
                            <p class="text-gray-700 mt-2 text-sm line-clamp-3">
                                {{ Str::limit($technician->description, 100) }}
                            </p>

                            <!-- Taux horaire -->
                            <p class="text-lg font-bold text-cyan-600 mt-3">{{ $technician->rate }}$/h</p>

                            <!-- Disponibilité -->
                            <div class="flex items-center mt-2">
                                <span class="text-sm text-gray-600">
                                    <strong>Availability :</strong> {{ $technician->availability ? 'Available' : 'Unavailable' }}
                                </span>
                            </div>

                            <!-- Localisation -->
                            <div class="flex items-center mt-2">
                                <span class="text-sm text-gray-600">
                                    <strong>Location :</strong> {{ $technician->location }}
                                </span>
                            </div>

                            <!-- Bouton pour voir le profil -->
                            <div class="mt-4">
                                <a href="{{ route('technician.details', $technician->id) }}"
                                    class="text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium rounded-lg text-base px-5 py-3 w-full text-center block">
                                   View profile
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @empty
        <div class="col-span-full text-center py-6">
            <p class="text-gray-600">No technician available at the moment.</p>
        </div>
    @endforelse
</div>
@endsection