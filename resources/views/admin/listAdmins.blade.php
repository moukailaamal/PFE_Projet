@extends('layouts.app')

@section('title', 'Admin List')

@include('layouts.partials.navbar-dashboard')  
@section('sidebar')
        @include('layouts.partials.sidebar')
    @endsection
@section('content')
<div class="container mx-auto p-4 mt-16">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Admin List</h1>
        @can('create', App\Models\User::class)
            <a href="{{ route('admin.register') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg">
                Add New Admin
            </a>
        @endcan
    </div>

  
    @if($admins->isEmpty())
        <p class="text-gray-500">No admin accounts found.</p>
    @else
        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Admin</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Phone</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($admins as $admin)
                        <tr class="hover:bg-gray-50">
                            <!-- Admin Info -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <img class="h-10 w-10 rounded-full border-2 border-gray-300" 
                                             src="{{ $admin->photo ? asset('storage/' . $admin->photo) : asset('images/default-avatar.png') }}" 
                                             alt="Profile">
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ $admin->first_name }} {{ $admin->last_name }}
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            {{ $admin->role }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            
                            <!-- Email -->
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $admin->email }}
                            </td>
                            
                            <!-- Phone number -->
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $admin->phone_number ?? 'N/A' }}
                            </td>
                            
                            <!-- Actions -->
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    @can('delete', $admin)
                                        <form action="{{ route('admin.users.destroy', $admin) }}" method="POST" 
                                              onsubmit="return confirmAction('Are you sure you want to delete this admin?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900">
                                                Delete
                                            </button>
                                        </form>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        @if($admins->hasPages())
            <div class="mt-4">
                {{ $admins->links() }}
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