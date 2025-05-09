@extends('layouts.app')

@section('title', 'Client List')

@include('layouts.partials.navbar-dashboard')  
@section('sidebar')
        @include('layouts.partials.sidebar')
    @endsection
@section('content')
<div class="container mx-auto p-4 mt-16">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Client List</h1>
        
    </div>

  
    @if($clients->isEmpty())
        <p class="text-gray-500">No client accounts found.</p>
    @else
        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Client</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Phone</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($clients as $client)
                        <tr class="hover:bg-gray-50">
                            <!-- Admin Info -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <img class="h-10 w-10 rounded-full border-2 border-gray-300" 
                                             src="{{ $client->photo ? asset('storage/' . $client->photo) : asset('images/default-avatar.png') }}" 
                                             alt="Profile">
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ $client->first_name }} {{ $client->last_name }}
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            {{ $client->role }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            
                            <!-- Email -->
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $client->email }}
                            </td>
                            
                            <!-- Phone number -->
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $client->phone_number ?? 'N/A' }}
                            </td>
                            
                            <!-- Actions -->
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    @if(auth()->user()->role === 'admin' || auth()->user()->role === 'superAdmin')
                                        <form action="{{ route('admin.clients.destroy', $client) }}" method="POST" 
                                              onsubmit="return confirmAction('Are you sure you want to delete this client?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900">
                                                Delete
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        @if($clients->hasPages())
            <div class="mt-4">
                {{ $clients->links() }}
            </div>
        @endif
    @endif
</div>

<!-- Confirmation Script -->
<script>
    function confirmAction(message) {
        return confirm(message);
    }
</script>
@endsection