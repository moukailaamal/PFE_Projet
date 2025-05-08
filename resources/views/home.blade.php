@extends('layouts.app')

@section('title', 'Home')

@include('layouts.partials.navbar-dashboard')  
@auth 
@include('layouts.partials.sidebar') 
@endauth
@section('content')
<div class="container mx-auto px-4 py-8 mt-16">
    <!-- Title and search section -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-6">Find the Perfect Technician</h1>
        
        <!-- Search Form -->
        <form class="bg-white p-6 rounded-xl shadow-md" method="GET" action="{{ route('home') }}">
            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-6 gap-4">
                <!-- Search by specialty -->
                <div class="col-span-1 md:col-span-3 lg:col-span-2">
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Specialty</label>
                    <input type="text" name="search" id="search" placeholder="Electrician, Plumber, etc..." 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-600 focus:border-transparent transition"
                           value="{{ request('search') }}">
                </div>
                
                <!-- Category selection -->
                <div>
                    <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                    <select name="category_id" id="category_id" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-600 focus:border-transparent transition">
                        <option value="">All Categories</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <!-- Location -->
                <div>
                    <label for="location" class="block text-sm font-medium text-gray-700 mb-1">Location</label>
                    <input type="text" name="location" id="location" placeholder="City, State" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-600 focus:border-transparent transition"
                           value="{{ request('location') }}">
                </div>
                
                <!-- Price Range -->
                <div>
                    <label for="price_range" class="block text-sm font-medium text-gray-700 mb-1">Price Range</label>
                    <select name="price_range" id="price_range" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-600 focus:border-transparent transition">
                        <option value="">Any Price</option>
                        <option value="0-50" {{ request('price_range') == '0-50' ? 'selected' : '' }}>$0 - $50/h</option>
                        <option value="50-100" {{ request('price_range') == '50-100' ? 'selected' : '' }}>$50 - $100/h</option>
                        <option value="100-200" {{ request('price_range') == '100-200' ? 'selected' : '' }}>$100 - $200/h</option>
                        <option value="200+" {{ request('price_range') == '200+' ? 'selected' : '' }}>Over $200/h</option>
                    </select>
                </div>
               

               
            
            <!-- Search button -->
            <div class="mt-6 flex justify-end">
                <button type="submit" 
                        class="px-6 py-3 bg-cyan-600 hover:bg-cyan-700 text-white font-medium rounded-lg shadow-md transition duration-300 ease-in-out transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-cyan-600 focus:ring-opacity-50">
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        Search Technicians
                    </div>
                </button>
            </div>
        </form>
    </div>

    <!-- Results section -->
    <div class="space-y-8">
        @forelse($groupedTechnicians as $specialty => $technicians)
            <div class="mb-8">
                <!-- Specialty title -->
                <div class="flex items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-900">{{ $specialty }}</h2>
                    <span class="ml-2 px-3 py-1 bg-cyan-100 text-cyan-800 text-sm font-medium rounded-full">
                        {{ count($technicians) }} {{ Str::plural('technician', count($technicians)) }}
                    </span>
                </div>

                <!-- Technicians grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @foreach($technicians as $technician)
                        <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                            <div class="flex flex-col h-full">
                                <!-- Technician photo -->
                                <div class="h-48 overflow-hidden">
                                    <img class="w-full h-full object-cover transition-transform duration-500 hover:scale-110" 
                                         src="{{ asset('storage/' . $technician->user->photo) }}"
                                         alt="{{ $technician->user->first_name }} {{ $technician->user->last_name }}">
                                </div>

                                <!-- Technician details -->
                                <div class="p-5 flex-1 flex flex-col">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <h3 class="text-lg font-semibold text-gray-900">
                                                {{ $technician->user->first_name }} {{ $technician->user->last_name }}
                                            </h3>
                                            <p class="text-sm text-gray-500">{{ $technician->specialty }}</p>
                                        </div>
                                        <span class="px-2 py-1 bg-cyan-600 text-white text-xs font-bold rounded-full">
                                            {{ $technician->price }}$/h
                                        </span>
                                    </div>

                                    <!-- Description -->
                                    <p class="text-gray-700 mt-3 text-sm line-clamp-2">
                                        {{ Str::limit($technician->description, 80) }}
                                    </p>

                                    <!-- Meta information -->
                                    <div class="mt-4 grid grid-cols-2 gap-2 text-xs">
                                        <div class="flex items-center text-gray-600">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                            {{ $technician->location }}
                                        </div>
                                        <div class="flex items-center text-gray-600">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                            </svg>
                                            {{ ucfirst($technician->service_type) }}
                                        </div>
                                        <div class="flex items-center text-gray-600">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            {{ $technician->availability ? 'Available' : 'Not Available' }}
                                        </div>
                                        <div class="flex items-center text-gray-600">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                            </svg>
                                            4.8 (24 reviews)
                                        </div>
                                    </div>

                                    <!-- View profile button -->
                                    <div class="mt-5 pt-4 border-t border-gray-200">
                                        <a href="{{ route('technician.details', $technician->user) }}"
                                           class="w-full flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-cyan-600 hover:bg-cyan-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-cyan-500 transition">
                                            View Profile
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @empty
            <div class="bg-white rounded-xl shadow-md p-8 text-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <h3 class="mt-4 text-lg font-medium text-gray-900">No technicians found</h3>
                <p class="mt-2 text-gray-600">Try adjusting your search filters to find what you're looking for.</p>
                <button onclick="window.location.href='{{ route('home') }}'" 
                        class="mt-4 px-4 py-2 bg-cyan-600 text-white rounded-lg hover:bg-cyan-700 transition">
                    Reset Filters
                </button>
            </div>
        @endforelse
    </div>
</div>
@endsection