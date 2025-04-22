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

    <!-- Horizontal layout for specialties -->
    <div class="space-y-8">
        @forelse($groupedTechnicians as $specialty => $technicians)
            <div class="mb-8">
                <!-- Specialty title -->
                <h2 class="text-2xl font-bold text-gray-900 mb-6 border-b-2 border-cyan-600 pb-2">
                    {{ $specialty }}
                </h2>

                <!-- Horizontal scrolling container for technicians -->
                <div class="relative">
                    <div class="flex space-x-6 pb-4 overflow-x-auto scrollbar-hide">
                        @foreach($technicians as $technician)
                            <div class="flex-shrink-0 w-80 bg-white shadow-xl rounded-lg overflow-hidden transform transition-transform duration-300 hover:scale-105">
                                <div class="flex flex-row h-full">
                                    <!-- Technician photo -->
                                    <div class="w-1/3 h-auto">
                                        <img class="w-full h-full object-cover" 
                                             src="{{ asset('storage/' . $technician->user->photo) }}"
                                             alt="{{ $technician->user->first_name }} {{ $technician->user->last_name }}">
                                    </div>

                                    <!-- Technician details -->
                                    <div class="w-2/3 p-4 flex flex-col">
                                        <h2 class="text-lg font-semibold text-gray-900">
                                            {{ $technician->user->first_name }} {{ $technician->user->last_name }}
                                        </h2>
                                        <p class="text-xs text-gray-500 mt-1">{{ $technician->specialty }}</p>

                                        <!-- Description -->
                                        <p class="text-gray-700 mt-2 text-xs line-clamp-2">
                                            {{ Str::limit($technician->description, 60) }}
                                        </p>

                                        <!-- Rate -->
                                        <p class="text-md font-bold text-cyan-600 mt-2">{{ $technician->rate }}$/h</p>

                                        <!-- Availability -->
                                        <div class="mt-1">
                                            <span class="text-xs text-gray-600">
                                                <strong>Avail:</strong> {{ $technician->availability ? 'Yes' : 'No' }}
                                            </span>
                                        </div>

                                        <!-- Location -->
                                        <div class="mt-1">
                                            <span class="text-xs text-gray-600">
                                                <strong>Loc:</strong> {{ $technician->location }}
                                            </span>
                                        </div>

                                        <!-- View profile button -->
                                        <div class="mt-3">
                                            <a href="{{ route('technician.details', $technician->id) }}"
                                                class="text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium rounded-lg text-xs px-3 py-2 w-full text-center block">
                                               View
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-6">
                <p class="text-gray-600">No technician available at the moment.</p>
            </div>
        @endforelse
    </div>
</div>

<style>
    /* Hide scrollbar but allow scrolling */
    .scrollbar-hide::-webkit-scrollbar {
        display: none;
    }
    .scrollbar-hide {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
</style>
@endsection